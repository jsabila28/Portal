<?php
require_once($sr_root . "/db/db.php");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not authenticated']);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $port_db = Database::getConnection('port');

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mood'], $_POST['status'])) {
        $mood = htmlspecialchars($_POST['mood']);
        $status = htmlspecialchars($_POST['status']);
        
        $stmt = $port_db->prepare("INSERT INTO tbl_mood (m_empno, m_mood, m_disp_type, m_date) VALUES (:empno, :mood, :status, NOW())");
        $stmt->bindParam(':empno', $user_id);
        $stmt->bindParam(':mood', $mood);
        $stmt->bindParam(':status', $status);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Mood saved successfully!']);
        } else {
            echo json_encode(['error' => 'Failed to save mood.']);
        }
    } else {
        echo json_encode(['error' => 'Invalid request.']);
    }

} catch (PDOException $e) {
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
}

?>
