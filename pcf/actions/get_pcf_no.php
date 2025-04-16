<?php
require_once($pcf_root."/db/db.php");

$year = date('y');
$month = date('m');

try {
    $pcf_db = Database::getConnection('pcf');

    $deptSql = "SELECT outlet_dept 
                FROM tbl_issuance
                WHERE custodian = :employeeId";
    $deptStmt = $pcf_db->prepare($deptSql);
    $deptStmt->execute(['employeeId' => $user_id]);
    
    $department = $deptStmt->fetchColumn();
    
    if (!$department) {
        throw new Exception("No department found for employee ID $user_id");
    }

    // Fetch the last repl_no for the department
    $sql = "SELECT repl_no FROM tbl_replenish WHERE repl_no LIKE :pattern ORDER BY repl_no DESC LIMIT 1";
    $stmt = $pcf_db->prepare($sql);
    $stmt->execute(['pattern' => "PCF-$department-%"]);

    $lastId = $stmt->fetchColumn();

    if ($lastId) {
        // Extract the last number correctly
        $lastSequence = (int)substr($lastId, strrpos($lastId, '-') + 1);
        $nextSequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT); 
    } else {
        $nextSequence = '001';
    }

    $newId = "PCF-$department-$nextSequence";

    // Output the new ID
    echo "<input type='text' class='form-control' id='pcfIDs' name='pcfID' value='". $newId ."' readonly/>";

} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
