<?php
require_once($sr_root . "/db/db.php");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not authenticated']);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user_id = $_SESSION['user_id'];
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    $selectedValues = $data['selectedValues']; 
    $now = date('Y-m-d');

    $host = 'localhost';
    $db = 'your_database';
    $user = 'your_username';
    $pass = 'your_password';

    try {
        $port_db = Database::getConnection('port');

        // Save the values string in the database
        $stmt = $port_db->prepare("INSERT INTO tbl201_miq (miq_empno, miq_ans, miq_dt) VALUES (:empno, :checkbox_values, :dates)");
        $stmt->execute(['empno' => $user_id]);
        $stmt->execute(['checkbox_values' => $selectedValues]);
        $stmt->execute(['dates' => $now]);


        echo "Data saved successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
