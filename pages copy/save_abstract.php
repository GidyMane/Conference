<?php
// Start session for error handling
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once $_SERVER['DOCUMENT_ROOT'].'/conference/mailer/src/Exception.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/conference/mailer/src/PHPMailer.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/conference/mailer/src/SMTP.php';

// Database connection
$conn = mysqli_connect("localhost", "root", "", "kalro");
if (!$conn) {
    $_SESSION['error'] = "Database connection failed: " . mysqli_connect_error();
    header("Location: submit_abstract.php");
    exit;
}

// Debug: Check if POST data is received
if (empty($_POST)) {
    $_SESSION['error'] = "No form data was submitted. Please fill out the form completely.";
    header("Location: submit_abstract.php");
    exit;
}

// Log POST data for debugging
error_log("=== SAVE ABSTRACT STARTED ===");
error_log("Authors POST data: " . print_r($_POST['authors'] ?? [], true));

// Validate required fields
$required = ['corresponding_name', 'corresponding_email', 'corresponding_phone', 
             'organization', 'submission_type', 'sub_theme', 'paper_title', 'abstract', 'terms'];

foreach ($required as $field) {
    if ($field === 'terms') {
        if (!isset($_POST[$field]) || $_POST[$field] !== 'on') {
            $_SESSION['error'] = "You must agree to the terms and conditions";
            header("Location: submit_abstract.php");
            exit;
        }
    } elseif (empty(trim($_POST[$field] ?? ''))) {
        $_SESSION['error'] = ucfirst(str_replace('_', ' ', $field)) . " is required";
        header("Location: submit_abstract.php");
        exit;
    }
}

// Validate email
if (!empty($_POST['corresponding_email']) && !filter_var($_POST['corresponding_email'], FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Please enter a valid email address";
    header("Location: submit_abstract.php");
    exit;
}

// Phone validation (accepts +254XXXXXXXXX or 07XXXXXXXX)
if (!empty($_POST['corresponding_phone'])) {
    $phone = preg_replace('/\s+/', '', $_POST['corresponding_phone']);
    // Accept: +2547XXXXXXXX, 2547XXXXXXXX, 07XXXXXXXX
    if (!preg_match('/^(\+?254|0)[17]\d{8}$/', $phone)) {
        $_SESSION['error'] = "Please enter a valid Kenyan phone number (e.g., +254728463410 or 0728463410)";
        header("Location: submit_abstract.php");
        exit;
    }
}

// Abstract word count validation
if (!empty($_POST['abstract'])) {
    $word_count = str_word_count(strip_tags($_POST['abstract']));
    if ($word_count > 300) {
        $_SESSION['error'] = "Abstract must not exceed 300 words. Current count: $word_count";
        header("Location: submit_abstract.php");
        exit;
    }
    if ($word_count < 10) {
        $_SESSION['error'] = "Abstract is too short. Please provide at least 10 words. Current count: $word_count";
        header("Location: submit_abstract.php");
        exit;
    }
}

// 1. Generate next submission code
$result = mysqli_query($conn, "SELECT submission_code FROM abstract_submissions ORDER BY id DESC LIMIT 1");
$lastNumber = 0;
if ($row = mysqli_fetch_assoc($result)) {
    $lastCode = $row['submission_code'];
    // Extract number from code like KALROCONF_SUB1
    if (preg_match('/KALROCONF_SUB(\d+)$/', $lastCode, $matches)) {
        $lastNumber = (int)$matches[1];
    }
}
$nextNumber = $lastNumber + 1;
$submission_code = "KALROCONF_SUB" . $nextNumber;

error_log("Generated submission code: $submission_code");

// 2. Collect and sanitize form data
$corresponding_name = mysqli_real_escape_string($conn, trim($_POST['corresponding_name']));
$corresponding_email = mysqli_real_escape_string($conn, trim($_POST['corresponding_email']));
$corresponding_phone = mysqli_real_escape_string($conn, trim($_POST['corresponding_phone']));
$organization = mysqli_real_escape_string($conn, trim($_POST['organization']));
$department = isset($_POST['department']) && !empty(trim($_POST['department'])) ? mysqli_real_escape_string($conn, trim($_POST['department'])) : null;
$position = isset($_POST['position']) && !empty(trim($_POST['position'])) ? mysqli_real_escape_string($conn, trim($_POST['position'])) : null;
$submission_type = mysqli_real_escape_string($conn, trim($_POST['submission_type']));
$sub_theme = mysqli_real_escape_string($conn, trim($_POST['sub_theme']));
$paper_title = mysqli_real_escape_string($conn, trim($_POST['paper_title']));
$abstract = mysqli_real_escape_string($conn, trim($_POST['abstract']));
$keywords = isset($_POST['keywords']) && !empty(trim($_POST['keywords'])) ? mysqli_real_escape_string($conn, trim($_POST['keywords'])) : null;
$presentation_preference = isset($_POST['presentation_preference']) && !empty(trim($_POST['presentation_preference'])) ? mysqli_real_escape_string($conn, trim($_POST['presentation_preference'])) : null;
$attendance_mode = isset($_POST['attendance_mode']) && !empty(trim($_POST['attendance_mode'])) ? mysqli_real_escape_string($conn, trim($_POST['attendance_mode'])) : null;
$special_requirements = isset($_POST['special_requirements']) && !empty(trim($_POST['special_requirements'])) ? mysqli_real_escape_string($conn, trim($_POST['special_requirements'])) : null;

// 3. Insert main submission
$sql = "INSERT INTO abstract_submissions 
(submission_code, corresponding_name, corresponding_email, corresponding_phone, 
 organization, department, position, submission_type, sub_theme, 
 paper_title, abstract, keywords, presentation_preference, attendance_mode, special_requirements, created_at)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    $error = "Database prepare error: " . mysqli_error($conn);
    error_log($error);
    $_SESSION['error'] = "Database error. Please try again.";
    header("Location: submit_abstract.php");
    exit;
}

