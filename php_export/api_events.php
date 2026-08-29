<?php
// api_events.php - REST API for Events Management

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
            // Get all events
            $stmt = $db->prepare("SELECT * FROM events ORDER BY date DESC");
            $stmt->execute();
            $events = $stmt->fetchAll();
            $transformed = array_map('transformEvent', $events);
            echo json_encode(['success' => true, 'data' => $transformed]);
        }
        else if ($action === 'upcoming') {
            $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 6;
            $stmt = $db->prepare("SELECT * FROM events WHERE date >= CURDATE() ORDER BY date ASC LIMIT ?");
            $stmt->bindValue(1, $limit, PDO::PARAM_INT);
            $stmt->execute();
            $events = $stmt->fetchAll();
            $transformed = array_map('transformEvent', $events);
            echo json_encode(['success' => true, 'data' => $transformed]);
        }
        else if ($id) {
            $stmt = $db->prepare("SELECT * FROM events WHERE id = ?");
            $stmt->execute([$id]);
            $event = $stmt->fetch();
            
            if ($event) {
                echo json_encode(['success' => true, 'data' => transformEvent($event)]);
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'error' => 'Event not found']);
            }
        }
        else {
            $stmt = $db->prepare("SELECT * FROM events ORDER BY date DESC");
            $stmt->execute();
            $events = $stmt->fetchAll();
            $transformed = array_map('transformEvent', $events);
            echo json_encode(['success' => true, 'data' => $transformed]);
        }
    }
    
    else if ($method === 'POST' && $action === 'create') {
        $input = $_POST;
        if (empty($input)) {
            $input = json_decode(file_get_contents('php://input'), true);
        }
        
        $required = ['title_en', 'title_om', 'title_am', 'date'];
        foreach ($required as $field) {
            if (empty($input[$field])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => "Missing required field: $field"]);
                exit;
            }
        }
        
        $id = 'event-' . time() . '-' . bin2hex(random_bytes(4));
        $category = isset($input['category']) && !empty($input['category']) ? $input['category'] : 'General';
        $date = isset($input['date']) ? $input['date'] : date('Y-m-d');
        $time = isset($input['time']) ? $input['time'] : '00:00:00';
        $image = '';
        
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/events/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $extension = pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
            $fileName = time() . '_' . substr(md5(uniqid()), 0, 8) . '.' . $extension;
            $targetPath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['image_file']['tmp_name'], $targetPath)) {
                $image = $targetPath;
            }
        }
        
        $title_en = isset($input['title_en']) ? $input['title_en'] : '';
        $title_om = isset($input['title_om']) ? $input['title_om'] : '';
        $title_am = isset($input['title_am']) ? $input['title_am'] : '';
        $excerpt_en = isset($input['excerpt_en']) ? $input['excerpt_en'] : '';
        $excerpt_om = isset($input['excerpt_om']) ? $input['excerpt_om'] : '';
        $excerpt_am = isset($input['excerpt_am']) ? $input['excerpt_am'] : '';
        $location_en = isset($input['location_en']) ? $input['location_en'] : '';
        $location_om = isset($input['location_om']) ? $input['location_om'] : '';
        $location_am = isset($input['location_am']) ? $input['location_am'] : '';
        
        $stmt = $db->prepare("INSERT INTO events (id, category, date, time, image, title_en, title_om, title_am, excerpt_en, excerpt_om, excerpt_am, location_en, location_om, location_am) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $id, $category, $date, $time, $image,
            $title_en, $title_om, $title_am,
            $excerpt_en, $excerpt_om, $excerpt_am,
            $location_en, $location_om, $location_am
        ]);
        
        http_response_code(201);
        echo json_encode(['success' => true, 'message' => 'Event created', 'id' => $id]);
    }
    
    else if ($method === 'DELETE' && $action === 'delete' && $id) {
        $stmt = $db->prepare("DELETE FROM events WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Event deleted']);
    }
    
    else {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid request']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

function transformEvent($event) {
    return [
        'id' => $event['id'],
        'category' => $event['category'] ?? 'General',
        'title' => [
            'en' => $event['title_en'] ?? '',
            'om' => $event['title_om'] ?? '',
            'am' => $event['title_am'] ?? ''
        ],
        'excerpt' => [
            'en' => $event['excerpt_en'] ?? '',
            'om' => $event['excerpt_om'] ?? '',
            'am' => $event['excerpt_am'] ?? ''
        ],
        'location' => [
            'en' => $event['location_en'] ?? '',
            'om' => $event['location_om'] ?? '',
            'am' => $event['location_am'] ?? ''
        ],
        'date' => $event['date'] ?? '',
        'time' => $event['time'] ?? '',
        'image' => $event['image'] ?? null
    ];
}
?>