<?php
// submit_application.php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
    $kebele = filter_input(INPUT_POST, 'kebele', FILTER_SANITIZE_SPECIAL_CHARS);
    $service_type = filter_input(INPUT_POST, 'service_type', FILTER_SANITIZE_SPECIAL_CHARS);
    $details = filter_input(INPUT_POST, 'details', FILTER_SANITIZE_SPECIAL_CHARS);
    
    // Set initial history json tracking line
    $history_array = [
        [
            'status' => 'Application Submitted',
            'date' => date('Y-m-d'),
            'comments' => 'Citizen request captured through Agaro Online Services portal. Placed in Kebele desk queues.'
        ]
    ];
    $history_json = json_encode($history_array);
    
    $pdo = getDB();
    
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("INSERT INTO applications (first_name, last_name, email, phone, kebele, service_type, details, status, history_json) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', ?)");
            $stmt->execute([$first_name, $last_name, $email, $phone, $kebele, $service_type, $details, $history_json]);
            
            $app_id = $pdo->lastInsertId();
            header("Location: index.php?active_tab=services&app_success=1&id=" . urlencode($app_id));
            exit();
        } catch (PDOException $e) {
            header("Location: index.php?active_tab=services&error=" . urlencode("Database application insert failed: " . $e->getMessage()));
            exit();
        }
    } else {
        // Fallback or demo redirection
        header("Location: index.php?active_tab=services&app_success=1&id=" . rand(100, 999) . "&mode=offline_demo");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