// Bind parameters
mysqli_stmt_bind_param($stmt, "sssssssssssssss",
    $submission_code, $corresponding_name, $corresponding_email, $corresponding_phone,
    $organization, $department, $position, $submission_type, $sub_theme,
    $paper_title, $abstract, $keywords, $presentation_preference, $attendance_mode, $special_requirements
);

// Execute the statement
if (!mysqli_stmt_execute($stmt)) {
    $error = "Database execute error: " . mysqli_stmt_error($stmt);
    error_log($error);
    $_SESSION['error'] = "Failed to save submission. Please try again.";
    mysqli_stmt_close($stmt);
    header("Location: submit_abstract.php");
    exit;
}

// Get inserted submission ID
$submission_db_id = mysqli_insert_id($conn);
mysqli_stmt_close($stmt);

error_log("Main submission saved with ID: $submission_db_id");

// 4. Save authors - FIXED VERSION
$authors = [];

// Always add the corresponding author as first author
$authors[] = [
    'order' => 1,
    'name' => $corresponding_name,
    'institution' => $organization,
    'corresponding' => true  // Always corresponding
];

error_log("Added corresponding author: $corresponding_name");

// Add any additional authors from the form
if (!empty($_POST['authors']) && is_array($_POST['authors'])) {
    $author_index = 2; // Start from author 2
    
    foreach ($_POST['authors'] as $order => $author) {
        // Skip author 1 from POST since we already have it
        if ($order == 1) {
            continue;
        }
        
        $author_name = trim($author['name'] ?? '');
        $author_institution = trim($author['institution'] ?? '');
        
        // Skip if name is empty
        if (empty($author_name)) {
            continue;
        }
        
        // Check if this is marked as corresponding
        $is_corresponding = isset($author['corresponding']) && $author['corresponding'] == 'on';
        
        $authors[] = [
            'order' => $author_index,
            'name' => mysqli_real_escape_string($conn, $author_name),
            'institution' => !empty($author_institution) ? mysqli_real_escape_string($conn, $author_institution) : '',
            'corresponding' => $is_corresponding
        ];
        
        error_log("Added additional author $author_index: $author_name (corresponding: " . ($is_corresponding ? 'yes' : 'no') . ")");
        $author_index++;
    }
}

// Check if any additional author is marked as corresponding
$additional_corresponding_found = false;
$corresponding_author_index = 1; // Default to author 1

foreach ($authors as $index => $author) {
    if ($author['corresponding'] && $author['order'] > 1) {
        $additional_corresponding_found = true;
        $corresponding_author_index = $author['order'];
        break;
    }
}

