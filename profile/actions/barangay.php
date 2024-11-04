<?php
require_once($sr_root . "/db/db.php");

// Set the header to ensure the content is interpreted as JSON
header('Content-Type: application/json');

try {
    $port_db = Database::getConnection('port');
    $hr_db = Database::getConnection('hr');

    // Check if 'ct_id' parameter is set and not empty
    if (isset($_GET['ct_id']) && !empty($_GET['ct_id'])) {
        $ct_id = $_GET['ct_id'];

        // Prepare and execute the query
        $stmt = $port_db->prepare("SELECT br_id, br_name FROM tbl_barangay WHERE br_city = :ct_id");
        $stmt->bindParam(':ct_id', $ct_id, PDO::PARAM_STR);
        $stmt->execute();
        $brngy = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return the result as JSON
        echo json_encode($brngy);
    } else {
        // Return an error if 'ct_id' is missing or empty
        echo json_encode(["error" => "Missing or empty 'ct_id' parameter."]);
    }
    
} catch (PDOException $e) {
    // Return the PDO error message as JSON
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
