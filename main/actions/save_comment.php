<?php
require_once($sr_root . "/db/db.php");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not authenticated']);
    exit;
}

$com_id = htmlspecialchars($_POST['com_id']);
$comment = htmlspecialchars($_POST['Mycomment']);
$user_id = $_SESSION['user_id'];

try {
    $port_db = Database::getConnection('port');

    $stmt = $port_db->prepare("
        INSERT INTO tbl_post_comment (com_post_id, com_post_by, com_content, com_date)
        VALUES (?, ?, ?, NOW())
    ");
    $stmt->execute([$com_id, $user_id, $comment]);

    echo json_encode(['status' => 'success', 'message' => 'Comment added successfully']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>

