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

    public static function GetDirectives($Year,$empno,$company,$department,$area,$outlet) {
        $conn = self::getDatabaseConnection('port');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl_memo 
                WHERE LEFT(memo_date, 4) = ?
                AND (
                    memo_recipient = 'All'
                    OR memo_recipient = ''
                    OR REPLACE(memo_recipient, ' ', '') LIKE CONCAT(?, ',%')
                    OR REPLACE(memo_recipient, ' ', '') LIKE CONCAT(?, ',%')
                    OR REPLACE(memo_recipient, ' ', '') LIKE CONCAT(?, ',%')
                    OR REPLACE(memo_recipient, ' ', '') LIKE CONCAT('%,', ?)
                    OR REPLACE(memo_recipient, ' ', '') LIKE CONCAT('%,', ?, ',%')
                )
                AND memo_type = 'policies'
                ORDER BY memo_date DESC LIMIT 5
                ");
            $stmt->execute([$Year,$empno,$company,$department,$area,$outlet]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }

    public static function GetPromotions($Year,$empno,$company,$department,$area,$outlet) {
        $conn = self::getDatabaseConnection('port');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl_memo 
                WHERE LEFT(memo_date, 4) = ?
                AND (
                    memo_recipient = 'All'
                    OR memo_recipient = ''
                    OR REPLACE(memo_recipient, ' ', '') LIKE CONCAT(?, ',%')
                    OR REPLACE(memo_recipient, ' ', '') LIKE CONCAT(?, ',%')
                    OR REPLACE(memo_recipient, ' ', '') LIKE CONCAT(?, ',%')
                    OR REPLACE(memo_recipient, ' ', '') LIKE CONCAT('%,', ?)
                    OR REPLACE(memo_recipient, ' ', '') LIKE CONCAT('%,', ?, ',%')
                )
                AND memo_type = 'marketing'
                ORDER BY memo_date DESC LIMIT 5
                ");
            $stmt->execute([$Year,$empno,$company,$department,$area,$outlet]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }

    // public static function GetMemo() {
    //     $conn = self::getDatabaseConnection('port');

    //     if ($conn) {
    //         $stmt = $conn->prepare("SELECT * FROM tbl_memo");
    //         $stmt->execute();

    //         return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    //     }
    //     return [];
    // }

    public static function GetAllMemo($Year,$empno,$company,$department,$area,$outlet) {
        $conn = self::getDatabaseConnection('port');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl_memo 
                WHERE LEFT(memo_date, 4) = ?
                AND (
                    memo_recipient = 'All'
                    OR memo_recipient = ''
                    OR REPLACE(memo_recipient, ' ', '') LIKE CONCAT(?, ',%')
                    OR REPLACE(memo_recipient, ' ', '') LIKE CONCAT(?, ',%')
                    OR REPLACE(memo_recipient, ' ', '') LIKE CONCAT(?, ',%')
                    OR REPLACE(memo_recipient, ' ', '') LIKE CONCAT('%,', ?)
                    OR REPLACE(memo_recipient, ' ', '') LIKE CONCAT('%,', ?, ',%')
                )
                ORDER BY memo_date DESC");
            $stmt->execute([$Year,$empno,$company,$department,$area,$outlet]);

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
                WHERE a.`la_status` = 'approved'
                AND a.`la_end` >= ?
                GROUP BY a.`la_empno`,a.`la_start`
                ORDER BY a.`la_start` ASC");
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
                ORDER BY a.`la_start` ASC");
            $stmt->execute([$date,$date]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }
    public static function GetResigning($Year) {
        $conn = self::getDatabaseConnection('hr');

        if ($conn) {
            $stmt = $conn->prepare("SELECT 
            ji_empno,
            CONCAT(bi_empfname,' ',bi_emplname) AS Fullname,
            jd_title,
            C_Name,
            ji_resdate
             FROM tbl201_jobinfo a
            LEFT JOIN tbl201_basicinfo b 
            ON b.`bi_empno` = a.`ji_empno`
            LEFT JOIN tbl201_jobrec c
            ON c.`jrec_empno` = b.`bi_empno`
            LEFT JOIN tbl_jobdescription d
            ON d.`jd_code` = c.`jrec_position`
            LEFT JOIN tbl_company e
            ON e.`C_Code` = c.`jrec_company`
            WHERE a.`ji_resdate` != ''
            AND jrec_status = 'Primary'
            AND datastat = 'current'
            AND YEAR(ji_resdate) = ?
            GROUP BY a.`ji_empno`
            ORDER BY ji_resdate DESC");
            $stmt->execute([$Year]);

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

    public static function GetArea() {
        $conn = self::getDatabaseConnection('hr');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl_area WHERE Area_stat = 'active' ORDER BY Area_Name ASC");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }

    public static function GetOutlet() {
        $conn = self::getDatabaseConnection('hr');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl_outlet WHERE OL_stat = 'active' ORDER BY OL_Name ASC");
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
                    LEFT JOIN tbl_department d ON d.`Dept_Code` = b.`jrec_department`
                    LEFT JOIN tbl_company e ON e.`C_Code` = b.`jrec_company`
                    LEFT JOIN tbl_outlet f ON f.`OL_Code` = b.`jrec_outlet`
                    LEFT JOIN tbl_area g ON g.`Area_Code` = b.`jrec_area`
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
                    AND jrec_company IN ('SJI','TNGC','QST')
                    GROUP BY bi_empno
                    ");
            $stmt->execute([$birthM,$birthD]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
    }
    public static function GetMood($date,$empno) {
        $conn = self::getDatabaseConnection('port');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl_mood
            WHERE DATE(m_date) = ?
            AND (m_disp_type = 'Public' OR m_empno = ?);");
            $stmt->execute([$date,$empno]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
    }

    public static function GetMyMood($date,$user_id) {
        $conn = self::getDatabaseConnection('port');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl_mood 
                WHERE DATE(m_date) = ?
                AND m_empno = ?");
            $stmt->execute([$date,$user_id]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
    }

    public static function GetEvents($date) {
        $conn = self::getDatabaseConnection('port');

        if ($conn) {
            $stmt = $conn->prepare("SELECT 
                DAY(event_date) AS days,
                MONTHNAME(event_date) AS months,
                event_file
                FROM tbl_events 
                WHERE event_dateend >= ?
                ORDER BY event_date");
            $stmt->execute([$date]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
    } 

}
?>
