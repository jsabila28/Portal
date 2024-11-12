<?php
require_once($sr_root . "/db/db.php");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not authenticated']);
    exit;
}
error_log(print_r($_POST, true));

$user_id = $_SESSION['user_id'];

try {
    $port_db = Database::getConnection('port');
    $hr_db = Database::getConnection('hr');
    
    $scategory = $_POST['Scategory'] ?? '';
    $stype = $_POST['Stype'] ?? '';
    $others = $_POST['Others'] ?? '';
    $stat = '1';

    
    // Insert data into the database
    $stmt = $port_db->prepare("INSERT INTO tbl201_skills (skill_empno, skill_category, skill_type, skill_others, status)
                          VALUES (:empno, :category, :type, :others, :stat)");
    
    $stmt->bindParam(':empno', $user_id);
    $stmt->bindParam(':category', $scategory);
    $stmt->bindParam(':type', $stype);
    $stmt->bindParam(':others', $others);
    $stmt->bindParam(':stat', $stat);
    
    $stmt->execute();
    
    echo json_encode(["success" => true]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => "Database error: " . $e->getMessage()]);
}
?>
