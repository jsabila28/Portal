<?php
require_once($pi_root . "/db/db.php");

class Credit
{
	private $pi_db = null;

	function __construct()
	{
		// $this->hr_db = Database::getConnection('hr');
	}
	public static function GetOutlet() {
	    $stmt = Database::getConnection('scms')->query("SELECT * FROM tblbranch WHERE
				status = '1'
				AND code NOT IN ('SCZ','SCI','CA','L2','SCV','FB','S1','SR','AP','C1','KT','SCM','L1','XDMP','MWH','ZRS','LOS')");
	    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	    if ($result) {
	        return $result;
	    } else {
	        return [];
	    }
	}

	public static function GetPaymaster() {
	    $stmt = Database::getConnection('scms')->query("SELECT * FROM
			(SELECT i.`controlno` AS Customer_ID, 
				CONCAT(i.`lname`,', ',i.`fname`,' ',i.`mname`) AS FULLNAME, 
				a.`controlno`  AS InvoiceNo,
				a.`or_number` AS OR_NO,
				LEFT(a.`date_happen`,10) AS TRNDATE, 
				acc.`account_code`,
				CASE WHEN e.`id` = '38' THEN 'FB'
					ELSE RIGHT(e.`abb`,2)
					END AS OUTLET,
				CASE WHEN f.`short_desc` = 'MTO' THEN 'CO'
					WHEN f.`short_desc` = 'REG' THEN 'SALE'
					WHEN f.`short_desc` = 'LAP' THEN 'LAP'
					ELSE f.`short_desc`
					END AS TRNTYPE,
				a.`credit` AS AMOUNT,  
				h.`description` AS PAYTYPE,  
				pcc.`description`,  
				COALESCE(j.`price`,k.`price`,n.`amortization`) AS TAGPRICE
			FROM pos_mop a
			LEFT JOIN pos_sale b ON b.`id`=a.`sale_id`
			LEFT JOIN pos_lap c ON c.`controlno`=a.`trans_owner`
			LEFT JOIN pos_fu d ON d.`id`=a.`fu_id`
			LEFT JOIN pos_mto n ON n.`controlno`=a.`trans_owner`
			LEFT JOIN pos_fo p ON p.`id`=a.`forfeit_id`
			LEFT JOIN pos_fo_details ab ON ab.`fo_id`=p.`id`
			LEFT JOIN pos_sale_details j ON j.`sale_id`=b.`id`
			LEFT JOIN pos_lap_details k ON k.`lap_id`=c.`id`
			LEFT JOIN pos_mto_details o ON o.`mto_id`=n.`id`
			LEFT JOIN pos_interest_penalty aa ON aa.`id`=a.`interest_id`
			LEFT JOIN tblbranch e ON e.`id`=a.`branch_id`
			LEFT JOIN system_sale_type f ON f.`id`= COALESCE(b.`sale_type_id`,d.`sale_type_id`,p.`sale_type_id`,aa.`sale_type_id`,a.`sale_type_id`)
			LEFT JOIN system_payment_type g ON g.`id`=a.`payment_type_id`
			LEFT JOIN system_payment_mode h ON h.`id`=a.`payment_mode_id` /*COALESCE(a.`payment_mode_id`,ab.`payment_type_id`)*/
			LEFT JOIN pos_customers i ON i.`id`=COALESCE(b.`customer_id`,c.`customer_id`,d.`customer_id`,n.`customer_id`,p.`customer_id`)
			LEFT JOIN system_status m ON m.`id`=a.`status`
			LEFT JOIN pos_user ac ON ac.`id`= COALESCE(c.`credit_user_id`,n.`credit_user_id`,d.`credit_user_id`,b.`user_id`)
			LEFT JOIN system_status ah ON ah.`id` = d.`status`
			LEFT JOIN pos_mto_date ae ON ae.`mto_id` = n.`id`
			LEFT JOIN preset_area af ON af.`id`=e.`area`
			LEFT JOIN pos_creditcard_type pcc ON pcc.`id` = a.`credit_card_id`
			LEFT JOIN acc_account_code acc ON acc.`branch_id` = e.`id`
			WHERE a.`payment_type_id` NOT IN ('10','2','7','5','6','12','11') 
			AND a.`status` <> '0'
			AND e.`code` <> 'CA'
			AND h.`id` NOT IN('1','4','9','5')
			AND MONTH(a.`date_happen`) = '07'
			-- AND LEFT(a.`date_happen`,10) BETWEEN '2024-06-01' AND '2024-06-05'
			GROUP BY a.`controlno`) tbl1
			LEFT JOIN
			(SELECT i.`controlno` AS Customer_ID, 
				a.`or_number` AS OR_no,
 				CONCAT(i.`lname`,', ',i.`fname`,' ',i.`mname`) AS Client, 
 				LEFT(a.`date_happen`,10) AS TrnDate,
 				CASE WHEN e.`id` = '38' THEN 'FB'
					ELSE RIGHT(e.`abb`,2)
					END AS Outlet,
				CASE WHEN f.`short_desc` = 'MTO' THEN 'CO'
					WHEN f.`short_desc` = 'REG' THEN 'SALE'
					WHEN f.`short_desc` = 'LAP' THEN 'LAP'
					ELSE f.`short_desc`
					END AS TrnType,

				a.`credit` AS CREDIT,  
				h.`description` AS PayType, 
				CASE WHEN g.`short_desc` = 'INSTALLMENT' THEN 'FOLLOW UP'
					WHEN g.`short_desc` = 'PAYMENT, FINAL' THEN 'FINAL PAYMENT'
					ELSE g.`short_desc`
					END AS ChargeCode
			FROM pos_mop a
			LEFT JOIN pos_sale b ON b.`id`=a.`sale_id`
			LEFT JOIN pos_lap c ON c.`controlno`=a.`trans_owner`
			LEFT JOIN pos_fu d ON d.`id`=a.`fu_id`
			LEFT JOIN pos_mto n ON n.`controlno`=a.`trans_owner`
			LEFT JOIN pos_fo p ON p.`id`=a.`forfeit_id`
			LEFT JOIN pos_fo_details ab ON ab.`fo_id`=p.`id`
			LEFT JOIN pos_sale_details j ON j.`sale_id`=b.`id`
			LEFT JOIN pos_lap_details k ON k.`lap_id`=c.`id`
			LEFT JOIN pos_mto_details o ON o.`mto_id`=n.`id`
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
			LEFT JOIN pos_user ac ON ac.`id`= COALESCE(c.`credit_user_id`,n.`credit_user_id`,d.`credit_user_id`,b.`user_id`)
			LEFT JOIN system_status ah ON ah.id = d.status
			LEFT JOIN pos_mto_date ae ON ae.`mto_id` = n.`id`
			LEFT JOIN preset_area af ON af.`id`=e.`area`
			LEFT JOIN pos_creditcard_type crt ON crt.`id`= COALESCE(b.`sale_type_id`,d.`sale_type_id`,p.`sale_type_id`,aa.`sale_type_id`,a.`sale_type_id`) 
			LEFT JOIN tblsupplier sup ON sup.`id` = q.`supplier_id`
			LEFT JOIN pos_sales_discount zz   ON zz.sales_id = b.id
			LEFT JOIN pos_sales_discount zy   ON zy.sales_id = b.id
			LEFT JOIN pos_sales_discount_list zx ON zx.id=zz.promo_disc_id
			LEFT JOIN pos_promo zw ON zw.id=zy.promo_disc_id
			WHERE a.`payment_type_id` IN ('7','2')
				AND a.`status` <> '0'
				AND MONTH(a.`date_happen`) = '07'
			ORDER BY a.`date_happen` ASC) tbl2
		ON tbl1.Customer_ID = tbl2.Customer_ID
		AND tbl1.OR_NO = tbl2.OR_no");
	    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	    if ($result) {
	        return $result;
	    } else {
	        return [];
	    }
	}
	
	// public static function GetCCard() {
	//     $stmt = Database::getConnection('ccard')->query("SELECT * FROM tbl_paymaster");
	//     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	//     if ($result) {
	//         return $result;
	//     } else {
	//         return [];
	//     }
	// }

	 public static function GetCCard($selectedMonth = '') {
        // Prepare the base query
        $query = "SELECT * FROM tbl_paymaster";
        
        // Add filtering if month is selected
        if ($selectedMonth) {
            $query .= " WHERE MONTH(TrnDate) = :month";
        }
        
        // Prepare and execute the statement
        $stmt = Database::getConnection('ccard')->prepare($query);

        if ($selectedMonth) {
            $stmt->bindValue(':month', $selectedMonth, PDO::PARAM_INT);
        }

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : [];
    }

	
	public static function Discount($sys_code) {
        $conn = self::getDatabaseConnection('pi');
        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tbl_module WHERE module_sys_id = ?");
            $stmt->execute([$sys_code]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        return [];
    }

	public static function GetModules()
    {
        $stmt = Database::getConnection('pi')->query("SELECT * FROM tbl_modules");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode($result); // Output JSON data
        } else {
            echo json_encode([]); // Output an empty array if no data found
        }
    }
}

// if (isset($_GET['method']) && method_exists('Credit', $_GET['method'])) {
//     Credit::{$_GET['method']}(); // Call the method dynamically
// } else {
//     http_response_code(400); // Bad Request
//     echo json_encode(['error' => 'Invalid method']);
// }
?>