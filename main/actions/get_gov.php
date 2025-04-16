<?php
require_once($sr_root . "/db/db.php");

try {
    $port_db = Database::getConnection('hr');
    $yearMonth = date("Y-m");
    // Fetch ads from tbl_announcement
    $stmt = $port_db->prepare("SELECT a.ann_title AS title, a.ann_content AS image
                               FROM tbl_announcement a
                               LEFT JOIN tbl201_basicinfo b ON a.ann_approvedby = b.bi_empno
                               WHERE a.ann_type = 'GOVERNMENT'
                               AND DATE_FORMAT(a.ann_end, '%Y-%m') >= ?
                               GROUP BY a.ann_id
                               ORDER BY a.ann_id DESC");
    $stmt->execute([$yearMonth]);
    $ads = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($ads);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
