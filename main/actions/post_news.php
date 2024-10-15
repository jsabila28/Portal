<?php
require_once($sr_root . "/db/db.php");

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $port = Database::getConnection('port');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $postedBy = $_POST['postedBy'];
    $postDesc = $_POST['postDesc'];
    $audience = $_POST['audience'];
    $filePath = null;

    // Handle file upload
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $targetDir = "assets/announcement/";
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            $filePath = $fileName;
        } else {
            echo "Error uploading file.";
            exit;
        }
    }

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO tbl_announcement (ann_approvedby, ann_title, ann_receiver, ann_content) VALUES (:posted_by, :post_desc, :audience, :file_path)";
    $stmt = $port->prepare($sql);
    $stmt->bindParam(':posted_by', $postedBy);
    $stmt->bindParam(':post_desc', $postDesc);
    $stmt->bindParam(':audience', $audience);
    $stmt->bindParam(':file_path', $filePath);

    if ($stmt->execute()) {
        echo "Post saved successfully.";
    } else {
        echo "Error saving post.";
    }
}
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>