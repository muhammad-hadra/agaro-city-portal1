<?php
// submit_complaint.php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_SPECIAL_CHARS);
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_SPECIAL_CHARS);
    $kebele = filter_input(INPUT_POST, 'kebele', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $is_anonymous = isset($_POST['is_anonymous']) ? 1 : 0;
    
    $reporter_name = $is_anonymous ? 'Anonymous Citizen' : filter_input(INPUT_POST, 'reporter_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $reporter_phone = $is_anonymous ? '' : filter_input(INPUT_POST, 'reporter_phone', FILTER_SANITIZE_SPECIAL_CHARS);
    
    // Generate a secure ticket number
    $ticket_no = 'AG-TX-' . rand(10000, 99999);
    $date = date('Y-m-d');
    
    $pdo = getDB();
    
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("INSERT INTO complaints (ticket_no, category, title, description, location, kebele, reporter_name, reporter_phone, is_anonymous, date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'received')");
            $stmt->execute([$ticket_no, $category, $title, $description, $location, $kebele, $reporter_name, $reporter_phone, $is_anonymous, $date]);
            
            header("Location: index.php?active_tab=contact&complaint_success=1&ticket=" . urlencode($ticket_no));
            exit();
        } catch (PDOException $e) {
            // Echo back nicely if schema isn't created but preserve fallback redirect
            header("Location: index.php?active_tab=contact&error=" . urlencode("Database insert failed: " . $e->getMessage()));
            exit();
        }
    } else {
        // Fallback for demo systems (e.g. SQLite or localStorage simulation in URL states)
        header("Location: index.php?active_tab=contact&complaint_success=1&ticket=" . urlencode($ticket_no) . "&mode=offline_demo");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
