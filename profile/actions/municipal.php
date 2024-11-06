<?php
require_once($sr_root . "/db/db.php");

header('Content-Type: application/json');
header('Content-Type: text/html; charset=UTF-8');

try {
    $port_db = Database::getConnection('port');
    $hr_db = Database::getConnection('hr');

$provinceId = $_POST['pr_code'];

$stmt = $port_db->prepare("SELECT ct_id, ct_name FROM tbl_municipality WHERE ct_province = ?");
$stmt->execute([$provinceId]);

$options = '<option value="">Select Municipality</option>';
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $options .= '<option value="'.$row['ct_id'].'">'.$row['ct_name'].'</option>';
}
echo $options;

} catch (PDOException $e) {
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
