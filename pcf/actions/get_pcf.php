<?php
require_once($pcf_root . "/db/db.php");

class PCF
{
    private static function getDatabaseConnection($db) {
        try {
            return Database::getConnection($db);
        } catch (Exception $e) {
            return null;
        }
    }

    public static function GetPCFdetail($user_id,$outlet) {
        $conn = self::getDatabaseConnection('pcf');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl_issuance 
                WHERE custodian = ?
                OR outlet_dept = ?
                AND status = '1'
                ");
            $stmt->execute([$user_id,$outlet]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }

    public static function GetPCFAcc($user_id) {
        $conn = self::getDatabaseConnection('pcf');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl_issuance 
                WHERE custodian = ?
                AND status = '1'
                ");
            $stmt->execute([$user_id]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }

    public static function GetPCFAsignatory($dept,$user_id) {
        $conn = self::getDatabaseConnection('hr');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl201_basicinfo a
            LEFT JOIN tbl201_jobrec b
            ON b.`jrec_empno` = a.`bi_empno`
            LEFT JOIN tbl201_jobinfo c
            ON c.`ji_empno` = b.`jrec_empno`
            LEFT JOIN tbl_area ar ON ar.`Area_Code` = b.`jrec_area`
            WHERE a.`datastat` = 'current'
            AND b.`jrec_status` = 'Primary'
            AND c.`ji_remarks` = 'Active'
            AND b.`jrec_department` = ?
            AND a.`bi_empno` = ?
            AND b.`jrec_position` IN ('SIC','TL','DIR')
            ORDER BY a.`bi_emplname` ASC
                ");
            $stmt->execute([$dept,$user_id]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }

    public static function GetReplenishList($user_id,$outlet) {
        $conn = self::getDatabaseConnection('pcf');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl_replenish 
                WHERE repl_custodian = ?
                OR repl_outlet = ?
               ORDER BY repl_no DESC
                ");
            $stmt->execute([$user_id,$outlet]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }

    public static function GetReplenish($ID) {
        $conn = self::getDatabaseConnection('pcf');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl_disbursement_entry
                WHERE dis_replenish_no = ?
                ORDER BY dis_no ASC
                ");
            $stmt->execute([$ID]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }

    public static function GetCashOnHand($custodian,$outlet) {
        $conn = self::getDatabaseConnection('pcf');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl_replenish
                WHERE repl_custodian = ?
                AND repl_outlet = ?
                AND repl_status IN ('submit','approved','checked','updated','returned','signed')
                ");
            $stmt->execute([$custodian,$outlet]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }

    public static function GetCOH($ID) {
        $conn = self::getDatabaseConnection('pcf');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl_replenish
                WHERE repl_no = ?
                ");
            $stmt->execute([$ID]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }
    // public static function GetIntransit($custodian,$outlet) {
    //     $conn = self::getDatabaseConnection('pcf');

    //     if ($conn) {
    //         $stmt = $conn->prepare("SELECT * FROM tbl_replenish
    //             WHERE repl_custodian = ?
    //             AND repl_outlet = ?
    //             AND repl_status IN ('submit','approved','checked','updated','returned','signed')
    //             ");
    //         $stmt->execute([$custodian,$outlet]);

    //         return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    //     }
    //     return [];
    // }

    public static function GetDisburement($outlet,$custodian) {
        $conn = self::getDatabaseConnection('pcf');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl_disbursement_entry 
                WHERE dis_outdept = ?
                AND dis_empno = ?
                AND dis_replenish_no IS NULL
                OR dis_replenish_no = ' '
                ");
            $stmt->execute([$outlet,$custodian]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }
    public static function GetAttachment($disbNo) {
        $conn = self::getDatabaseConnection('pcf');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl_attachment
                WHERE disbur_no = ?
                ");
            $stmt->execute([$disbNo]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }
    public static function GetComment($disbNo) {
        $conn = self::getDatabaseConnection('pcf');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl_comment
                WHERE com_disb_no = ?
                ");
            $stmt->execute([$disbNo]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }

    public static function GetCashCount($custodian,$outlet) {
        $conn = self::getDatabaseConnection('pcf');

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl_cash_count
                WHERE cc_custodian = ?
                AND cc_unit = ?
                ");
            $stmt->execute([$custodian,$outlet]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }

    public static function GetSign($ID) {
    $hr = self::getDatabaseConnection('hr');
    $pcf = self::getDatabaseConnection('pcf');

    $result = [];

    if ($pcf) {
        // Fetch records from `tbl_signatures`
        $stmt = $pcf->prepare("SELECT * FROM tbl_signatures WHERE replenish_no = ?");
        $stmt->execute([$ID]);
        $signatures = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

        foreach ($signatures as &$signature) {
            $cust_empno = $signature['custodian'];
            $approve_empno = $signature['approver'];
            $check_empno = $signature['checker'];
            $fin_empno = $signature['fin_diret'];

            if ($hr) {
                // Fetch employee details from `hr_table`
                $stmt = $hr->prepare("SELECT bi_empno, bi_empfname, bi_emplname FROM tbl201_basicinfo WHERE bi_empno IN (?, ?, ?, ?)");
                $stmt->execute([$cust_empno, $approve_empno, $check_empno, $fin_empno]);
                $employees = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

                // Merge employee details
                foreach ($employees as $emp) {
                    if ($emp['bi_empno'] == $cust_empno) {
                        $signature['cust_name'] = $emp['bi_empfname'] . ' ' . $emp['bi_emplname'];
                    }
                    if ($emp['bi_empno'] == $approve_empno) {
                        $signature['approve_name'] = $emp['bi_empfname'] . ' ' . $emp['bi_emplname'];
                    }
                    if ($emp['bi_empno'] == $check_empno) {
                        $signature['checker_name'] = $emp['bi_empfname'] . ' ' . $emp['bi_emplname'];
                    }
                    if ($emp['bi_empno'] == $fin_empno) {
                        $signature['director_name'] = $emp['bi_empfname'] . ' ' . $emp['bi_emplname'];
                    }
                }
            }
        }
        $result = $signatures;
    }

    return $result;
}


}
?>
