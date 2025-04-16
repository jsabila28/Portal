<?php
require_once($pcf_root . "/db/db.php");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not authenticated']);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $pcf_db = Database::getConnection('pcf'); // This returns a PDO connection

    if (!isset($_POST['outlet_dept']) || empty($_POST['outlet_dept'])) {
        echo json_encode(['error' => 'Outlet department is missing']);
        exit;
    }

    $outlet_dept = $_POST['outlet_dept'];

    $query = "SELECT dis_no FROM tbl_disbursement_entry WHERE dis_no LIKE :search ORDER BY id DESC LIMIT 1";
    $stmt = $pcf_db->prepare($query);
    $search = $outlet_dept . "-%";
    $stmt->bindValue(":search", $search, PDO::PARAM_STR);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        error_log("Fetched Last Entry: " . print_r($row, true));
        $lastEntry = explode("-", $row['dis_no']);
        $lastNumber = intval($lastEntry[1]); // Extract sequence number
    } else {
        error_log("No previous entry found for " . $outlet_dept);
        $lastNumber = 0; // No previous entry
    }

    echo json_encode(["dis_no" => $lastNumber]); // ✅ Fixed key name

} catch (PDOException $e) {
    echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
}
?>
