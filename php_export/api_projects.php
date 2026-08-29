<?php
// api_projects.php - REST API for Projects Management

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';

try {
    $db = getDB();
    
    if (!$db) {
        throw new Exception('Database connection failed');
    }
    
    if ($method === 'GET') {
        if ($action === 'all') {
            // Get all projects
            $stmt = $db->prepare("SELECT * FROM projects ORDER BY created_at DESC");
            $stmt->execute();
            $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Transform data for frontend
            $transformed = array_map('transformProject', $projects);
            echo json_encode(['success' => true, 'data' => $transformed]);
        }
        else if ($action === 'by_status' && isset($_GET['status'])) {
            // Get projects by status
            $status = $_GET['status'];
            $stmt = $db->prepare("SELECT * FROM projects WHERE status = ? ORDER BY created_at DESC");
            $stmt->execute([$status]);
            $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $transformed = array_map('transformProject', $projects);
            echo json_encode(['success' => true, 'data' => $transformed]);
        }
        else if ($id) {
            // Get single project by ID
            $stmt = $db->prepare("SELECT * FROM projects WHERE id = ?");
            $stmt->execute([$id]);
            $project = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($project) {
                echo json_encode(['success' => true, 'data' => transformProject($project)]);
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'error' => 'Project not found']);
            }
        }
        else if ($action === 'stats') {
            // Get project statistics
            $stmt = $db->query("SELECT COUNT(*) as total FROM projects");
            $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            $stmt = $db->query("SELECT status, COUNT(*) as count FROM projects GROUP BY status");
            $statusCounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $stmt = $db->query("SELECT SUM(CAST(REPLACE(REPLACE(budget, ' ETB', ''), ',', '') AS DECIMAL(20,2))) as total_budget FROM projects");
            $totalBudget = $stmt->fetch(PDO::FETCH_ASSOC)['total_budget'] ?? 0;
            
            echo json_encode([
                'success' => true,
                'data' => [
                    'total_projects' => (int)$total,
                    'status_counts' => $statusCounts,
                    'total_budget' => number_format($totalBudget, 2) . ' ETB'
                ]
            ]);
        }
        else {
            // Default: get all projects
            $stmt = $db->prepare("SELECT * FROM projects ORDER BY created_at DESC");
            $stmt->execute();
            $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $transformed = array_map('transformProject', $projects);
            echo json_encode(['success' => true, 'data' => $transformed]);
        }
    }
    else if ($method === 'POST' && $action === 'create') {
        // Create new project
        // Check if FormData was used (multipart/form-data) or JSON
        $input = $_POST;
        if (empty($input)) {
            $input = json_decode(file_get_contents('php://input'), true);
        }
        
        // If still empty, try to get from raw input
        if (empty($input)) {
            parse_str(file_get_contents('php://input'), $input);
        }
        
        // Debug: Log the input
        error_log('Project POST input: ' . print_r($input, true));
        
        // Check required fields
        $required = ['name_en', 'name_om', 'name_am'];
        foreach ($required as $field) {
            if (empty($input[$field])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => "Missing required field: $field"]);
                exit;
            }
        }
        
        $id = 'proj-' . time() . '-' . bin2hex(random_bytes(4));
        $category = isset($input['category']) && !empty($input['category']) ? $input['category'] : 'General';
        $image = '';
        
        // Handle image upload
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/projects/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $extension = pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
            $fileName = time() . '_' . substr(md5(uniqid()), 0, 8) . '.' . $extension;
            $targetPath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['image_file']['tmp_name'], $targetPath)) {
                $image = $targetPath;
            }
        } else if (isset($input['image']) && !empty($input['image'])) {
            $image = $input['image'];
        }
        
        // Get values from input
        $name_en = isset($input['name_en']) ? $input['name_en'] : '';
        $name_om = isset($input['name_om']) ? $input['name_om'] : '';
        $name_am = isset($input['name_am']) ? $input['name_am'] : '';
        $description_en = isset($input['description_en']) ? $input['description_en'] : '';
        $description_om = isset($input['description_om']) ? $input['description_om'] : '';
        $description_am = isset($input['description_am']) ? $input['description_am'] : '';
        $status = isset($input['status']) ? $input['status'] : 'planning';
        $progress = isset($input['progress']) ? (int)$input['progress'] : 0;
        $budget = isset($input['budget']) ? $input['budget'] : '0 ETB';
        $manager = isset($input['manager']) ? $input['manager'] : '';
        $kebele = isset($input['kebele']) ? $input['kebele'] : '';
        
        $stmt = $db->prepare("INSERT INTO projects (id, category, name_en, name_om, name_am, description_en, description_om, description_am, status, progress, budget, manager, kebele, image, created_at) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([
            $id,
            $category,
            $name_en,
            $name_om,
            $name_am,
            $description_en,
            $description_om,
            $description_am,
            $status,
            $progress,
            $budget,
            $manager,
            $kebele,
            $image
        ]);
        
        http_response_code(201);
        echo json_encode(['success' => true, 'message' => 'Project created', 'id' => $id]);
    }
    else if ($method === 'PUT' && $action === 'update' && $id) {
        // Update existing project
        $input = json_decode(file_get_contents('php://input'), true);
        if (empty($input)) {
            $input = $_POST;
        }
        
        // Check if project exists
        $stmt = $db->prepare("SELECT id FROM projects WHERE id = ?");
        $stmt->execute([$id]);
        if (!$stmt->fetch()) {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'Project not found']);
            exit;
        }
        
        $updates = [];
        $params = [];
        
        $fields = ['category', 'name_en', 'name_om', 'name_am', 'description_en', 'description_om', 'description_am', 'status', 'progress', 'budget', 'manager', 'kebele'];
        foreach ($fields as $field) {
            if (isset($input[$field])) {
                $updates[] = "$field = ?";
                $params[] = $input[$field];
            }
        }
        
        // Handle image upload for update
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/projects/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $extension = pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
            $fileName = time() . '_' . substr(md5(uniqid()), 0, 8) . '.' . $extension;
            $targetPath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['image_file']['tmp_name'], $targetPath)) {
                $updates[] = "image = ?";
                $params[] = $targetPath;
            }
        } else if (isset($input['image']) && !empty($input['image'])) {
            $updates[] = "image = ?";
            $params[] = $input['image'];
        }
        
        if (empty($updates)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'No fields to update']);
            exit;
        }
        
        $params[] = $id;
        $query = "UPDATE projects SET " . implode(', ', $updates) . ", updated_at = NOW() WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute($params);
        
        echo json_encode(['success' => true, 'message' => 'Project updated']);
    }
    else if ($method === 'DELETE' && $action === 'delete' && $id) {
        // Delete project
        $stmt = $db->prepare("SELECT id FROM projects WHERE id = ?");
        $stmt->execute([$id]);
        if (!$stmt->fetch()) {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'Project not found']);
            exit;
        }
        
        $stmt = $db->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->execute([$id]);
        
        echo json_encode(['success' => true, 'message' => 'Project deleted']);
    }
    else {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid request']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

// Helper function to transform database project to frontend format
function transformProject($project) {
    // Get the full URL for the image
    $imageUrl = null;
    if (!empty($project['image'])) {
        // If the image path is already a full URL, use it
        if (filter_var($project['image'], FILTER_VALIDATE_URL)) {
            $imageUrl = $project['image'];
        } else {
            // Remove any leading slashes and prepend the base URL
            $imagePath = ltrim($project['image'], '/');
            // Check if it already starts with 'uploads/'
            if (strpos($imagePath, 'uploads/') !== 0) {
                $imagePath = 'uploads/projects/' . basename($imagePath);
            }
            // Get base URL dynamically
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'];
            $baseUrl = $protocol . '://' . $host . '/agaro/php_export/';
            $imageUrl = $baseUrl . $imagePath;
        }
    }
    
    return [
        'id' => $project['id'],
        'category' => $project['category'] ?? 'General',
        'name' => [
            'en' => $project['name_en'] ?? '',
            'om' => $project['name_om'] ?? '',
            'am' => $project['name_am'] ?? ''
        ],
        'description' => [
            'en' => $project['description_en'] ?? '',
            'om' => $project['description_om'] ?? '',
            'am' => $project['description_am'] ?? ''
        ],
        'status' => $project['status'] ?? 'planning',
        'progress' => (int)($project['progress'] ?? 0),
        'budget' => $project['budget'] ?? '0 ETB',
        'manager' => $project['manager'] ?? '',
        'kebele' => $project['kebele'] ?? '',
        'image' => $imageUrl, // Return full URL
        'created_at' => $project['created_at'] ?? null,
        'updated_at' => $project['updated_at'] ?? null
    ];
}
?>