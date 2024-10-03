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

    public static function GetMemo($Year) {
        $conn = self::getDatabaseConnection('port');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl_memo WHERE LEFT(memo_date, 4) = ? ORDER BY memo_date DESC LIMIT 3");
            $stmt->execute([$Year]);

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
                AND a.`la_start` >= ?
                GROUP BY a.`la_empno`,a.`la_start`
                ORDER BY a.`la_start` ASC LIMIT 3");
            $stmt->execute([$date]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }
    public static function GetOngoingLeave($date) {
        $conn = self::getDatabaseConnection('port');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl201_leave a
                LEFT JOIN tbl201_basicinfo b
                ON a.`la_empno` = b.`bi_empno`
                LEFT JOIN tbl201_jobrec c
                ON c.`jrec_empno` = a.`la_empno`
                WHERE a.`la_status` NOT IN ('cancelled','draft','pending')
                AND a.`la_start` <= ?
                AND a.`la_return` >= ?
                GROUP BY a.`la_empno`,a.`la_start`
                ORDER BY a.`la_start` ASC LIMIT 3");
            $stmt->execute([$date,$date]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }
    public static function GetResigning($date) {
        $conn = self::getDatabaseConnection('port');

        if ($conn) {
            $stmt = $conn->prepare("SELECT 
                bi_emplname, 
                bi_empfname, 
                bi_empmname, 
                jrec_department,
                jd_title,
                C_Name,
                xintvw_lastday ,
                xintvw_empno
                FROM tbl201_exit_intvw a
                LEFT JOIN tbl201_basicinfo b
                ON b.`bi_empno` = a.`xintvw_empno`
                LEFT JOIN tbl201_jobrec c
                ON c.`jrec_empno` = b.`bi_empno`
                LEFT JOIN tbl_jobdescription d
                ON d.`jd_code` = c.`jrec_position`
                LEFT JOIN tbl_company e
                ON e.`C_Code` = c.`jrec_company`
                WHERE c.`jrec_status` = 'Primary'
                AND c.`jrec_type` = 'Primary'
                AND a.`xintvw_lastday` >= ?
                GROUP BY xintvw_empno LIMIT 3");
            $stmt->execute([$date]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }

}
?>
