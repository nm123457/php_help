<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Function to sanitize input data
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$error_message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $task_name = sanitize_input($_POST['task_name']);
    $due_date = sanitize_input($_POST['due_date']);
    
    $upload_dir = '../../tmp/uploads/';
    $created_at = date('Y-m-d H:i:s');
	$created_by = $_SESSION['username'];
    
    // Handle file upload
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];
        $filename = basename($file['name']);
        $filesize = $file['size'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        
        // Check file size (max 10MB)
        if ($filesize > 10 * 1024 * 1024) {
            header("Location: create_task_page.php");
            exit();
        } else {
            // Move the uploaded file
            $target_file = $upload_dir . $filename;
            if (move_uploaded_file($file['tmp_name'], $target_file)) {
                // Insert into the database
                try {
                    $dbFilePath = '../../tmp/v2_database.db';
                    $db = new PDO('sqlite:' . $dbFilePath);
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    $filesize_kb = $filesize / 1024;
                    
                    $stmt = $db->prepare("INSERT INTO tasks (task_name, created_by, due_date, created_at, attached_file_name) VALUES (:task_name, :created_by, :due_date, :created_at, :attached_file_name)");
                    $stmt->bindParam(':task_name', $task_name);
                    $stmt->bindParam(':created_by', $created_by);
                    $stmt->bindParam(':due_date', $due_date);
                    $stmt->bindParam(':created_at', $created_at);
                    $stmt->bindParam(':attached_file_name', $filename);
                    $stmt->execute();
                    
                    echo "Fájl sikeresen feltöltve.";
                } catch (PDOException $e) {
                    echo "Database error: " . $e->getMessage();
                    header("Location: create_task_page.php");
                    exit();
                }
            } else {
                echo "Failed to upload file.";
                header("Location: create_task_page.php");
                exit();
            }
        }
    } else {
        echo "No file uploaded.";
        header("Location: create_task_page.php");
        exit();
    }
} else {
    header("Location: create_task_page.php");
    exit();
}
?>
