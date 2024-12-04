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
    
    $company = $_POST['company'] ?? '';
    $address = $_POST['address'] ?? '';
    $position = $_POST['position'] ?? '';    
    $supervisor = $_POST['supervisor'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $sdate = $_POST['sdate'] ?? '';
    $edate = $_POST['edate'] ?? '';
    $reason = $_POST['reason'] ?? '';
    $stat = '1';

    // Check if the record already exists
    $checkQuery = $port_db->prepare("SELECT COUNT(*) FROM tbl201_employment 
                                     WHERE empl_empno = :employee 
                                     AND empl_company = :compnany");
    $checkQuery->bindParam(':employee', $user_id);
    $checkQuery->bindParam(':compnany', $company);
    $checkQuery->execute();
    $exists = $checkQuery->fetchColumn() > 0;

    if ($exists) {
        // Update the existing record
        $updateQuery = $port_db->prepare("UPDATE tbl201_employment 
                                          SET empl_from = :dfrom, 
                                              empl_to = :dto, 
                                              empl_address = :address,   
                                              empl_position = :position,
                                              empl_contact = :contact,
                                              empl_supervisor = :supervisor, 
                                              empl_reason = :reason 
                                          WHERE empl_empno = :employee 
                                          AND empl_company = :compnany");
        $updateQuery->bindParam(':dfrom', $sdate);
        $updateQuery->bindParam(':dto', $edate);
        $updateQuery->bindParam(':address', $address);
        $updateQuery->bindParam(':position', $position);
        $updateQuery->bindParam(':contact', $contact);
        $updateQuery->bindParam(':supervisor', $supervisor);
        $updateQuery->bindParam(':reason', $reason);
        $updateQuery->bindParam(':employee', $user_id);
        $updateQuery->bindParam(':compnany', $compnany);
        $updateQuery->execute();

        echo json_encode(["success" => true, "message" => "Record updated successfully."]);
    } else {
        // Insert a new record
        $insertQuery = $port_db->prepare("INSERT INTO tbl201_employment 
            (empl_empno, 
            empl_from, 
            empl_to, 
            empl_company, 
            empl_address, 
            empl_position, 
            empl_contact, 
            empl_supervisor, 
            empl_reason)
            VALUES (
            :employee, 
            :dfrom, 
            :dto, 
            :compnany, 
            :address,  
            :position, 
            :contact, 
            :supervisor, 
            :reason)");
        $insertQuery->bindParam(':employee', $user_id);
        $insertQuery->bindParam(':dfrom', $sdate);
        $insertQuery->bindParam(':dto', $edate);
        $insertQuery->bindParam(':compnany', $compnany);
        $insertQuery->bindParam(':address', $address);
        $insertQuery->bindParam(':position', $position);
        $insertQuery->bindParam(':contact', $contact);
        $insertQuery->bindParam(':supervisor', $supervisor);
        $insertQuery->bindParam(':reason', $reason);
        $insertQuery->execute();

        echo json_encode(["success" => true, "message" => "Record inserted successfully."]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => "Database error: " . $e->getMessage()]);
}
?>
