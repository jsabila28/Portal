<?php
require_once($sr_root . "/db/db.php");

try {
    $port_db = Database::getConnection('port');
    $hr_db = Database::getConnection('hr');

    $com_id = $_GET['com_id'] ?? null;

    if ($com_id) {
        $stmt = $port_db->prepare("
            SELECT 
                a.*, 
                b.bi_empfname, 
                b.bi_emplname 
            FROM tbl_post_comment a
            LEFT JOIN tbl201_basicinfo b ON b.bi_empno = a.com_post_by
            WHERE a.com_post_id = ?
            ORDER BY a.com_id DESC
            LIMIT 1
        ");
        $stmt->execute([$com_id]);
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($comments as $c) {
            echo '<div class="cardbox-base-comment">';
            echo '<div class="media m-1">';
            echo '<div class="d-flex mr-1" style="margin-left: 20px;">';
            echo '<a href=""><img class="img-fluid rounded-circle" src="https://e-classtngcacademy.s3.ap-southeast-1.amazonaws.com/e-class/Thumbnail/img/' . htmlspecialchars($c['com_post_by']) . '.JPG" alt="User"></a>';
            echo '</div>';
            echo '<div class="media-body">';
            echo '<p class="m-0">' . htmlspecialchars($c['bi_empfname']) . ' ' . htmlspecialchars($c['bi_emplname']) . '</p>';
            echo '<small><span><i class="icon ion-md-pin"></i> ' . htmlspecialchars($c['com_content']) . '</span></small>';
            echo '<div class="comment-reply"><small><a>12m </a></small> <small><a style="cursor: pointer;">Reply</a></small></div>';
            echo '</div>'; // Close media-body
            echo '</div>'; // Close media
            echo '</div>'; // Close cardbox-base-comment
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
