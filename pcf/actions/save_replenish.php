<?php
require_once($pcf_root . "/db/db.php");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not authenticated']);
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sec_coh = $_POST['sec_coh'];
    $etotal = $_POST['etotal'];
    $pcfID = $_POST['pcfID'];
    $company = $_POST['company'];
    $outlet = $_POST['outlet'];
    $signature = urldecode($_POST['signature']); // Decode SVG data
    $disbursements = json_decode($_POST['disbursements'], true);
    $status = 'submit';
    $date = date("Y-m-d");

    // Debugging Output
    file_put_contents("debug_log.txt", "Received Data:\n" . print_r($_POST, true) . "\n", FILE_APPEND);

    try {
        $pcf_db = Database::getConnection('pcf');

        // Insert or Update in PCF Table
        $stmt = $pcf_db->prepare("INSERT INTO tbl_replenish (repl_no, repl_custodian, repl_company, repl_outlet, repl_cash_on_hand, repl_expense, repl_status) 
                                  VALUES (:pcfID, :cust, :company, :outlet, :sec_coh, :etotal, :stat)
                                  ON DUPLICATE KEY UPDATE 
                                  repl_cash_on_hand = VALUES(repl_cash_on_hand), 
                                  repl_expense = VALUES(repl_expense), 
                                  repl_status = VALUES(repl_status)");
        $stmt->execute([
            'pcfID' => $pcfID,
            'cust' => $user_id,
            'company' => $company,
            'outlet' => $outlet,
            'sec_coh' => $sec_coh,
            'etotal' => $etotal,
            'stat' => $status
        ]);

        // Insert Signature
        $stmt2 = $pcf_db->prepare("INSERT INTO tbl_signatures (replenish_no, custodian, cust_signature, cust_date) 
                                   VALUES (:pcfID, :cust, :signature, :dates)
                                   ON DUPLICATE KEY UPDATE cust_signature = VALUES(cust_signature)");
        $stmt2->execute([
            'pcfID' => $pcfID,
            'cust' => $user_id,
            'signature' => $signature,
            'dates' => $date
        ]);

        echo "Data, signature, and updates saved successfully!";
    } catch (PDOException $e) {
        file_put_contents("debug_log.txt", "SQL Error: " . $e->getMessage() . "\n", FILE_APPEND);
        echo "Error: " . $e->getMessage();
    }
}
?>