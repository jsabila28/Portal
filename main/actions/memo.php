<?php
require_once($sr_root . "/db/db.php");

class Portal
{
    private static function getDatabaseConnection($db) {
        try {
            return Database::getConnection($db);
        } catch (Exception $e) {
            return null;
        }
    }

    public static function GetMemo($date) {
        $conn = self::getDatabaseConnection('port');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl_memo WHERE LEFT(memo_date, 4) = ? ORDER BY memo_date DESC");
            $stmt->execute([$date]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }

    public static function GetLeave($date) {
        $conn = self::getDatabaseConnection('port');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl201_leave a
                LEFT JOIN tbl201_basicinfo b
                ON a.`la_empno` = b.`bi_empno`
                LEFT JOIN tbl201_jobrec c
                ON c.`jrec_empno` = a.`la_empno`
                WHERE a.`la_status` NOT IN ('cancelled','draft','pending')
                AND LEFT(a.`la_start`, 4) = ?
                GROUP BY a.`la_empno`,a.`la_start`
                ORDER BY a.`la_start` ASC");
            $stmt->execute([$date]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }


}
?>