// If an additional author is marked as corresponding, unmark author 1
if ($additional_corresponding_found) {
    $authors[0]['corresponding'] = false; // Unmark author 1
    error_log("Author $corresponding_author_index marked as corresponding, unmarked author 1");
} else {
    // Ensure author 1 is marked as corresponding
    $authors[0]['corresponding'] = true;
    error_log("No additional author marked as corresponding, author 1 remains corresponding");
}

// Insert authors into database
$author_count = 0;
foreach ($authors as $author) {
    $order = $author['order'];
    $name = $author['name'];
    $institution = $author['institution'];
    $is_corresponding = $author['corresponding'] ? 1 : 0;

    $a_sql = "INSERT INTO abstract_authors (submission_id, author_order, name, institution, is_corresponding)
              VALUES (?, ?, ?, ?, ?)";
    $a_stmt = mysqli_prepare($conn, $a_sql);
    if (!$a_stmt) {
        $error = "Author prepare error: " . mysqli_error($conn);
        error_log($error);
        $_SESSION['error'] = "Failed to save author information.";
        header("Location: submit_abstract.php");
        exit;
    }
    
    mysqli_stmt_bind_param($a_stmt, "iissi", $submission_db_id, $order, $name, $institution, $is_corresponding);
    
    if (!mysqli_stmt_execute($a_stmt)) {
        $error = "Author execute error: " . mysqli_stmt_error($a_stmt);
        error_log($error);
        $_SESSION['error'] = "Failed to save author: $name";
        mysqli_stmt_close($a_stmt);
        header("Location: submit_abstract.php");
        exit;
    }
    
    $author_count++;
    mysqli_stmt_close($a_stmt);
    error_log("Saved author $order: $name from $institution (corresponding: $is_corresponding)");
}

error_log("Successfully saved $author_count authors");

