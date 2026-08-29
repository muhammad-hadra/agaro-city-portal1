<?php
// api_news.php - REST API for News Management

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
            // Get all news articles ordered by date (newest first)
            $stmt = $db->prepare("SELECT * FROM news ORDER BY date DESC");
            $stmt->execute();
            $news = $stmt->fetchAll();
            // Transform data for frontend
            $transformed = array_map('transformNews', $news);
            echo json_encode(['success' => true, 'data' => $transformed]);
        } 
        else if ($action === 'latest') {
            // Get latest X news articles
            $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 6;
            $stmt = $db->prepare("SELECT * FROM news ORDER BY date DESC LIMIT ?");
            $stmt->bindValue(1, $limit, PDO::PARAM_INT);
            $stmt->execute();
            $news = $stmt->fetchAll();
            $transformed = array_map('transformNews', $news);
            echo json_encode(['success' => true, 'data' => $transformed]);
        }
        else if ($id) {
            // Get single news article by ID
            $stmt = $db->prepare("SELECT * FROM news WHERE id = ?");
            $stmt->execute([$id]);
            $article = $stmt->fetch();
            
            if ($article) {
                echo json_encode(['success' => true, 'data' => transformNews($article)]);
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'error' => 'News article not found']);
            }
        }
        else if ($action === 'category') {
            // Get news by category
            $category = isset($_GET['category']) ? $_GET['category'] : '';
            $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
            $stmt = $db->prepare("SELECT * FROM news WHERE category = ? ORDER BY date DESC LIMIT ?");
            $stmt->bindValue(1, $category);
            $stmt->bindValue(2, $limit, PDO::PARAM_INT);
            $stmt->execute();
            $news = $stmt->fetchAll();
            $transformed = array_map('transformNews', $news);
            echo json_encode(['success' => true, 'data' => $transformed]);
        }
        else {
            // Default: get all news
            $stmt = $db->prepare("SELECT * FROM news ORDER BY date DESC");
            $stmt->execute();
            $news = $stmt->fetchAll();
            $transformed = array_map('transformNews', $news);
            echo json_encode(['success' => true, 'data' => $transformed]);
        }
    }
    
    else if ($method === 'POST' && $action === 'create') {
        // Create new news article
        // Check if FormData was used (multipart/form-data) or JSON
        $input = $_POST;
        if (empty($input)) {
            $input = json_decode(file_get_contents('php://input'), true);
        }
        
        // If still empty, try to get from raw input
        if (empty($input)) {
            parse_str(file_get_contents('php://input'), $input);
        }
        
        // Debug: Log the input to see what's being received
        error_log('News POST input: ' . print_r($input, true));
        
        // Check required fields - only title fields are required, category is optional
        $required = ['title_en', 'title_om', 'title_am'];
        foreach ($required as $field) {
            if (empty($input[$field])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => "Missing required field: $field"]);
                exit;
            }
        }
        
        $id = 'news-' . time() . '-' . bin2hex(random_bytes(4));
        
        // Get category - use default if not provided
        $category = isset($input['category']) && !empty($input['category']) ? $input['category'] : 'General';
        $date = isset($input['date']) && !empty($input['date']) ? $input['date'] : date('Y-m-d');
        $image = '';
        
        // Handle image upload
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/news/';
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
        
        $title_en = isset($input['title_en']) ? $input['title_en'] : '';
        $title_om = isset($input['title_om']) ? $input['title_om'] : '';
        $title_am = isset($input['title_am']) ? $input['title_am'] : '';
        $excerpt_en = isset($input['excerpt_en']) ? $input['excerpt_en'] : '';
        $excerpt_om = isset($input['excerpt_om']) ? $input['excerpt_om'] : '';
        $excerpt_am = isset($input['excerpt_am']) ? $input['excerpt_am'] : '';
        $content_en = isset($input['content_en']) ? $input['content_en'] : '';
        $content_om = isset($input['content_om']) ? $input['content_om'] : '';
        $content_am = isset($input['content_am']) ? $input['content_am'] : '';
        
        $stmt = $db->prepare("INSERT INTO news (id, category, date, image, title_en, title_om, title_am, excerpt_en, excerpt_om, excerpt_am, content_en, content_om, content_am) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $id,
            $category,
            $date,
            $image,
            $title_en,
            $title_om,
            $title_am,
            $excerpt_en,
            $excerpt_om,
            $excerpt_am,
            $content_en,
            $content_om,
            $content_am
        ]);
        
        http_response_code(201);
        echo json_encode(['success' => true, 'message' => 'News article created', 'id' => $id]);
    }
    
    else if ($method === 'PUT' && $action === 'update' && $id) {
        // Update existing news article
        $input = json_decode(file_get_contents('php://input'), true);
        if (empty($input)) {
            $input = $_POST;
        }
        
        // Check if article exists
        $stmt = $db->prepare("SELECT id FROM news WHERE id = ?");
        $stmt->execute([$id]);
        if (!$stmt->fetch()) {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'News article not found']);
            exit;
        }
        
        $updates = [];
        $params = [];
        
        $fields = ['category', 'date', 'image', 'title_en', 'title_om', 'title_am', 'excerpt_en', 'excerpt_om', 'excerpt_am', 'content_en', 'content_om', 'content_am'];
        foreach ($fields as $field) {
            if (isset($input[$field])) {
                $updates[] = "$field = ?";
                $params[] = $input[$field];
            }
        }
        
        // Handle image upload for update
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/news/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $extension = pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
            $fileName = time() . '_' . substr(md5(uniqid()), 0, 8) . '.' . $extension;
            $targetPath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['image_file']['tmp_name'], $targetPath)) {
                $updates[] = "image = ?";
                $params[] = $targetPath;
            }
        }
        
        if (empty($updates)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'No fields to update']);
            exit;
        }
        
        $params[] = $id;
        $query = "UPDATE news SET " . implode(', ', $updates) . " WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute($params);
        
        echo json_encode(['success' => true, 'message' => 'News article updated']);
    }
    
    else if ($method === 'DELETE' && $action === 'delete' && $id) {
        // Delete news article
        $stmt = $db->prepare("SELECT id FROM news WHERE id = ?");
        $stmt->execute([$id]);
        if (!$stmt->fetch()) {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'News article not found']);
            exit;
        }
        
        $stmt = $db->prepare("DELETE FROM news WHERE id = ?");
        $stmt->execute([$id]);
        
        echo json_encode(['success' => true, 'message' => 'News article deleted']);
    }
    
    else {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid request']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

// Helper function to transform database news to frontend format
function transformNews($news) {
    return [
        'id' => $news['id'],
        'category' => $news['category'] ?? 'General',
        'title' => [
            'en' => $news['title_en'] ?? '',
            'om' => $news['title_om'] ?? '',
            'am' => $news['title_am'] ?? ''
        ],
        'excerpt' => [
            'en' => $news['excerpt_en'] ?? '',
            'om' => $news['excerpt_om'] ?? '',
            'am' => $news['excerpt_am'] ?? ''
        ],
        'content' => [
            'en' => $news['content_en'] ?? '',
            'om' => $news['content_om'] ?? '',
            'am' => $news['content_am'] ?? ''
        ],
        'date' => $news['date'] ?? '',
        'image' => $news['image'] ?? null
    ];
}
?>