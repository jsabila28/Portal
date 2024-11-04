<?php
require_once($sr_root . "/db/db.php");

header('Content-Type: application/json'); // Set the header to JSON format

try {
    $port_db = Database::getConnection('port');
    $hr_db = Database::getConnection('hr');

    $stmt = $port_db->prepare("SELECT pr_code, pr_name FROM tbl_province");
    $stmt->execute();
    $province = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($province); // Output JSON data

} catch (PDOException $e) {
    echo json_encode(["error" => "Error: " . $e->getMessage()]); // Return error as JSON
}
?>
