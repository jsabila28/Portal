<?php
header('Content-Type: application/json');
header('Content-Type: text/html; charset=UTF-8');
$connection = new mysqli("localhost", "root", "", "portal_db");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch barangay based on municipality
if (isset($_GET['municipality'])) {
    $municipalityId = $_GET['municipality'];

    $query = "SELECT * FROM tbl_barangay WHERE br_city = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $municipalityId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
            echo "<option value=''>Select Barangay</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['br_id'] . "'>" . $row['br_name'] . "</option>";
        }
    } else {
        echo "<option value=''>No barangays found</option>";
    }
}

$connection->close();
?>
