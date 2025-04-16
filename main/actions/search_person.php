<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=portal_db;charset=utf8mb4", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

    
    $query = isset($_POST['query']) ? trim($_POST['query']) : '';

    if (!empty($query)) {
        $stmt = $pdo->prepare("SELECT a.*
            FROM 
                tbl201_basicinfo a
            LEFT JOIN 
                tbl201_jobrec b ON a.bi_empno = b.jrec_empno
            LEFT JOIN 
                tbl_jobdescription jd ON jd.jd_code = b.jrec_position
            LEFT JOIN 
                tbl201_jobinfo ji ON ji.ji_empno = a.bi_empno
                WHERE a.datastat = 'current'
                AND b.jrec_type = 'Primary'
                AND b.jrec_status = 'Primary'
                AND ji.ji_remarks = 'Active'
                AND (a.bi_emplname LIKE :query OR a.bi_empfname LIKE :query)
                GROUP BY a.bi_empno");

        $stmt->execute(['query' => $query . '%']);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row) {
            echo "<div class='mention-item'>" . htmlspecialchars($row['bi_empfname'] . ' ' . $row['bi_emplname']) . "</div>";
        }
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
