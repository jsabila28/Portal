<?php
require_once($pi_root . '/db/db.php');

$sql = "SELECT 
    reg_sale.outlets,
    reg_sale.Area,
    reg_sale.Outlet,
    reg_sale.sales,
    lap_down.lap_dp,
    lap_follow.lap_fup,
    lap_final.lap_fp,
    co_down.co_dp,
    co_follow.co_fup,
    co_final.co_fp,
    platero.plat,
    refund.rfund,
    ccard.fees
FROM
(SELECT CONCAT(LEFT(Area,1),'',Outlet) AS outlets, Outlet, AREA,TrnDate,
SUM(CASE WHEN TrnType = 'SALE' 
         AND ChargeCode = 'FINAL PAYMENT' 
         AND ItemClass <> 'PLAT' 
         -- AND StockCode <> NULL
         THEN Amount 
         ELSE 0 
         END) AS sales
         FROM tbl_paymaster 
     GROUP BY AREA, Outlet) AS reg_sale
LEFT JOIN
(SELECT Outlet,
SUM(CASE WHEN TrnType = 'LAP' 
         AND ChargeCode = 'DOWN PAYMENT'
         THEN Amount 
         ELSE 0 
         END) AS lap_dp
         FROM tbl_paymaster 
     GROUP BY AREA, Outlet) AS lap_down
ON reg_sale.Outlet = lap_down.Outlet
LEFT JOIN
(SELECT Outlet,
SUM(CASE WHEN TrnType = 'LAP' 
         AND ChargeCode = 'FOLLOW UP PAYMENT'
         THEN Amount 
         ELSE 0 
         END) AS lap_fup
         FROM tbl_paymaster 
     GROUP BY AREA, Outlet) AS lap_follow
ON reg_sale.Outlet = lap_follow.Outlet
LEFT JOIN
(SELECT Outlet,
SUM(CASE WHEN TrnType = 'LAP' 
         AND ChargeCode = 'FINAL PAYMENT'
         THEN Amount 
         ELSE 0 
         END) AS lap_fp
         FROM tbl_paymaster 
     GROUP BY AREA, Outlet) AS lap_final
ON reg_sale.Outlet = lap_final.Outlet
LEFT JOIN
(SELECT Outlet,
SUM(CASE WHEN TrnType = 'CO' 
         AND ChargeCode = 'DOWN PAYMENT'
         THEN Amount 
         ELSE 0 
         END) AS co_dp
         FROM tbl_paymaster 
     GROUP BY AREA, Outlet) AS co_down
ON reg_sale.Outlet = co_down.Outlet
LEFT JOIN
(SELECT Outlet,
SUM(CASE WHEN TrnType = 'CO' 
         AND ChargeCode = 'FOLLOW UP PAYMENT'
         THEN Amount 
         ELSE 0 
         END) AS co_fup
         FROM tbl_paymaster 
     GROUP BY AREA, Outlet) AS co_follow
ON reg_sale.Outlet = co_follow.Outlet
LEFT JOIN
(SELECT Outlet,
SUM(CASE WHEN TrnType = 'CO' 
         AND ChargeCode = 'FINAL PAYMENT'
         THEN Amount 
         ELSE 0 
         END) AS co_fp
         FROM tbl_paymaster 
     GROUP BY AREA, Outlet) AS co_final
ON reg_sale.Outlet = co_final.Outlet
LEFT JOIN
(SELECT Outlet,
SUM(CASE WHEN ItemClass = 'PLAT'
         THEN Amount 
         ELSE 0 
         END) AS plat
         FROM tbl_paymaster 
     GROUP BY AREA, Outlet) AS platero
ON reg_sale.Outlet = platero.Outlet
LEFT JOIN
(SELECT Outlet,
SUM(CASE WHEN PayType = 'REFUND'
         THEN Amount 
         ELSE 0 
         END) AS rfund
         FROM tbl_paymaster 
     GROUP BY AREA, Outlet) AS refund
ON reg_sale.Outlet = refund.Outlet
LEFT JOIN
(SELECT * FROM tbl_pi_list ORDER BY pi_id DESC LIMIT 1) AS list_pi
    ON MONTH(reg_sale.`TrnDate`) = RIGHT(list_pi.`pi_year_month`,2)
LEFT JOIN
(SELECT ccard_date,ccard_outlet,SUM(ccard_amount) AS fees FROM tbl_ccard 
INNER JOIN tbl_pi_list 
WHERE MONTH(tbl_ccard.ccard_date) = RIGHT(tbl_pi_list.`pi_year_month`,2) 
GROUP BY ccard_outlet) AS ccard
ON ccard.ccard_outlet = reg_sale.Outlet
-- and month(ccard.ccard_date) = RIGHT(list_pi.`pi_year_month`,2)
    GROUP BY reg_sale.Outlet, reg_sale.Area 
    ORDER BY reg_sale.Area DESC";

$stmt = Database::getConnection('pi')->query($sql);

if ($stmt) {
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $ds = [];
    foreach ($data as $v) {
        // $v['reg_sale'] = number_format($v['reg_sale']);
        $v['sales'] = number_format($v['sales'],2);
        $v['lap_dp'] = number_format($v['lap_dp'],2);
        $v['lap_fup'] = number_format($v['lap_fup'],2);
        $v['lap_fp'] = number_format($v['lap_fp'],2);
        $v['co_dp'] = number_format($v['co_dp'],2);
        $v['co_fup'] = number_format($v['co_fup'],2);
        $v['co_fp'] = number_format($v['co_fp'],2);
        $v['plat'] = number_format($v['plat'],2);
        $v['rfund'] = number_format($v['rfund'],2);
        $v['fees'] = number_format($v['fees'],2);
        $ds[ $v['Area'] ][] = $v;
    }

    $ds2 = [];
    $ds2['others']['cnt'] = 0;

    foreach ($ds as $k => $v) {
        if(count($v) == 1){
            $ds2['others']['item'] = array_merge($ds2['others']['item'] ?? [], $v);
        }else{
            $ds2[$k]['item'] = $v;
            $ds2[$k]['cnt'] = count($ds2[$k]['item']);
        }
    }

    uasort($ds2, function($a, $b){
        return ($a['cnt'] <=> $b['cnt']) * -1;
    });
    
    if ($data) {
        // echo json_encode(array_map(function($r){
        //     $r['reg_sale'] = number_format($r['reg_sale']);
        //     return $r;
        // }, $data));

        echo json_encode($ds2);
    } else {
        echo "No data found";
    }
} else {
    echo "Query failed: " . Database::getConnection('pi')->errorInfo()[2];
}

?>
