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

    $lastname = $_POST['lastname'] ?? '';
    $midname = $_POST['midname'] ?? '';
    $firstname = $_POST['firstname'] ?? '';
    $maidenname = $_POST['maidenname'] ?? '';
    $relationship = $_POST['relationship'] ?? '';
    $contact = $_POST['person_num'] ?? '';
    $birthdate = $_POST['birthdate'] ?? '';
    $occupation = $_POST['occupation'] ?? '';
    $sex = $_POST['sex'] ?? '';
    $stats = '1';

    $check_stmt = $port_db->prepare("SELECT COUNT(*) FROM tbl201_family WHERE fam_empno = :employee AND fam_relationship = :relationship AND fam_firstname = :firstname");
    $check_stmt->bindParam(':employee', $user_id);
    $check_stmt->bindParam(':relationship', $relationship);
    $check_stmt->bindParam(':firstname', $firstname);
    $check_stmt->execute();

    if ($check_stmt->fetchColumn() > 0) {
        $stmt = $port_db->prepare("UPDATE tbl201_family SET 
            fam_lastname = :lastname,
            fam_firstname = :firstname,
            fam_midname = :midname,
            fam_maidenname = :maidenname,
            fam_contact = :contact,
            fam_birthdate = :birthdate,
            fam_sex = :sex,
            fam_occupation = :occupation,
            status = :stat
            WHERE fam_empno = :employee AND fam_relationship = :relationship");
    } else {
        $stmt = $port_db->prepare("INSERT INTO tbl201_family (fam_empno, fam_relationship, fam_lastname, fam_firstname, fam_midname, fam_maidenname, fam_contact, fam_birthdate, fam_sex, fam_occupation, status) 
            VALUES (:employee, :relationship, :lastname, :firstname, :midname, :maidenname, :contact, :birthdate, :sex, :occupation, :stat)");
    }

    $stmt->bindParam(':employee', $user_id);
    $stmt->bindParam(':relationship', $relationship);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':midname', $midname);
    $stmt->bindParam(':maidenname', $maidenname);
    $stmt->bindParam(':contact', $contact);
    $stmt->bindParam(':birthdate', $birthdate);
    $stmt->bindParam(':occupation', $occupation);
    $stmt->bindParam(':sex', $sex);
    $stmt->bindParam(':stat', $stats);

    if ($stmt->execute()) {
        echo "Data saved successfully!";
    } else {
        echo "Error saving data.";
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
