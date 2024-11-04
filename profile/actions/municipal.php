<?php
require_once($sr_root . "/db/db.php");

// Set the header to ensure the content is interpreted as JSON
header('Content-Type: application/json');

try {
    $port_db = Database::getConnection('port');
    $hr_db = Database::getConnection('hr');

    // Check if 'pr_code' parameter is set
    if (isset($_GET['pr_code']) && !empty($_GET['pr_code'])) {
        $ct_province = $_GET['pr_code'];

        // Prepare and execute the statement
        $stmt = $port_db->prepare("SELECT ct_id, ct_name FROM tbl_municipality WHERE ct_province = :ct_province");
        $stmt->bindParam(':ct_province', $ct_province, PDO::PARAM_STR);
        $stmt->execute();
        $municipal = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return the result as JSON
        echo json_encode($municipal);
    } else {
        // Return an error message if 'pr_code' is missing or empty
        echo json_encode(["error" => "Missing or empty 'pr_code' parameter."]);
    }
    
} catch (PDOException $e) {
    // Return the PDO error message as JSON
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
