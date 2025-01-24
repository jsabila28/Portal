<?php
header('Content-Type: application/json');
header('Content-Type: text/html; charset=UTF-8');
$connection = new mysqli("localhost", "root", "", "portal_db");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Query to get provinces
$query = "SELECT * FROM tbl_province";
$result = $connection->query($query);

if ($result->num_rows > 0) {
    	echo "<option value=''>Select Province</option>";
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['pr_code'] . "'>" . $row['pr_name'] . "</option>";
    }
} else {
    echo "<option value=''>No provinces found</option>";
}

$connection->close();
?>
