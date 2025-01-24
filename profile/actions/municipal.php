<?php
header('Content-Type: application/json');
header('Content-Type: text/html; charset=UTF-8');
$connection = new mysqli("localhost", "root", "", "portal_db");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch municipality based on province
if (isset($_GET['province_id'])) {
    $provinceId = $_GET['province_id'];

    $query = "SELECT * FROM tbl_municipality WHERE ct_province = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $provinceId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
            echo "<option value=''>Select Municipality</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['ct_id'] . "'>" . $row['ct_name'] . "</option>";
        }
    } else {
        echo "<option value=''>No municipalities found</option>";
    }
}

$connection->close();
?>