// 5. Send confirmation email
$email_sent = false;
$email_error = '';
try {
    $mail = new PHPMailer(true);
    
    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'enolaanne89@gmail.com';
    $mail->Password = 'bojb flxl kaui dijc';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    
    // Email content
    $mail->setFrom('enolaanne89@gmail.com', '2nd KALRO Scientific Conference and Exhibition');
    $mail->addAddress($corresponding_email, $corresponding_name);
    $mail->addBCC('enolaanne89@gmail.com'); // Keep a copy
    
    $mail->Subject = 'Abstract Submission Confirmation - 2nd KALRO Scientific Conference and Exhibition';
    
    // HTML email body
    $htmlBody = '
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #28a745; color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; background-color: #f8f9fa; }
            .details { background-color: white; padding: 15px; border-radius: 5px; margin: 15px 0; }
            .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
            .highlight { color: #28a745; font-weight: bold; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h2>2nd KALRO Scientific Conference and Exhibition</h2>
                <h3>Abstract Submission Confirmation</h3>
            </div>
            
            <div class="content">
                <p>Dear ' . htmlspecialchars($corresponding_name) . ',</p>
                
                <p>Thank you for submitting your abstract to the 2nd KALRO Scientific Conference and Exhibition. We have successfully received your submission and it is now under review.</p>
                
                <div class="details">
                    <h4>Submission Details:</h4>
                    <p><strong>Submission Code:</strong> <span class="highlight">' . htmlspecialchars($submission_code) . '</span></p>
                    <p><strong>Paper Title:</strong> ' . htmlspecialchars($paper_title) . '</p>
                    <p><strong>Corresponding Author:</strong> ' . htmlspecialchars($corresponding_name) . '</p>
                    <p><strong>Email:</strong> ' . htmlspecialchars($corresponding_email) . '</p>
                    <p><strong>Submission Type:</strong> ' . htmlspecialchars(ucfirst($submission_type)) . '</p>
                    <p><strong>Sub-theme:</strong> ' . htmlspecialchars($sub_theme) . '</p>
                    <p><strong>Number of Authors:</strong> ' . $author_count . '</p>
                    <p><strong>Submission Date:</strong> ' . date('F j, Y') . '</p>
                </div>
                
                <h4>What Happens Next:</h4>
                <ol>
                    <li>Your abstract will undergo a peer review process by our scientific committee</li>
                    <li>You will receive notification of acceptance/rejection within 2-3 weeks</li>
                    <li>If accepted, you will receive further instructions regarding presentation format and schedule</li>
                    <li>All correspondence will be sent to this email address</li>
                </ol>
                
                <p><strong>Important:</strong> Please keep your submission code (<span class="highlight">' . htmlspecialchars($submission_code) . '</span>) for future reference in all communications.</p>
                
                <p>If you need to make any changes to your submission or have any questions, please contact us at <a href="mailto:enolaanne89@gmail.com">sepdconference@gmail.com</a> with your submission code.</p>
                
                <p>Thank you for your contribution to the 2nd KALRO Scientific Conference and Exhibition.</p>
                
                <p>Best regards,<br>
                <strong>KALRO 2nd KALRO Scientific Conference and Exhibition Committee</strong><br>
                Email: sepdconference@gmail.com<br>
                Website: ' . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'KALRO Conference') . '</p>
            </div>
            
            <div class="footer">
                <p>This is an automated message. Please do not reply to this email.</p>
                <p>© ' . date('Y') . ' 2nd KALRO Scientific Conference and Exhibition. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>';
    
    // Plain text version for email clients that don't support HTML
    $textBody = "2nd KALRO Scientific Conference and Exhibition - Abstract Submission Confirmation\n\n";
    $textBody .= "Dear $corresponding_name,\n\n";
    $textBody .= "Thank you for submitting your abstract to the KALRO 2nd KALRO Scientific Conference and Exhibition. We have successfully received your submission and it is now under review.\n\n";
    $textBody .= "SUBMISSION DETAILS:\n";
    $textBody .= "Submission Code: $submission_code\n";
    $textBody .= "Paper Title: $paper_title\n";
    $textBody .= "Corresponding Author: $corresponding_name\n";
    $textBody .= "Email: $corresponding_email\n";
    $textBody .= "Submission Type: $submission_type\n";
    $textBody .= "Sub-theme: $sub_theme\n";
    $textBody .= "Number of Authors: $author_count\n";
    $textBody .= "Submission Date: " . date('F j, Y') . "\n\n";
    $textBody .= "WHAT HAPPENS NEXT:\n";
    $textBody .= "1. Your abstract will undergo a peer review process by our scientific committee\n";
    $textBody .= "2. You will receive notification of acceptance/rejection within 2-3 weeks\n";
    $textBody .= "3. If accepted, you will receive further instructions regarding presentation format and schedule\n";
    $textBody .= "4. All correspondence will be sent to this email address\n\n";
    $textBody .= "IMPORTANT: Please keep your submission code ($submission_code) for future reference in all communications.\n\n";
    $textBody .= "If you need to make any changes to your submission or have any questions, please contact us at sepdconference@gmail.com with your submission code.\n\n";
    $textBody .= "Thank you for your contribution to the 2nd KALRO Scientific Conference and Exhibition.\n\n";
    $textBody .= "Best regards,\n";
    $textBody .= "KALRO Conference Committee\n";
    $textBody .= "Email: sepdconference@gmail.com\n";
    $textBody .= "Website: " . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'KALRO Conference') . "\n\n";
    $textBody .= "This is an automated message. Please do not reply to this email.\n";
    $textBody .= "© " . date('Y') . " 2nd KALRO Scientific Conference and Exhibition. All rights reserved.\n";
    
    $mail->isHTML(true);
    $mail->Body = $htmlBody;
    $mail->AltBody = $textBody;
    
    $mail->send();
    $email_sent = true;
    error_log("Confirmation email sent successfully to: $corresponding_email");
    
} catch (Exception $e) {
    $email_error = $mail->ErrorInfo;
    error_log("Email sending failed: " . $email_error);
    // Don't stop the process if email fails, just log it
}

mysqli_close($conn);

// Store success data in session for the success page
$_SESSION['submission_success'] = true;
$_SESSION['submission_code'] = $submission_code;
$_SESSION['submission_id'] = $submission_db_id;
$_SESSION['corresponding_name'] = $corresponding_name;
$_SESSION['corresponding_email'] = $corresponding_email;
$_SESSION['paper_title'] = $paper_title;
$_SESSION['authors_count'] = $author_count;
$_SESSION['email_sent'] = $email_sent;
$_SESSION['email_error'] = $email_error;

error_log("=== SAVE ABSTRACT COMPLETED SUCCESSFULLY ===");
error_log("Email sent: " . ($email_sent ? 'Yes' : 'No'));
error_log("Redirecting to success page with code: $submission_code");

// 6. Redirect to success page
header("Location: abstract_success.php?ref=" . urlencode($submission_code));
exit;
?>