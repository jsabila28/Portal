<?php
require_once($sr_root . "/db/db.php");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not authenticated']);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $port_db = Database::getConnection('port');
    $hr_db = Database::getConnection('hr');

   
$stmt = $port_db->prepare("
	    SELECT 
	    ir.ir_subject,
	    ir.ir_date,
	    CONCAT(bi_from.bi_empfname,' ',bi_from.bi_emplname) AS ir_from_fullname,
	    CONCAT(bi_to.bi_empfname,' ',bi_to.bi_emplname) AS ir_to_fullname
	FROM 
	    tbl_ir ir
	LEFT JOIN 
	    tbl201_basicinfo bi_from ON ir.ir_from = bi_from.bi_empno
	LEFT JOIN 
	    tbl201_basicinfo bi_to ON ir.ir_to = bi_to.bi_empno
	WHERE ir.ir_stat = 'draft'
	    -- WHERE ir_from = ?
	");
$stmt->execute();
$draft_ir = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($draft_ir)) {

	echo "<table class='sticky-table'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>Date</th>";
	echo "<th>From</th>";
	echo "<th>To</th>";
	echo "<th>Subject</th>";
	echo "<th></th>";
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
      foreach ($draft_ir as $dir) {
     	echo "<tr>";
     	echo "<td>";
     	echo isset($dir['ir_date']) && !empty($dir['ir_date']) ? htmlspecialchars((new DateTime($dir['ir_date']))->format('F j, Y')): 'Invalid date';	
     	echo "</td>";
     	echo "<td>" . htmlspecialchars($dir['ir_from_fullname']) . "</td>";
     	echo "<td>" . htmlspecialchars($dir['ir_to_fullname']) . "</td>";
     	echo "<td>" . htmlspecialchars($dir['ir_subject']) . "</td>";
     	echo "<td><a href='#!'><i class='zmdi zmdi-eye' style='font-size: 14px;'></i></a></td>";
     	echo "</tr>";
      } 
    echo "<tbody>"; 
	echo "</table>";
}   

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
