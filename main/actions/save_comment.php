<?php
require_once($sr_root . "/db/db.php");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not authenticated']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the data from the POST request
    $com_id = $_POST['com_id'] ?? null;
    $comment = $_POST['Mycomment'] ?? null;
    // $user_id = $_POST['user_id'] ?? null;

    // Validate the input
    if (empty($com_id) || empty($comment) || empty($user_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
        exit;
    }

    try {
        $port_db = Database::getConnection('port');

        $stmt = $port_db->prepare("
            INSERT INTO tbl_post_comment (com_post_id, com_content, com_post_by)
            VALUES (?, ?, ?)
        ");

        // Execute the statement with the provided data
        $stmt->execute([$com_id, $comment, $user_id]);

        // Return a success response
        echo json_encode(['status' => 'success', 'message' => 'Comment saved successfully']);
    } catch (PDOException $e) {
        // Return an error response in case of failure
        echo json_encode(['status' => 'error', 'message' => 'Failed to save comment: ' . $e->getMessage()]);
    }
} else {
    // Return an error response for invalid request method
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
