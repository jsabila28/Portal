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
        $conn = self::getDatabaseConnection('hr');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl_memo WHERE LEFT(memo_date, 4) = ? ORDER BY memo_date DESC LIMIT 3");
            $stmt->execute([$Year]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }

    public static function GetAllMemo($Year) {
        $conn = self::getDatabaseConnection('hr');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl_memo WHERE LEFT(memo_date, 4) = ? ORDER BY memo_date DESC");
            $stmt->execute([$Year]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }

    public static function GetLeave($date) {
        $conn = self::getDatabaseConnection('hr');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl201_leave a
                LEFT JOIN tbl201_basicinfo b
                ON a.`la_empno` = b.`bi_empno`
                LEFT JOIN tbl201_jobrec c
                ON c.`jrec_empno` = a.`la_empno`
                LEFT JOIN tbl_department d
                ON d.`Dept_Code` = c.`jrec_department`
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
        $conn = self::getDatabaseConnection('hr');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl201_leave a
                LEFT JOIN tbl201_basicinfo b
                ON a.`la_empno` = b.`bi_empno`
                LEFT JOIN tbl201_jobrec c
                ON c.`jrec_empno` = a.`la_empno` 
                LEFT JOIN tbl_department d
                ON d.`Dept_Code` = c.`jrec_department`
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
        $conn = self::getDatabaseConnection('hr');

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

    public static function GetGovAnn($yearMonth) {
        $conn = self::getDatabaseConnection('hr');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl_announcement a
            LEFT JOIN tbl201_basicinfo b ON a.ann_approvedby = b.bi_empno
            WHERE a.ann_type = 'GOVERNMENT'
            AND DATE_FORMAT(a.ann_end, '%Y-%m') >= ?
            GROUP BY a.`ann_id`
            ORDER BY a.`ann_id` DESC");
            $stmt->execute([$yearMonth]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }

    public static function GetDepartments() {
        $conn = self::getDatabaseConnection('hr');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl_department WHERE Dept_Stat = 'active' ORDER BY Dept_Name ASC");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }

    public static function GetCompany() {
        $conn = self::getDatabaseConnection('hr');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl_company WHERE C_Remarks = 'active' ORDER BY C_Name ASC");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }

    public static function GetEmployee() {
        $conn = self::getDatabaseConnection('hr');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl201_basicinfo a
                    LEFT JOIN tbl201_jobrec b
                    ON a.`bi_empno` = b.`jrec_empno`
                    LEFT JOIN tbl201_jobinfo c
                    ON c.`ji_empno` = b.`jrec_empno`
                    WHERE a.`datastat` = 'current'
                    AND b.`jrec_status` = 'Primary'
                    AND c.`ji_remarks` = 'Active'
                    GROUP BY a.`bi_empno` ORDER BY a.`bi_emplname` ASC");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }

    public static function GetBirthday($birthM,$birthD) {
        $conn = self::getDatabaseConnection('hr');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl201_persinfo a
                    LEFT JOIN tbl201_basicinfo b
                    ON b.`bi_empno` = a.`pi_empno`
                    LEFT JOIN tbl201_jobrec c
                    ON c.`jrec_empno` = b.`bi_empno`
                    LEFT JOIN tbl201_jobinfo d
                    ON d.`ji_empno` = c.`jrec_empno`
                    WHERE MONTH(pi_dbirth) = ?
                    AND DAY(pi_dbirth) = ?
                    AND ji_remarks = 'Active'
                    AND jrec_status = 'Primary'
                    ");
            $stmt->execute([$birthM,$birthD]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
    } 

}
?>
