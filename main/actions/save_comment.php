<?php
require_once($sr_root . "/db/db.php");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not authenticated']);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $port_db = Database::getConnection('port');

    // Check if values are sent via POST
    if (isset($_POST['Mycomment']) && isset($_POST['post-id'])) {
        $Mycomment = $_POST['Mycomment'];
        $postId = $_POST['post-id'];

        // Prepare the SQL statement to prevent SQL injection
        $stmt = $port_db->prepare("INSERT INTO tbl_post_comment (com_post_id, com_post_by, com_content) VALUES (:postId, :userId, :comment)");
        
        // Bind parameters
        $stmt->bindParam(':postId', $postId);
        $stmt->bindParam(':userId', $user_id);
        $stmt->bindParam(':comment', $Mycomment);

        // Execute the statement
        if ($stmt->execute()) {
            echo json_encode(['success' => 'Record saved successfully']);
        } else {
            echo json_encode(['error' => 'Failed to save record']);
        }
    } else {
        echo json_encode(['error' => 'Invalid input data']);
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['error' => 'Database error']);
}
?>
