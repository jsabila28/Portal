<?php 
require_once($sr_root . "/db/db.php");
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'User not authenticated']);
    exit;
}

try {
    $port_db = Database::getConnection('port');
    $user_id = $_SESSION['user_id'];

    $level = $_POST['level'] ?? '';
    $degree = $_POST['degree'] ?? '';
    $major = $_POST['major'] ?? '';
    $school = $_POST['school'] ?? '';
    $schooladdress = $_POST['schooladdress'] ?? '';
    $dategrad = $_POST['dategrad'] ?? '';
    $currstatus = $_POST['currstatus'] ?? '';
    $stats = '1';

    // Check if the record already exists
    $check_stmt = $port_db->prepare("SELECT COUNT(*) FROM tbl201_education WHERE educ_empno = :employee AND educ_level = :level");
    $check_stmt->bindParam(':employee', $user_id);
    $check_stmt->bindParam(':level', $level);
    $check_stmt->execute();

    if ($check_stmt->fetchColumn() > 0) {
        // Update existing record
        $stmt = $port_db->prepare("UPDATE tbl201_education SET 
            educ_degreetitle = :degree,
            educ_major = :major,
            educ_school = :school,
            educ_schooladd = :schooladdress,
            educ_yeargrad = :dategrad,
            educ_currStatus = :currstatus
            WHERE educ_empno = :employee AND educ_level = :level");
    } else {
        // Insert new record
        $stmt = $port_db->prepare("INSERT INTO tbl201_education (educ_empno, educ_level, educ_degreetitle, educ_major, educ_school, educ_schooladd, educ_yeargrad, educ_currStatus, status) 
            VALUES (:employee, :level, :degree, :major, :school, :schooladdress, :dategrad, :currstatus, :status)");
        $stmt->bindParam(':status', $stats);
    }

    $stmt->bindParam(':employee', $user_id);
    $stmt->bindParam(':level', $level);
    $stmt->bindParam(':degree', $degree);
    $stmt->bindParam(':major', $major);
    $stmt->bindParam(':school', $school);
    $stmt->bindParam(':schooladdress', $schooladdress);
    $stmt->bindParam(':dategrad', $dategrad);
    $stmt->bindParam(':currstatus', $currstatus);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Data saved successfully!']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error saving data.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
?>
