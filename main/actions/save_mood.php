<?php
require_once($sr_root . "/db/db.php");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not authenticated']);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $port_db = Database::getConnection('port');

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mood'])) {
        $mood = htmlspecialchars($_POST['mood']); // Sanitize input
    
        // Save to database
        $stmt = $port_db->prepare("INSERT INTO tbl_mood (m_empno, m_mood, m_date) VALUES (:empno, :mood, NOW())");
        $stmt->bindParam(':empno', $user_id);
        $stmt->bindParam(':mood', $mood);
        
        if ($stmt->execute()) {
            echo "Mood saved successfully!";
        } else {
            echo "Failed to save mood.";
        }
    }

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

?>
