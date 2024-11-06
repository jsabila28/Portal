<?php
require_once($sr_root . "/db/db.php");

header('Content-Type: application/json');
header('Content-Type: text/html; charset=UTF-8');

try {
    $port_db = Database::getConnection('port');
    $hr_db = Database::getConnection('hr');

$municipalId = $_POST['municipal_id'];

$stmt = $port_db->prepare("SELECT br_id, br_name FROM tbl_barangay WHERE br_city = ?");
$stmt->execute([$municipalId]);

$options = '<option value="">Select Barangay</option>';
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $options .= '<option value="'.$row['br_id'].'">'.$row['br_name'].'</option>';
}
echo $options;
} catch (PDOException $e) {
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
