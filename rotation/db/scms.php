<?php
require_once($pi_root."/db/db.php");

/**
* 
*/
class Paymaster
{
    
    function __construct()
    {
    }

    public static function getPaymasterData($month, $year)
    {
        $conn = Database::getConnection('scms');

        $sql = $conn->prepare("SELECT
                a.`controlno` AS CTRLNO,CONCAT(i.`lname`, ', ', i.fname, ' ',i.mname) AS CUSTOMER
                ,LEFT(a.`date_happen`,10) AS TRNDATE
                ,LEFT(c.`date_happen`,10) AS LAPDATE
                ,LEFT(n.`date_happen`, 10) AS MTODATE
                ,LEFT(n.`date_expired`, 10) AS EXPDATE
                ,q.`stockcode` AS STOCKCODE
                ,COALESCE(j.`price`,k.`price`,n.`amortization`) AS GROSSAMT
                ,a.`credit` AS AMOUNT
                ,a.`balance` AS BALANCE,
                CASE
                WHEN g.`short_desc` = 'DOWN PAYMENT' THEN 'DOWN PAYMENT'
                WHEN g.`short_desc` = 'INSTALLMENT' THEN 'FOLLOW UP PAYMENT'
                WHEN g.`short_desc` = 'PAYMENT, FINAL' THEN 'FINAL PAYMENT'
                ELSE g.`short_desc`
                END AS CHARGECODE,
                CASE
                WHEN g.`short_desc` ='INSTALLMENT' THEN ah.`description`
                ELSE m.`description`
                END AS TRNSTATUS,
                CASE
                WHEN f.`short_desc` = 'MTO' THEN 'CO'
                WHEN f.`short_desc` = 'REG' THEN 'SALE'
                WHEN f.`short_desc` = 'LAP' THEN 'LAP'
                ELSE f.`short_desc`
                END AS TRNTYPE
                ,h.`description` AS PAYTYPE
                ,LEFT (a.trans_owner,2) AS OUTLET
                ,u.`short_desc`AS ITMCLASS
                FROM pos_mop a
                LEFT JOIN pos_sale b ON b.`id`=a.`sale_id`
                LEFT JOIN pos_lap c ON c.`controlno`=a.`trans_owner`
                LEFT JOIN pos_fu d ON d.`id`=a.`fu_id`
                LEFT JOIN pos_mto n ON n.`controlno`=a.`trans_owner`
                LEFT JOIN pos_fo p ON p.`id`=a.`forfeit_id`
                LEFT JOIN pos_fo_details ab ON ab.`fo_id`=p.`id`
                LEFT JOIN pos_sale_details j ON j.`sale_id`=b.`id`
                LEFT JOIN pos_lap_details k ON k.`lap_id`=c.`id`
                LEFT JOIN pos_mto_details o ON o.`mto_id` AND o.status <>'0' =n.`id`
                LEFT JOIN pos_interest_penalty aa ON aa.`id`=a.`interest_id`
                LEFT JOIN tblbranch e ON e.`id`=a.`branch_id`
                LEFT JOIN system_sale_type f ON f.`id`= COALESCE(b.`sale_type_id`,d.`sale_type_id`,p.`sale_type_id`,aa.`sale_type_id`,a.`sale_type_id`)
                LEFT JOIN system_payment_type g ON g.`id`=a.`payment_type_id`
                LEFT JOIN system_payment_mode h ON h.`id`=a.`payment_mode_id` /*COALESCE(a.`payment_mode_id`,ab.`payment_type_id`)*/
                LEFT JOIN pos_customers i ON i.`id`=COALESCE(b.`customer_id`,c.`customer_id`,d.`customer_id`,n.`customer_id`,p.`customer_id`)
                LEFT JOIN system_status m ON m.`id`=a.`status`
                LEFT JOIN product q ON q.`id`=COALESCE(j.`product_id`,k.`product_id`)
                LEFT JOIN preset_jewelry ad ON ad.`id`=q.`jewelry_id`
                LEFT JOIN preset_gold r ON r.`id`=q.`gold_id`
                LEFT JOIN preset_color s ON s.`id`=q.`color_id`
                LEFT JOIN preset_karat t ON t.`id`=q.`karat_id`
                LEFT JOIN preset_classification u ON u.`id`=q.`classification_id`
                LEFT JOIN preset_design v ON v.`id`=q.`design_id`
                LEFT JOIN preset_designdetails w ON w.`id`=q.`designdetails_id`
                LEFT JOIN preset_designtype z ON z.`id`=q.`designtype_id`
                LEFT JOIN pos_user ac ON ac.`id`= COALESCE(d.`credit_user_id`,b.`user_id`,c.`credit_user_id`,n.`credit_user_id`)
                LEFT JOIN system_status ah ON ah.id = d.status
                LEFT JOIN pos_mto_date ae ON ae.`mto_id` = n.`id`
                LEFT JOIN preset_area af ON af.`id`=e.`area`
                WHERE
                a.`payment_type_id` NOT IN ('10','2','7','5','6','12','11')
                AND a.`status` <> '0'
                AND e.code NOT IN ('CA','KT','L1','L2','S1','S2')
                AND h.id <> '4'
                AND LEFT(a.`date_happen`,10) BETWEEN ? AND ?
                ORDER BY a.`date_happen` DESC");

        $start_date = $year . '-' . $month . '-01';
        $end_date = $year . '-' . $month . '-31';

        $sql->bind_param("ss", $start_date, $end_date);
        $sql->execute();
        // $result = $sql->get_result();

        return $sql->fetch_assoc();
    }
}
?>
