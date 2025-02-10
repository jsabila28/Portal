<?php
require_once($sr_root . "/db/db.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $port = Database::getConnection('port');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $postedBy = $_POST['postedBy'];
    $postDesc = $_POST['postDesc'];
    $audience = $_POST['audience'];
    $filePath = null;

    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $targetDir = "assets/announcement/";
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            $filePath = 'assets/announcement/post_' . $fileName;
        } else {
            echo "Error uploading file.";
            exit;
        }
    }

    $sql = "INSERT INTO tbl_announcement (ann_title, ann_content, ann_receiver, ann_approvedby) VALUES (:ann_title, :ann_content, :ann_receiver, :ann_approvedby)";
    $stmt = $port->prepare($sql);
    $stmt->bindParam(':ann_title', $postDesc);
    $stmt->bindParam(':ann_content', $filePath);
    $stmt->bindParam(':ann_receiver', $audience);
    $stmt->bindParam(':ann_approvedby', $postedBy);

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