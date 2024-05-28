<?php
session_start();
include 'logger.php'; // Include the logger

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login_page.php");
    exit();
}

// Function to sanitize input data
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$error_message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $item_name = sanitize_input($_POST['item_name']);
    $auction_start = sanitize_input($_POST['auction_start']);
    $auction_end = sanitize_input($_POST['auction_end']);
    $price = (int) sanitize_input($_POST['price']);
    $used_item = isset($_POST['used_item']) ? 1 : 0;
    
    $upload_dir = '../tmp/uploads/';
    $uploaded_at = date('Y-m-d H:i:s');
    
    // Handle file upload
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];
        $filename = basename($file['name']);
        $filesize = $file['size'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        
        // Check file size (max 10MB)
        if ($filesize > 10 * 1024 * 1024) {
            $_SESSION['error_message'] = 'File size exceeds 10MB.';
            header("Location: file_upload_page.php");
            exit();
        } else {
            // Move the uploaded file
            $target_file = $upload_dir . $filename;
            if (move_uploaded_file($file['tmp_name'], $target_file)) {
                // Insert into the database
                try {
                    $dbFilePath = '../tmp/database.db';
                    $db = new PDO('sqlite:' . $dbFilePath);
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    $uploader = $_SESSION['username'];
                    $filesize_kb = $filesize / 1024;
                    
                    $stmt = $db->prepare("INSERT INTO uploads (uploader, uploaded_filename, uploaded_filetype, filesize, uploaded_at) VALUES (:uploader, :filename, :filetype, :filesize, :uploaded_at)");
                    $stmt->bindParam(':uploader', $uploader);
                    $stmt->bindParam(':filename', $filename);
                    $stmt->bindParam(':filetype', $filetype);
                    $stmt->bindParam(':filesize', $filesize_kb);
                    $stmt->bindParam(':uploaded_at', $uploaded_at);
                    $stmt->execute();
                    
                    echo "File uploaded successfully.";
                } catch (PDOException $e) {
                    $_SESSION['error_message'] = "Database error: " . $e->getMessage();
                    header("Location: file_upload_page.php");
                    exit();
                }
            } else {
                $_SESSION['error_message'] = "Failed to upload file.";
                header("Location: file_upload_page.php");
                exit();
            }
        }
    } else {
        $_SESSION['error_message'] = "No file uploaded.";
        header("Location: file_upload_page.php");
        exit();
    }
} else {
    header("Location: file_upload_page.php");
    exit();
}
?>
