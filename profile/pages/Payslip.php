<?php
		if(isset($_POST['get_payslip']) && isset($_POST['ps']) && $_POST['get_payslip']!='' && $_POST['ps']!=''){
			include '../db/database.php';
			require"../db/core.php";
			include('../db/mysqlhelper.php');
			$hr_pdo = HRDatabase::connect();
			$dtr_pdo = DTRDatabase::connect();

			$empno=$_POST['get_payslip'];
			$id=$_POST['ps'];

			$monthly_pay="";
			$basic_pay="";
			$daily_rate="";
			$hourly_rate="";
			$honorarium_allowance="";
			$retro="";
			$total_pay="";
			$absent="";
			$absent_rate="";
			$absent_val="";
			$late="";
			$late_rate="";
			$late_val="";
			$undertime="";
			$undertime_rate="";
			$undertime_val="";
			$net="";
			$overtime="";
			$overtime_rate="";
			$overtime_val="";
			$special_holiday="";
			$special_holiday_rate="";
			$special_holiday_val="";
			$legal_holiday="";
			$legal_holiday_rate="";
			$legal_holiday_val="";
			$total_overtime_pay="";
			$gross_pay="";
			$sss="";
			$phic="";
			$hdmf="";
			$wtax="";
			$hdmf_loan_cal="";
			$hdmf_loan_mpl="";
			$sss_loan="";
			$philam="";
			$advances="";
			$sophia_loan="";
			$laptop_phone_loan="";
			$ipad="";
			$phone_bills="";
			$other_deduction="";
			$proware="";
			$canteen="";
			$chowking="";
			$total_deduction="";
			$net_pay="";
			$prepared_by="";
			$dept="";
			$payout="";

			$psid="";
			$deduc_tr="";
			// $sql="SELECT * FROM tbl201_payslip WHERE ps_empno='$empno' AND ps_fromdate='$dt_from' AND ps_todate='$dt_to'";
			$sql="SELECT * FROM tbl201_payslip WHERE ps_empno='$empno' AND ps_payoutdt='$id'";
			$tblcnt=1;
			foreach ($hr_pdo->query($sql) as $ps) {
				$bi_empno=$empno;
			 	$words = preg_split("/[\s,_.]+/", get_emp_info('bi_empmname',$bi_empno));
			    $acronym = "";
			    foreach ($words as $w) {
			      $acronym .= strtoupper($w[0]).".";
			    }
				$bi_empname=ucwords(trim(get_emp_info('bi_emplname',$bi_empno)." ".get_emp_info('bi_empext',$bi_empno)).", ".get_emp_info('bi_empfname',$bi_empno))." ".$acronym;

				$psid=$ps['ps_id'];

				$monthly_pay=$ps['ps_monthlypay'];
				$basic_pay=$ps['ps_basicpay'];
				$daily_rate=$ps['ps_dailyrate'];
				$hourly_rate=$ps['ps_hourlyrate'];
				$honorarium_allowance=$ps['ps_honorarium'];
				$retro=$ps['ps_retro'];
				$total_pay=$ps['ps_totalpay'];
				$absent=$ps['ps_absent'];
				if($absent>0){
					$absent_rate=$ps['ps_absentrate'];
				}
				$absent_val=$ps['ps_absentval'];
				$late=$ps['ps_late'];
				if($late>0){
					$late_rate=$ps['ps_laterate'];
				}
				$late_val=$ps['ps_lateval'];
				$undertime=$ps['ps_undertime'];
				if($undertime>0){
					$undertime_rate=$ps['ps_undertimerate'];
				}
				$undertime_val=$ps['ps_undertimeval'];
				$net=$ps['ps_net'];
				$overtime=$ps['ps_overtime'];
				if($overtime>0){
					$overtime_rate=$ps['ps_overtimerate'];
				}
				$overtime_val=$ps['ps_overtimeval'];
				$special_holiday=$ps['ps_specialh'];
				if($special_holiday>0){
					$special_holiday_rate=$ps['ps_specialhrate'];
				}
				$special_holiday_val=$ps['ps_specialhval'];
				$legal_holiday=$ps['ps_legalh'];
				if($legal_holiday>0){
					$legal_holiday_rate=$ps['ps_legalhrate'];
				}
				$legal_holiday_val=$ps['ps_legalhval'];
				$total_overtime_pay=$ps['ps_totalovertimepay'];
				$gross_pay=$ps['ps_gpbeforededuct'];
				$sss=$ps['ps_sss'];
				$phic=$ps['ps_phic'];
				$hdmf=$ps['ps_hdmf'];
				$wtax=$ps['ps_wtax'];
				$hdmf_loan_cal=$ps['ps_hdmfloancal'];
				$hdmf_loan_mpl=$ps['ps_hdmfloanmpl'];
				$sss_loan=$ps['ps_sssloan'];
				$philam=$ps['ps_philam'];
				$advances=$ps['ps_advances'];
				$sophia_loan=$ps['ps_sophialoan'];
				$laptop_phone_loan=$ps['ps_laptopphoneloan'];
				$ipad=$ps['ps_ipad'];
				$phone_bills=$ps['ps_phonebills'];
				$other_deduction=$ps['ps_otherdeduct'];
				$proware=$ps['ps_proware'];
				$canteen=$ps['ps_canteen'];
				$chowking=$ps['ps_chowking'];
				$total_deduction=$ps['ps_totaldeduct'];
				$net_pay=$ps['ps_netpay'];


				$trate=$ps['ps_trate'];
				$tlate=$ps['ps_tlate'];
				$tlaterate=$ps['ps_tlaterate'];
				$tlateval=$ps['ps_tlateval'];
				$tundertime=$ps['ps_tundertime'];
				$tundertimerate=$ps['ps_tundertimerate'];
				$tundertimeval=$ps['ps_tundertimeval'];

				$words = preg_split("/[\s,_.]+/", get_emp_info('bi_empmname',$ps['ps_preparedby']));
			    $acronym = "";
			    foreach ($words as $w) {
			      $acronym .= strtoupper($w[0]).".";
			    }
				$prepared_by=ucwords(trim(get_emp_info('bi_empfname',$ps['ps_preparedby'])." ".$acronym." ".get_emp_info('bi_emplname',$ps['ps_preparedby']))." ".get_emp_info('bi_empext',$ps['ps_preparedby']));
				$dept=$ps['ps_dept'];
				$payout=date("F d, Y",strtotime($ps['ps_fromdate']))." - ".date("F d, Y",strtotime($ps['ps_todate']));

				$deduc_tr="";
				$sql_deduction="SELECT * FROM tbl_deductions";
				foreach ($hr_pdo->query($sql_deduction) as $deduct1) {
					$deduc_tr_val=0;
					$sql_deduction1="SELECT * FROM tbl201_payslipdeduction WHERE pdeduct_code='".$deduct1['deduc_code']."' AND pdeduct_psid=".$psid;
					foreach ($hr_pdo->query($sql_deduction1) as $deduct2) {
						$deduc_tr_val+=$deduct2['pdeduct_amount'];
					}
					$deduc_tr.='<tr>'
								.'<td class="tblrow">'.$deduct1['deduc_name'].'</td>'
								.'<td class="tblnum" ><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="'.$deduct1['deduc_code'].'" value="'.round($deduc_tr_val,2).'" width="100%"></td>'
						      .'</tr>';
				}

				?>
				<?php if($tblcnt>1){ echo "<hr>"; } ?>
				<div id="tblps-<?=$tblcnt?>" class="tblpsparent">
					<table class="tbl-payslip" width="100%" cellspacing="0">
						<tbody>
							<tr class="tr1">
								<td class="tblheader" align="right">Period:</td>
								<td class="tblheader1" align="left"  name="ps_fromto"><?=$payout?></td>
								<td class="tblheader" align="right">Payout Date:</td>
								<td class="tblheader1" align="right" name="payoutdt"><?=$id?></td>
							</tr>
							<tr>
								<td class="tblblank" colspan="5"></td>
							</tr>
							<tr class="tr1">
								<td class="tblheader" align="right">Employee No.</td>
								<td class="tblheader1" align="left" ><?=$bi_empno?></td>
								<td class="tblheader" align="right">Department:</td>
								<td class="tblheader1" align="right" name="dept"><?=$dept?></td>
							</tr>
							<tr class="tr1">
								<td class="tblheader" align="right">Employee Name:</td>
								<td class="tblheader1" align="left" ><?=$bi_empname?></td>
								<td class="tblheader" align="right">Monthly Compensation:</td>
								<td class="tblheader1" align="right"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="monthly_pay" width="100%" value="<?=$monthly_pay?>" disabled></td>
							</tr>
						</tbody>
					</table>
					<br>
					<div style="display: inline-grid; width: 60%;">
						<table class="tbl-payslip" width="100%">
							<tbody>
								<tr>
									<td class="tblheader" align="center" colspan="5">COMPENSATION</td>
								</tr>
								<tr>
									<td class="tblrow fontbold" width="30%">BASIC PAY</td>
									<td class="tblnum" width="15%"></td>
									<td class="tblnum" width="5%"></td>
									<td class="tblnum" width="25%"></td>
									<td class="tblnum fontbold" width="25%"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="basic_pay" width="100%" value="<?=$basic_pay?>" disabled></td>
								</tr>
								<tr>
									<td class="tblrow">DAILY RATE</td>
									<td class="tblnum"></td>
									<td class="tblnum"></td>
									<td class="tblnum"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="daily_rate" width="100%" value="<?=$daily_rate?>" disabled></td>
									<td class="tblnum"></td>
								</tr>
								<tr>
									<td class="tblrow">TEACHING RATE</td>
									<td class="tblnum"></td>
									<td class="tblnum"></td>
									<td class="tblnum"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="teaching_rate" width="100%" value="<?=$trate?>" disabled></td>
									<td class="tblnum"></td>
								</tr>
								<tr>
									<td class="tblrow">Honorarium/Allowance</td>
									<td class="tblnum"></td>
									<td class="tblnum"></td>
									<td class="tblnum"></td>
									<td class="tblnum"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="honorarium_allowance" width="100%" value="<?=$honorarium_allowance?>" disabled></td>
								</tr>
								<tr>
									<td class="tblrow">RETRO</td>
									<td class="tblnum"></td>
									<td class="tblnum"></td>
									<td class="tblnum"></td>
									<td class="tblnum"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="retro" value="<?=$retro?>" width="100%"></td>
								</tr>
								<tr>
									<td class="tblrow fontbold">TOTAL PAY</td>
									<td class="tblnum"></td>
									<td class="tblnum"></td>
									<td class="tblnum"></td>
									<td class="tblnum fontbold"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="total_pay" value="<?=$total_pay?>" width="100%" disabled></td>
								</tr>
								<tr>
									<td class="tblblank" colspan="5"></td>
								</tr>
							</tbody>
						</table>
						<!-- <br> -->
						<table class="tbl-payslip" width="100%">
							<tbody>
								<tr>
									<td class="tblheader" align="center" colspan="5">LESS TARDINESS/ABSENCES</td>
								</tr>
								<tr>
									<td class="tblrow" width="30%">ABSENT(day)</td>
									<td class="tblnum" width="15%"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="absent" value="<?=$absent?>" width="100%"></td>
									<td class="tblnum" style="text-align: center;" width="5%">@</td>
									<td class="tblnum" width="25%"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="absent_rate" value="<?=$absent_rate?>" width="100%"></td>
									<td class="tblnum" width="25%"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="absent_val" value="<?=$absent_val?>" width="100%"></td>
								</tr>
								<tr>
									<td class="tblrow">LATE(min)</td>
									<td class="tblnum"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="late" value="<?=$late?>" width="100%"></td>
									<td class="tblnum" style="text-align: center;">@</td>
									<td class="tblnum"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="late_rate" value="<?=$late_rate?>" width="100%"></td>
									<td class="tblnum"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="late_val" value="<?=$late_val?>" width="100%"></td>
								</tr>
								<tr>
									<td class="tblrow">TEACHING LATE(min)</td>
									<td class="tblnum"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="tlate" value="<?=$tlate?>" width="100%"></td>
									<td class="tblnum" style="text-align: center;">@</td>
									<td class="tblnum"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="tlate_rate" value="<?=$tlaterate?>" width="100%"></td>
									<td class="tblnum"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="tlate_val" value="<?=$tlateval?>" width="100%"></td>
								</tr>
								<tr>
									<td class="tblrow">UNDERTIME(hr)</td>
									<td class="tblnum"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="undertime" value="<?=$undertime?>" width="100%"></td>
									<td class="tblnum" style="text-align: center;">@</td>
									<td class="tblnum"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="undertime_rate" value="<?=$undertime_rate?>" width="100%"></td>
									<td class="tblnum"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="undertime_val" value="<?=$undertime_val?>" width="100%"></td>
								</tr>
								<tr>
									<td class="tblrow">TEACHING UNDERTIME(hr)</td>
									<td class="tblnum"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="tundertime" value="<?=$tundertime?>" width="100%"></td>
									<td class="tblnum" style="text-align: center;">@</td>
									<td class="tblnum"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="tundertime_rate" value="<?=$tundertimerate?>" width="100%"></td>
									<td class="tblnum"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="tundertime_val" value="<?=$tundertimeval?>" width="100%"></td>
								</tr>
								<tr>
									<td class="tblrow fontbold">NET</td>
									<td class="tblnum"></td>
									<td class="tblnum"></td>
									<td class="tblnum"></td>
									<td class="tblnum fontbold"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="net" value="<?=$net?>" width="100%"></td>
								</tr>
								<tr>
									<td class="tblblank" colspan="5"></td>
								</tr>
							</tbody>
						</table>
						<!-- <br> -->
						<table class="tbl-payslip" width="100%">
							<tbody>
								<tr>
									<td class="tblheader" align="center" colspan="5">ADD OVERTIME</td>
								</tr>
								<tr>
									<td class="tblrow" width="30%">Overtime(Regular)(hr)</td>
									<td class="tblnum" width="15%"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="overtime" value="<?=$overtime?>" width="100%"></td>
									<td class="tblnum" style="text-align: center;" width="5%">@</td>
									<td class="tblnum" width="25%"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="overtime_rate" value="<?=$overtime_rate?>" width="100%"></td>
									<td class="tblnum" width="25%"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="overtime_val" value="<?=$overtime_val?>" width="100%"></td>
								</tr>
								<tr>
									<td class="tblrow">Special Holiday(hr)</td>
									<td class="tblnum"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="special_holiday" value="<?=$special_holiday?>" width="100%"></td>
									<td class="tblnum" style="text-align: center;">@</td>
									<td class="tblnum"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="special_holiday_rate" value="<?=$special_holiday_rate?>" width="100%"></td>
									<td class="tblnum"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="special_holiday_val" value="<?=$special_holiday_val?>" width="100%"></td>
								</tr>
								<tr>
									<td class="tblrow">Legal Holiday(hr)</td>
									<td class="tblnum"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="legal_holiday" value="<?=$legal_holiday?>" width="100%"></td>
									<td class="tblnum" style="text-align: center;">@</td>
									<td class="tblnum"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="legal_holiday_rate" value="<?=$legal_holiday_rate?>" width="100%"></td>
									<td class="tblnum"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="legal_holiday_val" value="<?=$legal_holiday_val?>" width="100%"></td>
								</tr>
								<tr>
									<td class="tblrow">Total Overtime Pay</td>
									<td class="tblnum"></td>
									<td class="tblnum"></td>
									<td class="tblnum"></td>
									<td class="tblnum"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="total_overtime_pay" value="<?=$total_overtime_pay?>" width="100%"></td>
								</tr>
								<tr>
									<td class="tblrow fontbold" rowspan="2" >GROSS PAY BEFORE ALLOWABLE DEDUCTIONS</td>
									<td class="tblnum fontbold" rowspan="2" colspan="4"><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="gross_pay" value="<?=$gross_pay?>" width="100%"></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div style="display: inline-grid; width: 39%;">
						<table class="tbl-payslip" width="100%">
							<tbody>
								<tr>
									<td class="tblheader" align="center" colspan="2">ALLOWABLE DEDUCTIONS</td>
								</tr>
								<tr>
									<td class="tblrow">SSS</td>
									<td class="tblnum" ><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="sss" value="<?=$sss?>" width="100%"></td>
								</tr>
								<tr>
									<td class="tblrow">PHIC</td>
									<td class="tblnum" ><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="phic" value="<?=$phic?>" width="100%"></td>
								</tr>
								<tr>
									<td class="tblrow">HDMF</td>
									<td class="tblnum" ><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="hdmf" value="<?=$hdmf?>" width="100%"></td>
								</tr>
								<tr>
									<td class="tblrow">W/TAX</td>
									<td class="tblnum" ><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="wtax" value="<?=$wtax?>" width="100%"></td>
								</tr>
								<!-- <tr>
									<td class="tblrow">HDMF LOAN-CAL</td>
									<td class="tblnum" ><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." id="hdmf_loan_cal" width="100%"></td>
								</tr>
								<tr>
									<td class="tblrow">HDMF LOAN-MPL</td>
									<td class="tblnum" ><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." id="hdmf_loan_mpl" width="100%"></td>
								</tr>
								<tr>
									<td class="tblrow">SSS LOAN</td>
									<td class="tblrow" ><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." id="sss_loan" width="100%"></td>
								</tr> -->
								<?php echo $deduc_tr;//foreach ($hr_pdo->query("SELECT * FROM tbl_deductions") as $deduct) { ?>
										<!-- <tr>
											<td class="tblrow"><?php//$deduct['deduc_name']?></td>
											<td class="tblnum" ><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." id="<?php//$deduct['deduc_code']?>" width="100%"></td>
										</tr> -->
								<?php //} ?>
								<tr>
									<td class="tblrow">TOTAL DEDUCTION</td>
									<td class="tblnum" ><input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="total_deduction" value="<?=$total_deduction?>" width="100%"></td>
								</tr>
								<tr>
									<td class="tblrow fontbold">NET PAY</td>
									<td class="tblnum fontbold" >
										<input type="text" data-placement="right" data-trigger="focus" rel="popover" data-content="Press enter when your done." name="net_pay" value="<?=$net_pay?>" width="100%">
										<input type="text" name="ps_id" value="<?=$psid?>" hidden>
									</td>
								</tr>
								
							</tbody>
						</table>
					</div>
					<br>
				</div>
				<?php
				$tblcnt++;
			}
			?>
			<div style="display: block; width: 100%;">
				<br>
				<table class="tbl-payslip" width="100%">
					<tbody>
						<tr>
							<td class="tblheader" align="right" width="16.7%">Prepared by: </td>
							<td class="tblheader" align="left" id="prepared_by" width="35%"><?=$prepared_by?></td>
							<td class="tblheader" align="right" width="20%">Deposited to your account: </td>
							<td class="tblheader" align="left" width="20%"></td>
						</tr>
					</tbody>
				</table>
			</div>
			<?php

			// $arr_data[]=array("monthly_pay",(round($monthly_pay,2)));
			// $arr_data[]=array("basic_pay",(round($basic_pay,2)));
			// $arr_data[]=array("daily_rate",(round($daily_rate,2)));
			// $arr_data[]=array("hourly_rate",(round($hourly_rate,2)));
			// $arr_data[]=array("honorarium_allowance",(round($honorarium_allowance,2)));
			// $arr_data[]=array("retro",(round($retro,2)));
			// $arr_data[]=array("total_pay",(round($total_pay,2)));

			// $arr_data[]=array("absent",(round($absent,2)));
			// $arr_data[]=array("absent_rate",(round($absent_rate,2)));
			// $arr_data[]=array("absent_val",(round($absent_val,2)));
			// $arr_data[]=array("late",(round($late,2)));
			// $arr_data[]=array("late_rate",(round($late_rate,2)));
			// $arr_data[]=array("late_val",(round($late_val,2)));
			// $arr_data[]=array("undertime",(round($undertime,2)));
			// $arr_data[]=array("undertime_rate",(round($undertime_rate,2)));
			// $arr_data[]=array("undertime_val",(round($undertime_val,2)));
			// $arr_data[]=array("net",(round($net,2)));

			// $arr_data[]=array("overtime",(round($overtime,2)));
			// $arr_data[]=array("overtime_rate",(round($overtime_rate,2)));
			// $arr_data[]=array("overtime_val",(round($overtime_val,2)));
			// $arr_data[]=array("special_holiday",(round($special_holiday,2)));
			// $arr_data[]=array("special_holiday_rate",(round($special_holiday_rate,2)));
			// $arr_data[]=array("special_holiday_val",(round($special_holiday_val,2)));
			// $arr_data[]=array("legal_holiday",(round($legal_holiday,2)));
			// $arr_data[]=array("legal_holiday_rate",(round($legal_holiday_rate,2)));
			// $arr_data[]=array("legal_holiday_val",(round($legal_holiday_val,2)));
			// $arr_data[]=array("total_overtime_pay",(round($total_overtime_pay,2)));
			// $arr_data[]=array("gross_pay",(round($gross_pay,2)));

			// $arr_data[]=array("sss",(round($sss,2)));
			// $arr_data[]=array("phic",(round($phic,2)));
			// $arr_data[]=array("hdmf",(round($hdmf,2)));
			// $arr_data[]=array("wtax",(round($wtax,2)));

			// // $arr_data[]=array("hdmf_loan_cal",(round($hdmf_loan_cal,2)));
			// // $arr_data[]=array("hdmf_loan_mpl",(round($hdmf_loan_mpl,2)));
			// // $arr_data[]=array("sss_loan",(round($sss_loan,2)));
			// // $arr_data[]=array("philam",round($philam,2));
			// // $arr_data[]=array("advances",round($advances,2));
			// // $arr_data[]=array("sophia_loan",round($sophia_loan,2));
			// // $arr_data[]=array("laptop_phone_loan",round($laptop_phone_loan,2));
			// // $arr_data[]=array("ipad",round($ipad,2));
			// // $arr_data[]=array("phone_bills",round($phone_bills,2));
			// // $arr_data[]=array("other_deduction",round($other_deduction,2));
			// // $arr_data[]=array("proware",round($proware,2));
			// // $arr_data[]=array("canteen",round($canteen,2));
			// // $arr_data[]=array("chowking",round($chowking,2));
			
			// $sql_deduction="SELECT * FROM tbl201_payslipdeduction JOIN tbl_deductions ON deduc_code=pdeduct_code WHERE pdeduct_psid=".$psid;
			// foreach ($hr_pdo->query($sql_deduction) as $deduct1) {
			// 	$arr_data[]=array($deduct1["pdeduct_code"],(round($deduct1["pdeduct_amount"],2)));
			// }

			// $arr_data[]=array("total_deduction",(round($total_deduction,2)));
			// $arr_data[]=array("net_pay",(round($net_pay,2)));
			// $arr_data[]=array("prepared_by",$prepared_by);
			// $arr_data[]=array("dept",$dept);
			// $arr_data[]=array("ps_fromto",$payout);

			// // echo json_encode($arr_data);
	
		}else{ ?>
			<?php
					$bi_empno="";
					$bi_empname="";
					if(isset($_GET['id']) && $_GET['id']!=''){
						$bi_empno=$_GET['id'];
					 	$words = preg_split("/[\s,_.]+/", get_emp_info('bi_empmname',$bi_empno));
					    $acronym = "";
					    foreach ($words as $w) {
					      $acronym .= strtoupper($w[0]).".";
					    }
						$bi_empname=ucwords(trim(get_emp_info('bi_emplname',$bi_empno)." ".get_emp_info('bi_empext',$bi_empno)).", ".get_emp_info('bi_empfname',$bi_empno))." ".$acronym;
					}
			?>
			<!-- <script type="text/javascript" src="../html2canvas/html2canvas.min.js"></script> -->
			<style type="text/css">
				.tblheader{
					background-color: black;
					color: white;
					border: lightgrey solid .1px;
					font-weight: bold;
					padding: 3px;
					font-size: 11px;
				}
				.tblheader1{
					background-color: yellow;
					border: lightgrey solid .1px;
					font-weight: bold;
					padding: 3px;
					font-size: 11px;
				}
				.tblblank{
					border: none;
					height: 20px;
				}
				.tblrow{
					background-color: lightyellow;
					text-align: right;
					border: lightgrey solid .1px;
					padding: 3px;
					font-size: 11px;
				}
				.tblnum{
					background-color: lightyellow;
					text-align: right;
					vertical-align: bottom;
					border: lightgrey solid .1px;
					padding: 3px;
					font-size: 11px;
				}
				.fontbold{
					font-weight: bold;
					font-size: 11px;
				}
				input[type=text]{
					background-color: transparent;
					border: none;
					text-align: right;
					width: 100%;
					height: 100%;
					font-size: 11px;
					/*padding: 0px;*/
				}
				.tr1{
					border: grey solid 3px;
				}
			</style>
			<div class="container-fluid">
				<div class="panel panel-default">
					<div class="panel-body">
						<div style="display: inline-flex;margin-right: 5px;">
							<label style="<?php if($user_empno!="045-2017-068"){ echo "display:none;"; } ?>">Select Employee: </label>
							<select id="ps_empno" onchange="location = this.value;" class="<?=($user_empno!="045-2017-068" ? "" : "selectpicker" )?>" data-live-search="true" style="<?php if($user_empno!="045-2017-068"){ echo "display:none;"; } ?>">
								<option disabled selected>-SELECT-</option>
								<?php $sqlemplist="SELECT bi_empno,bi_empfname,bi_emplname,bi_empext FROM tbl201_basicinfo WHERE datastat='current' order by bi_empfname asc";
										foreach ($hr_pdo->query($sqlemplist) as $elist) { ?>
										 	<option <?php if(isset($_GET['id']) && $_GET['id']==$elist['bi_empno']){ echo "selected"; } ?> value="?page=payslip&id1=<?=getToken(50).getToken(50)?>&id=<?=$elist['bi_empno'];?>&id2=<?=getToken(50)?>"><?=$elist['bi_empfname']." ".$elist['bi_emplname']." ".$elist['bi_empext']?></option>
								<?php	} ?>
							</select>
						</div>
						<div style="display: inline-flex;">
							<label>Payout date: </label>
							<select id="ps_dt" class="selectpicker" data-live-search="true" title="Select">
								<!-- <option disabled value selected>-Select-</option> -->
								<?php $sql_ps="SELECT ps_id,ps_payoutdt FROM tbl201_payslip WHERE ps_empno='$bi_empno' group by ps_payoutdt order by ps_fromdate DESC";
										foreach ($hr_pdo->query($sql_ps) as $ps_key) { ?>
										 	<option value="<?=$ps_key['ps_payoutdt']?>"><?=date("F d, Y",strtotime($ps_key['ps_payoutdt']))?></option>
								<?php	} ?>
							</select>
						</div>
						<div><button onclick="get_payslip()" class="btn btn-default">Generate</button></div>
					</div>
					<div class="panel-body">
						<div align="right" style="<?=($user_empno!="045-2017-068" ? "display:none;" : "" )?>">
							<!-- <button class="btn btn-success" id="btn-editps"><i class="fa fa-edit"></i> Edit</button> -->
							<!-- <button class="btn btn-primary" id="btn-saveps" style="display: none;">Save</button> -->
							<!-- <button class="btn btn-danger" id="btn-cancelps" style="display: none;">Cancel</button> -->
						</div>
						<fieldset disabled id="psfield">
							<input type="hidden" id="psid">
							<div class="container-fluid" style="width: 1000px;" id="printthis">
								<style type="text/css">
									@media print{
										/*body{
											margin-left: 50px;
											margin-right: 50px;
										}*/
										table{
											border-collapse: collapse;
										}
										td{
											color: black;
											margin: 0px;
											font-family: "Calibri";
											font-size: 11px;
										}
										.tblheader{
											/*background-color: black;*/
											/*color: white;*/
											border: black solid .1px;
											font-weight: bold;
											padding: 3px;
										}
										.tblheader1{
											/*background-color: yellow;*/
											border: black solid .1px;
											font-weight: bold;
											padding: 3px;
										}
										.tblblank{
											border: none;
											height: 20px;
										}
										.tblrow{
											/*background-color: lightyellow;*/
											text-align: right;
											border: black solid .1px;
											padding: 3px;
										}
										.tblnum{
											/*background-color: lightyellow;*/
											text-align: right;
											vertical-align: bottom;
											border: black solid .1px;
											padding: 3px;
										}
										.fontbold{
											font-weight: bold;
										}
										input[type=text]{
											background-color: transparent;
											border: none;
											text-align: right;
											width: 100%;
											height: 100%;
											font-size: 11px;
											/*padding: 0px;*/
										}
										.tr1{
											/*border: black solid 3px;*/
										}
										input[type="text"]:disabled {
										    color: black;
										}

									}
								</style>
								<span id="alert"></span>
								<center><b style="font-family: Calibri">SUNGOLD TECHNOLOGIES, INC.</b></center>
								<center style="font-family: Calibri">Unicon Building, Gov. Lim Ave., Zamboanga City</center>
								<center><b style="font-family: Calibri">PAYSLIP</b></center>
								<br>
								<div id="disp-ps"></div>
							</div>
						</fieldset>
						<span class="pull-right" style="position: sticky; bottom: 20px;"><button onclick="print_ps()" class="btn btn-default btn-lg"><i class="fa fa-print"></i></button></span>
					</div>
				</div>
			</div>
			<iframe src="" id="printpdf" width="100%" hidden></iframe>
			<script type="text/javascript">
				$(function(){

					$("#btn-editps").on("click",function(){
						$(this).css("display","none");
						$("#btn-saveps").css("display","");
						$("#btn-cancelps").css("display","");
						$("#psfield").attr("disabled",false);
					});
					$("#btn-cancelps").on("click",function(){
						$(this).css("display","none");
						$("#btn-saveps").css("display","none");
						$("#btn-editps").css("display","");
						$("#psfield").attr("disabled",true);
						get_payslip();
					});
					$("#btn-saveps").on("click",function(){
						// var arrps=new Array();
						// $(".tbl-payslip input[type='text']").each(function(){
						// 	arrps.push(numnull($(this).val()));
						// });
						// $.post("../actions/save-payslip.php",{ action: "edit", ps: $("#psid").val(), employee: "<?=$bi_empno?>", payslip: arrps, _t:"<?php //$_SESSION['csrf_token1']?>"},function(data){
						// 	if(data=="1"){
						// 		alert("Successfully updated!");
						// 	}else{
						// 		alert(data);
						// 	}
						// });
						save_ps();
					});
					
				});
				function save_ps(){
					var arrpsset=new Array();
					$(".tblpsparent").each(function(){
						var arrps=new Array();
						$(this).find(".tbl-payslip input[type='text']").each(function(){
							arrps.push($(this).attr("name")+"@"+numnull($(this).val()));
						});
						arrpsset.push(arrps.join("|"));
					});
					$.post("../actions/save-payslip.php",{ action: "edit", ps: $("#psid").val(), employee: "<?=$bi_empno?>", payslip: arrpsset, _t:"<?=$_SESSION['csrf_token1']?>"},function(data){
						if(data=="1"){
							alert("Successfully updated!");
						}else{
							alert(data);
						}
						$("#btn-editps").css("display","");
						$("#btn-saveps").css("display","none");
						$("#btn-cancelps").css("display","none");
						$("#psfield").attr("disabled",true);
						get_payslip();
					});
				}
				function roundNumber(num, scale) {
			      	if(!("" + num).includes("e")){
			         	return +(Math.round(num + "e+" + scale)  + "e-" + scale);
			      	}else{
			         	var arr = ("" + num).split("e");
			         	var sig = "";
			         	if(+arr[1] + scale > 0) {
			            	sig = "+";
			         	}
			         	return +(Math.round(+arr[0] + "e" + sig + (+arr[1] + scale)) + "e-" + scale);
			      	}
			  	}
				function print_ps(){
					$(".tbl-payslip input").each(function(){
						$(this).attr("value",$(this).val());
					});
					$("#printpdf").attr("srcdoc","<div style=''>"+$("#printthis").html()+"</div><script>window.print();<\/script>");
					// html2canvas(document.querySelector("#printthis")).then(canvas => {
					// 	var img="<img src='"+canvas.toDataURL("image/jpeg")+"' width='700px'>";
				 //        $("#printpdf").attr("srcdoc","<div style=''>"+img+"</div><script>window.print();<\/script>");
					// });
				}

				function currencyformat(num1){
					num1=roundNumber(numnull(num1),2);
					var neg="";
					if (num1.toString().indexOf('-') == 0) {
					   neg="-";
					}
					var arrnum=num1.toString().replace(/[-]/g,"").split(".");
					var arrnum2=[];
					for (var i = arrnum[0].length; i > 0; i-=3) {
						// arrnum2.push(arrnum[0][i]);
						// if((i-arrnum[0].length)%3==0){
						// 	arrnum2
						// }
						arrnum2.push(arrnum[0].substring(Math.max(0,i-3),i));
					}
					arrnum[0]=arrnum2.reverse().join(',');
					var output=neg+arrnum.join('.');
					if(output=="0"){
						output="";
					}
					return output;
				}

				function get_payslip(){
					$(".tbl-payslip input").each(function(){
						$(this).attr("value",0);
						$(this).val("");
					});
					if($("#ps_dt").val()){
						$("#psid").val($("#ps_dt").val());
						$("#payoutdt").text($("#ps_dt option:selected").text());
						// var ps_date=$("#ps_dt").val().split(",");
						$.post("payslip.php",{ get_payslip: "<?=$bi_empno?>", ps: $("#ps_dt").val(), _t:"<?=$_SESSION['csrf_token1']?>" },function(pdata){
							// var mydata1=JSON.parse(pdata);
							// for(x in mydata1){
							// 	if(!(mydata1[x][0]=="prepared_by" || mydata1[x][0]=="dept" || mydata1[x][0]=="ps_fromto")){
							// 		if(mydata1[x][1]!=0){
							// 			$("#"+mydata1[x][0]).val(currencyformat(mydata1[x][1]));
							// 			// $("#"+mydata1[x][0]).attr("value",mydata1[x][1]);
							// 		}
							// 	}else{
							// 		$("#"+mydata1[x][0]).text(mydata1[x][1]);
							// 		// alert(mydata1[x][1]);
							// 	}
							// }
							$("#disp-ps").html(pdata);
							$('[data-trigger=focus]').popover();
							$(".tbl-payslip input[type='text']").off("keypress");
							$(".tbl-payslip input[type='text']").on("keypress",function(e){
								txt1=$(this);
								// var ex = /^[0-9]+\.?[0-9]*$/;
							 	// if(ex.test(txt1.val())==false){
								 //   txt1.val(txt1.val().replace(/[^0-9.-]/g, '').replace(/(\..*)\./g, '$1').replace(/(?!^)-/g, ''));
							  // 	}
								if(e.which == 13) {
									$(this).blur();
							        // _decimal($(this));
							    }
							});
							$(".tbl-payslip input[type='text']").on("blur",function(e){
								// $(this).val($(this).val().replace(",",""));
								txt1=$(this);
								var ex = /^[0-9]+\.?[0-9]*$/;
								// var ex =/^\$?([0-9]{1,3},([0-9]{3},)*[0-9]{3}|[0-9]+)(.[0-9][0-9])?$/;
							 	if(ex.test(txt1.val())==false){
								   txt1.val(txt1.val().replace(/[^0-9.-]/g, '').replace(/(\..*)\./g, '$1').replace(/(?!^)-/g, ''));
							  	}
							  	txt1.val(currencyformat(txt1.val()));

								// console.log(currencyformat(txt1.val()));
							  	// $(".tbl-payslip input[type='text']")
							    _decimal($(this),$(this).parents(".tblpsparent").prop("id"));
							});
							$(".tbl-payslip input[type='text']").each(function(e){
								// $(this).val($(this).val().replace(",",""));
								txt1=$(this);
								var ex = /^[0-9]+\.?[0-9]*$/;
								// var ex =/^\$?([0-9]{1,3},([0-9]{3},)*[0-9]{3}|[0-9]+)(.[0-9][0-9])?$/;
							 	if(ex.test(txt1.val())==false){
								   txt1.val(txt1.val().replace(/[^0-9.-]/g, '').replace(/(\..*)\./g, '$1').replace(/(?!^)-/g, ''));
							  	}
							  	txt1.val(currencyformat(txt1.val()));
							});
						});
					}
				}
				function numnull(num1){
					if(!num1){
						// $("#alert").html("lol"+num1);
						return 0;
					}else{
						return roundNumber(num1.toString().replace(/[,]/g,""),2);
					}
				}
				function _decimal(txt1,tbl){
					// var ex = /^[0-9]+\.?[0-9]*$/;
				 // 	if(ex.test(txt1.val())==false){
					//    txt1.val(txt1.val().replace(/[^0-9.-]/g, '').replace(/(\..*)\./g, '$1').replace(/(?!^)-/g, ''));
				 //  	}else{
				  		if(txt1.prop("name")=="absent_val" || txt1.prop("name")=="late_val" || txt1.prop("name")=="tlate_val" || txt1.prop("name")=="undertime_val" || txt1.prop("name")=="tundertime_val"){
					  		_net(tbl);
					  	}
					  	if(txt1.prop("name")=="overtime_val" || txt1.prop("name")=="special_holiday_val" || txt1.prop("name")=="legal_holiday_val"){
					  		_total_op(tbl);
					  	}
					  	if(txt1.prop("name")=="total_overtime_pay"){
					  		_gp(tbl);
					  	}
					  	if(txt1.prop("name")=="sss" || txt1.prop("name")=="phic" || txt1.prop("name")=="hdmf" || txt1.prop("name")=="wtax" || txt1.prop("name")=="hdmf_loan_cal" || txt1.prop("name")=="hdmf_loan_mpl" || txt1.prop("name")=="sss_loan" || txt1.prop("name")=="philam" || txt1.prop("name")=="advances" || txt1.prop("name")=="sophia_loan" || txt1.prop("name")=="laptop_phone_loan" || txt1.prop("name")=="ipad" || txt1.prop("name")=="phone_bills" || txt1.prop("name")=="other_deduction" || txt1.prop("name")=="proware" || txt1.prop("name")=="canteen" || txt1.prop("name")=="chowking" || txt1.prop("name")=="gross_pay"){
					  		_total_deduction(tbl);
					  	}
					  	if(txt1.prop("name")=="total_deduction"){
					  		_netpay(tbl);
					  	}
					  	if(txt1.prop("name")=="basic_pay" || txt1.prop("name")=="honorarium_allowance" || txt1.prop("name")=="retro"){
					  		total_pay(tbl);
					  	}
				 //  	}
				}
				function total_pay(tbl){
					var total1=parseFloat(numnull($("#"+tbl+" [name='basic_pay']").val()))+parseFloat(numnull($("#"+tbl+" [name='honorarium_allowance']").val()))+parseFloat(numnull($("#"+tbl+" [name='retro']").val()));
					$("#"+tbl+" [name='total_pay']").val(currencyformat(total1));
					// $("#total_pay").attr("value",total1);
					_net(tbl);
				}

				function _net(tbl){
					var total1=parseFloat(numnull($("#"+tbl+" [name='absent_val']").val()))+parseFloat(numnull($("#"+tbl+" [name='late_val']").val()))+parseFloat(numnull($("#"+tbl+" [name='tlate_val']").val()))+parseFloat(numnull($("#"+tbl+" [name='undertime_val']").val()))+parseFloat(numnull($("#"+tbl+" [name='tundertime_val']").val()));
					total1=parseFloat(numnull($("#"+tbl+" [name='total_pay']").val()))-total1;
					$("#"+tbl+" [name='net']").val(currencyformat(total1));
					// $("#net").attr("value",total1);
					_total_op(tbl);
				}
				function _total_op(tbl){
					var total1=parseFloat(numnull($("#"+tbl+" [name='overtime_val']").val()))+parseFloat(numnull($("#"+tbl+" [name='special_holiday_val']").val()))+parseFloat(numnull($("#"+tbl+" [name='legal_holiday_val']").val()));
					$("#"+tbl+" [name='total_overtime_pay']").val(currencyformat(total1));
					// $("#total_overtime_pay").attr("value",total1);
					var total_pay=parseFloat(numnull($("#"+tbl+" [name='net']").val()));
					$("#"+tbl+" [name='gross_pay']").val(currencyformat(total_pay+total1));
					// $("#gross_pay").attr("value",(total_pay+total1));
					_gp(tbl);
				}
				function _gp(tbl){
					var ot=parseFloat(numnull($("#"+tbl+" [name='total_overtime_pay']").val()));
					var total_pay=parseFloat(numnull($("#"+tbl+" [name='net']").val()));
					$("#"+tbl+" [name='gross_pay']").val(currencyformat(total_pay+ot));
					// $("#gross_pay").attr("value",(total_pay+ot));
					_total_deduction(tbl);
				}
				function _total_deduction(tbl){
					var total_deduction=parseFloat(numnull($("#"+tbl+" [name='sss']").val()));
					total_deduction+=parseFloat(numnull($("#"+tbl+" [name='phic']").val()));
					total_deduction+=parseFloat(numnull($("#"+tbl+" [name='hdmf']").val()));
					total_deduction+=parseFloat(numnull($("#"+tbl+" [name='wtax']").val()));
					// total_deduction+=parseFloat(numnull($("#"+tbl+" [name='hdmf_loan_cal']").val()));
					// total_deduction+=parseFloat(numnull($("#"+tbl+" [name='hdmf_loan_mpl']").val()));
					// total_deduction+=parseFloat(numnull($("#"+tbl+" [name='sss_loan']").val()));
					<?php 
							$sql_empdeduct1="SELECT DISTINCT(deduc_id),deduc_code FROM tbl_deductions ORDER BY deduc_id ASC";
							foreach ($hr_pdo->query($sql_empdeduct1) as $empdeduct1){ ?>
								total_deduction+=parseFloat(numnull($("#"+tbl+" [name='<?=$empdeduct1['deduc_code']?>']").val()));
					<?php 	} ?>
					$("#"+tbl+" [name='total_deduction']").val(currencyformat(total_deduction));
					// $("#total_deduction").attr("value",total_deduction);
					_netpay(tbl);
				}
				function _netpay(tbl){
					var total_deduction=parseFloat(numnull($("#"+tbl+" [name='total_deduction']").val()));
					var gp=parseFloat(numnull($("#"+tbl+" [name='gross_pay']").val()));
					$("#"+tbl+" [name='net_pay']").val(currencyformat(gp-total_deduction));
					// $("#net_pay").attr("value",(gp-total_deduction));
				}
			</script>
<?php 	} ?>