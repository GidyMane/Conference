<?php
// process_abstract.php
require_once $_SERVER['DOCUMENT_ROOT'].'/conference/config/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

try {
    // Get form data
    $data = [
        'submission_id' => $_POST['submission_id'] ?? uniqid('KALRO_'),
        'corresponding_name' => trim($_POST['corresponding_name']),
        'corresponding_email' => trim($_POST['corresponding_email']),
        'corresponding_phone' => preg_replace('/\s+/', '', $_POST['corresponding_phone']),
        'organization' => trim($_POST['organization']),
        'department' => trim($_POST['department'] ?? ''),
        'position' => trim($_POST['position'] ?? ''),
        'submission_type' => $_POST['submission_type'],
        'sub_theme' => $_POST['sub_theme'],
        'paper_title' => trim($_POST['paper_title']),
        'abstract' => trim($_POST['abstract']),
        'keywords' => trim($_POST['keywords'] ?? ''),
        'presentation_preference' => $_POST['presentation_preference'] ?? '',
        'attendance_mode' => $_POST['attendance_mode'] ?? '',
        'special_requirements' => trim($_POST['special_requirements'] ?? ''),
        'submitted_at' => date('Y-m-d H:i:s')
    ];
    
    // Process authors
    $authors = [];
    if (isset($_POST['authors']) && is_array($_POST['authors'])) {
        foreach ($_POST['authors'] as $index => $author) {
            if (!empty($author['name'])) {
                $authors[] = [
                    'order' => $index,
                    'name' => trim($author['name']),
                    'institution' => trim($author['institution'] ?? ''),
                    'corresponding' => isset($author['corresponding']) ? 1 : 0
                ];
            }
        }
    }
    
    // In real application:
    // 1. Save to database
    // 2. Generate PDF confirmation
    // 3. Send email notifications
    
    // For now, just return success
    echo json_encode([
        'success' => true,
        'message' => 'Abstract submitted successfully xx',
        'submission_id' => $data['submission_id'],
        'data' => $data,
        'authors' => $authors
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred: ' . $e->getMessage()
    ]);
}