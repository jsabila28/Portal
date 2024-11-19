<?php 
require_once($sr_root . "/db/db.php");
header('Content-Type: application/json');


if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'User not authenticated']);
    exit;
}

try {
    $port_db = Database::getConnection('port');
    $user_id = $_SESSION['user_id'];

    $eventTitle = $_POST['eventTitle'] ?? '';
    $eventdate = $_POST['eventdate'] ?? '';
    $stats = '1';

    $eventimage = '';
    if (isset($_FILES['eventimage']) && $_FILES['eventimage']['error'] == UPLOAD_ERR_OK) {
        $uploadsDir = '../assets/image/'; 
        $eventimage = basename($_FILES['eventimage']['name']);
        $targetPath = $uploadsDir . $eventimage;

        if (move_uploaded_file($_FILES['eventimage']['tmp_name'], $targetPath)) {
        } else {
            echo json_encode(['success' => false, 'error' => 'Error moving uploaded file.']);
            exit;
        }
    }

    $check_stmt = $port_db->prepare("SELECT COUNT(*) FROM tbl_events WHERE event_title = :eventTitle AND event_datestart = :eventdate ");
    $check_stmt->bindParam(':eventTitle', $eventTitle);
    $check_stmt->bindParam(':eventdate', $eventdate);
    $check_stmt->execute();

    if ($check_stmt->fetchColumn() > 0) {
        $stmt = $port_db->prepare("UPDATE tbl_events SET 
            event_postby = :employee,
            event_title = :eventTitle,
            event_datestart = :eventdate,
            event_file = :eventimage
            WHERE event_title = :eventTitle AND event_datestart = :eventdate");
    } else {
        $stmt = $port_db->prepare("INSERT INTO tbl_events (event_postby, event_title, event_datestart, event_file) 
            VALUES (:employee, :eventTitle, :eventdate, :eventimage)");
    }

    $stmt->bindParam(':employee', $user_id);
    $stmt->bindParam(':eventTitle', $eventTitle);
    $stmt->bindParam(':eventdate', $eventdate);
    $stmt->bindParam(':eventimage', $eventimage);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Data saved successfully!']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error saving data.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
?>
