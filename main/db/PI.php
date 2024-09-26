<?php
require_once($pi_root . "/db/db.php");

/**
 * user mapping class
 */
class PI
{
	private $pi_db = null;

	function __construct()
	{
		// $this->hr_db = Database::getConnection('hr');
	}

	public static function GetOutlets()
	{
		$sql = Database::getConnection('hr')->query("SELECT 
				a.OL_Code,
				a.OL_Name,
				b.Area_Code,
				b.Area_Name,
				c.cnt AS OutletInArea
			FROM tbl_outlet a
			LEFT JOIN tbl_area b ON b.Area_Code = a.Area_Code
			LEFT JOIN (SELECT c1.Area_Code, COUNT(*) AS cnt
				FROM tbl_outlet c1 
				WHERE LOWER(c1.OL_stat) = 'active' AND c1.OL_Code NOT IN ('ADMIN', 'SCZ')
				GROUP BY c1.Area_Code) c ON c.Area_Code = a.Area_Code
			WHERE LOWER(a.OL_stat) = 'active' AND a.OL_Code NOT IN ('ADMIN', 'SCZ')
			ORDER BY c.cnt DESC, b.Area_Name ASC, a.OL_Code ASC");

		$arr = [];
		foreach ($sql->fetchall() as $v) {
			$arr[$v['OL_Code']] = $v;
		}

		return $arr;
	}

	public static function GetOutletPerArea()
	{
		$arr = [];
		foreach (self::GetOutlets() as $v) {
			$arr[$v['Area_Code']][$v['OL_Code']] = $v;
		}

		return $arr;
	}

	public function SaveDTR($arg)
	{
		if (!$this->pi_db) $this->pi_db = Database::getConnection('pi');

		try {

			$check = $this->pi_db->prepare("SELECT COUNT(dtr_id) AS cnt FROM tbl_pi_dtr WHERE dtr_empno = ? AND dtr_month_year = ?");
			$check->execute([$arg['empno'], $arg['month_year']]);
			$result = $check->fetch(PDO::FETCH_ASSOC);
			if ($result['cnt'] > 0) {
				$update = $this->pi_db->prepare("UPDATE tbl_pi_dtr SET dtr_outlet = ?, dtr_data = ? WHERE dtr_empno = ? AND dtr_month_year = ?");
				$update->execute([$arg['outlet'], $arg['data'], $arg['empno'], $arg['month_year']]);
			} else {
				$insert = $this->pi_db->prepare("INSERT INTO tbl_pi_dtr (dtr_empno, dtr_month_year, dtr_outlet, dtr_data) VALUES (?, ?, ?, ?)");
				$insert->execute([$arg['empno'], $arg['month_year'], $arg['outlet'], $arg['data']]);
			}
			return json_encode([
				"status" => 1
			]);
		} catch (PDOException $e) {
			return json_encode([
				"status" => 0,
				"err" => $e->getMessage()
			]);
		}
	}

	public function InitECSODistribution(
		$empno,
		$year_month,
		$position,
		$outlet,
		$hireddt,
		$late,
		$undertime,
		$absent,
		$remarks = ''
	) {
		if (!$this->pi_db) $this->pi_db = Database::getConnection('pi');

		try {

			$check = $this->pi_db->prepare("SELECT COUNT(dist_id) AS cnt FROM tbl_ec_so_distribution WHERE dist_empno = ? AND dist_month_year = ?");
			$check->execute([$empno, $year_month]);
			$result = $check->fetch(PDO::FETCH_ASSOC);
			if ($result['cnt'] > 0) {
				$update = $this->pi_db->prepare("UPDATE tbl_ec_so_distribution 
					SET dist_position = ?,
						dist_outlet = ?,
						dist_hireddt = ?,
						dist_late = ?,
						dist_undertime = ?,
						dist_absent = ?
					WHERE dist_empno = ? 
					AND dist_month_year = ?");
				$update->execute([
					$position,
					$outlet,
					$hireddt,
					$late,
					$undertime,
					$absent,
					$remarks,
					$empno,
					$year_month
				]);
			} else {
				$insert = $this->pi_db->prepare("INSERT INTO tbl_ec_so_distribution (
						dist_empno,
						dist_month_year,
						dist_position,
						dist_outlet,
						dist_hireddt,
						dist_late,
						dist_undertime,
						dist_absent,
						dist_remarks
					) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$insert->execute([
					$empno,
					$year_month,
					$position,
					$outlet,
					$hireddt,
					$late,
					$undertime,
					$absent,
					$remarks
				]);
			}
			return json_encode([
				"status" => 1
			]);
		} catch (PDOException $e) {
			return json_encode([
				"status" => 0,
				"err" => $e->getMessage()
			]);
		}
	}

	public function UpdateECSODistributionCIBMBTC($empno, $year_month, $type, $amount, $cib_mbtc)
	{
		if (!$this->pi_db) $this->pi_db = Database::getConnection('pi');

		try {

			$col = "";
			if ($type == 'fund') {
				$col = "dist_fund";
			} else if ($type == 'ar') {
				$col = "dist_ar";
			} else if ($type == 'cash incentive') {
				$col = "dist_cash_incentive";
			}

			$check = $this->pi_db->prepare("SELECT COUNT(dist_id) AS cnt FROM tbl_ec_so_distribution WHERE dist_empno = ? AND dist_month_year = ?");
			$check->execute([$empno, $year_month]);
			$result = $check->fetch(PDO::FETCH_ASSOC);
			if ($result['cnt'] > 0 && $col != '') {

				$update = $this->pi_db->prepare("UPDATE tbl_ec_so_distribution 
					SET " . $col . " = ?,
						dist_cib_mbtc = ?
					WHERE dist_empno = ? 
					AND dist_month_year = ?");
				$update->execute([$amount, $cib_mbtc, $empno, $year_month]);

				return json_encode([
					"status" => 1
				]);
			} else {
				return json_encode([
					"status" => 0,
					"err" => $result['cnt'] == 0 ? "Not Found" : "Invalid Input"
				]);
			}
		} catch (PDOException $e) {
			return json_encode([
				"status" => 0,
				"err" => $e->getMessage()
			]);
		}
	}

	public function SaveECSODistribution(
		$empno,
		$year_month,
		$position,
		$outlet,
		$hireddt,
		$productivity,
		$fund,
		$ar,
		$cash_incentive,
		$cib_mbtc,
		$share,
		$late,
		$undertime,
		$absent,
		$remarks
	) {
		if (!$this->pi_db) $this->pi_db = Database::getConnection('pi');

		try {

			$check = $this->pi_db->prepare("SELECT COUNT(dist_id) AS cnt FROM tbl_ec_so_distribution WHERE dist_empno = ? AND dist_month_year = ?");
			$check->execute([$empno, $year_month]);
			$result = $check->fetch(PDO::FETCH_ASSOC);
			if ($result['cnt'] > 0) {
				$update = $this->pi_db->prepare("UPDATE tbl_ec_so_distribution 
					SET dist_position = ?,
						dist_outlet = ?,
						dist_hireddt = ?,
						dist_productivity = ?,
						dist_fund = ?,
						dist_ar = ?,
						dist_cash_incentive = ?,
						dist_cib_mbtc = ?,
						dist_share = ?,
						dist_late = ?,
						dist_undertime = ?,
						dist_absent = ?,
						dist_remarks = ?
					WHERE dist_empno = ? 
					AND dist_month_year = ?");
				$update->execute([
					$position,
					$outlet,
					$hireddt,
					$productivity,
					$fund,
					$ar,
					$cash_incentive,
					$cib_mbtc,
					$share,
					$late,
					$undertime,
					$absent,
					$remarks,
					$empno,
					$year_month
				]);
			} else {
				$insert = $this->pi_db->prepare("INSERT INTO tbl_ec_so_distribution (
						dist_empno,
						dist_month_year,
						dist_position,
						dist_outlet,
						dist_hireddt,
						dist_productivity,
						dist_fund,
						dist_ar,
						dist_cash_incentive,
						dist_cib_mbtc,
						dist_share,
						dist_late,
						dist_undertime,
						dist_absent,
						dist_remarks
					) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$insert->execute([
					$empno,
					$year_month,
					$position,
					$outlet,
					$hireddt,
					$productivity,
					$fund,
					$ar,
					$cash_incentive,
					$cib_mbtc,
					$share,
					$late,
					$undertime,
					$absent,
					$remarks
				]);
			}
			return json_encode([
				"status" => 1
			]);
		} catch (PDOException $e) {
			return json_encode([
				"status" => 0,
				"err" => $e->getMessage()
			]);
		}
	}

	public function UpdateECSODistributionRelease($empno, $year_month, $status)
	{
		if (!$this->pi_db) $this->pi_db = Database::getConnection('pi');

		try {

			$check = $this->pi_db->prepare("SELECT COUNT(dist_id) AS cnt FROM tbl_ec_so_distribution WHERE dist_empno = ? AND dist_month_year = ?");
			$check->execute([$empno, $year_month]);
			$result = $check->fetch(PDO::FETCH_ASSOC);
			if ($result['cnt'] > 0) {

				$update = $this->pi_db->prepare("UPDATE tbl_ec_so_distribution 
					SET dist_status = ?
					WHERE dist_empno = ? 
					AND dist_month_year = ?");
				$update->execute([$status, $empno, $year_month]);

				return json_encode([
					"status" => 1
				]);
			} else {
				return json_encode([
					"status" => 0,
					"err" => "Not Found"
				]);
			}
		} catch (PDOException $e) {
			return json_encode([
				"status" => 0,
				"err" => $e->getMessage()
			]);
		}
	}

	public function SaveUserRemarks($empno, $year_month, $remarks)
	{
		if (!$this->pi_db) $this->pi_db = Database::getConnection('pi');

		try {

			$check = $this->pi_db->prepare("SELECT COUNT(remark_id) AS cnt FROM tbl_remarks WHERE remark_empno = ? AND remark_year_month = ?");
			$check->execute([$empno, $year_month]);
			$result = $check->fetch(PDO::FETCH_ASSOC);
			if ($result['cnt'] > 0) {
				$update = $this->pi_db->prepare("UPDATE tbl_remarks 
					SET remark_content = ?
					WHERE remark_empno = ? 
					AND remark_year_month = ?");
				$update->execute([
					$remarks,
					$empno,
					$year_month
				]);
			} else {
				$insert = $this->pi_db->prepare("INSERT INTO tbl_remarks (
						remark_empno,
						remark_year_month,
						remark_content
					) VALUES (?, ?, ?)");
				$insert->execute([
					$empno,
					$year_month,
					$remarks
				]);
			}

			return json_encode([
				"status" => 1
			]);
		} catch (PDOException $e) {
			return json_encode([
				"status" => 0,
				"err" => $e->getMessage()
			]);
		}
	}

	public static function GetECSODistribution($year_month)
	{
		$sql = Database::getConnection('pi')->prepare("SELECT *,
				IF(dist_empno LIKE 'so%' OR dist_position LIKE 'so%', 'SO', 'EC') AS tag,
				IF(
					dist_hireddt != ''
					AND dist_hireddt IS NOT NULL
					AND dist_hireddt != '0000-00-00',
					PERIOD_DIFF(DATE_FORMAT(?, '%Y%m'), DATE_FORMAT(dist_hireddt, '%Y%m')),
					0
				) AS service_duration 
			FROM tbl_ec_so_distribution
			LEFT JOIN tbl_pi_dtr ON dtr_empno = dist_empno AND dtr_month_year = dist_month_year
			LEFT JOIN tbl_remarks ON remark_empno = dist_empno AND remark_year_month = dist_month_year
			WHERE dist_month_year = ? 
				AND dist_hireddt != ''
				AND dist_hireddt IS NOT NULL
				AND dist_hireddt != '0000-00-00'
				AND (
					((dist_empno LIKE 'so%' OR dist_position LIKE 'so%')
						AND PERIOD_DIFF(DATE_FORMAT(?, '%Y%m'), DATE_FORMAT(dist_hireddt, '%Y%m')) >= 2)
					OR PERIOD_DIFF(DATE_FORMAT(?, '%Y%m'), DATE_FORMAT(dist_hireddt, '%Y%m')) >= 4
				)
			ORDER BY dist_outlet ASC, IF(dist_empno LIKE 'so%' OR dist_position LIKE 'so%', 1, 0) ASC");
		$sql->execute([date("Y-m-t", strtotime($year_month . "-01")), $year_month, date("Y-m-t", strtotime($year_month . "-01")), date("Y-m-t", strtotime($year_month . "-01"))]);

		$arr = [];
		foreach ($sql->fetchall() as $v) {

			$dtr_data = json_decode($v['dtr_data'] ?? '{}', true);

			$name = "";
			if (!empty($dtr_data['empinfo']['name'])) {
				$words = preg_split("/[\s,_.]+/", $dtr_data['empinfo']['name'][2]);
				$acronym = "";
				foreach ($words as $w) {
					$acronym .= strtoupper($w[0] ?? '') . ".";
				}
				$name = $dtr_data['empinfo']['name'][0] . ", " . trim($dtr_data['empinfo']['name'][1] . " " . trim($acronym . " " . $dtr_data['empinfo']['name'][3]));
			}

			$share = '';
			if ($v['tag'] == 'SO') {
				$share = $v['service_duration'] < 6 ? 0 : ($v['service_duration'] <= 12 ? 0.5 : 1);
			} else {
				$share = $v['service_duration'] <= 6 ? 0.5 : 1;
			}

			if (empty($v['dist_remarks'])) {
				$remarks = [];
				if (count(array_keys($dtr_data['late_list'])) > 0) {
					$remarks[] = implode(", ", array_unique(array_keys($dtr_data['late_list']))) . " Late";
				}
				if (count($dtr_data['undertime']) > 0) {
					$remarks[] = implode(", ", array_unique($dtr_data['undertime'])) . " Undertime";
				}
				if (count($dtr_data['absent']) > 0) {
					$remarks[] = implode(", ", array_unique($dtr_data['absent'])) . " Absent";
				}

				$v['dist_remarks'] = implode(" | ", $remarks);
			}

			$arr[(isset($v['dist_outlet']) ? $v['dist_outlet'] : 'OTHER')][$v['dist_empno']] = [
				'tag' => $v['tag'],
				'service_duration' => $v['service_duration'],
				'name' => $name,
				'job_code' => $dtr_data['empinfo']['job_code'] ?? '',
				'position' => $dtr_data['empinfo']['job_title'] ?? '',
				'hired_date' => $v['dist_hireddt'],
				'productivity' => $v['dist_productivity'] ?? '',
				'fund' => $v['dist_fund'] ?? '',
				'ar' => $v['dist_ar'] ?? '',
				'cash_incentive' => $v['dist_cash_incentive'] ?? '',
				'cib_mbtc' => $v['dist_cib_mbtc'] ?? '',
				'share' => $v['dist_share'] ?? $share,
				'late' => $v['dist_late'] ?? 0,
				'undertime' => $v['dist_undertime'] ?? 0,
				'absent' => $v['dist_absent'] ?? 0,
				'remarks' => $v['dist_remarks'],
				'user_remarks' => $v['remark_content'],
				'status' => $v['dist_status'],
				'rec' => is_null($v['dist_productivity']) ? 0 : 1
			];
		}
		return $arr;
	}

	public static function GetPAX($year_month)
	{
		$sql = Database::getConnection('pi')->prepare("SELECT 
		  IF(dist_outlet != '', dist_outlet, 'OTHER') AS dist_outlet,
		  SUM(IF(dist_empno LIKE 'so%' OR dist_position LIKE 'so%', 0.5, 1)) AS cnt 
		FROM
		  tbl_ec_so_distribution 
		WHERE dist_month_year = ? 
			AND dist_hireddt != ''
			AND dist_hireddt IS NOT NULL
			AND dist_hireddt != '0000-00-00'
			AND (
				((dist_empno LIKE 'so%' OR dist_position LIKE 'so%')
					AND PERIOD_DIFF(DATE_FORMAT(?, '%Y%m'), DATE_FORMAT(dist_hireddt, '%Y%m')) >= 2)
				OR PERIOD_DIFF(DATE_FORMAT(?, '%Y%m'), DATE_FORMAT(dist_hireddt, '%Y%m')) >= 4
			)
		GROUP BY dist_outlet");

		$sql->execute([$year_month, date("Y-m-t", strtotime($year_month . "-01")), date("Y-m-t", strtotime($year_month . "-01"))]);

		// return $sql->fetchall();

		$arr = [];
		foreach ($sql->fetchall() as $v) {
			$arr[$v['dist_outlet']] = $v['cnt'];
		}

		return $arr;
	}

	public static function CheckIfDTRExist($year_month = '')
	{
		$sql = Database::getConnection('pi')->prepare("SELECT COUNT(*) AS cnt FROM tbl_pi_dtr WHERE dtr_month_year = ?");
		$sql->execute([$year_month]);
		return $sql->fetch(PDO::FETCH_OBJ)->cnt;
	}

	public static function GetDTR($year_month, $empno = '')
	{
		$query = "SELECT * FROM tbl_pi_dtr WHERE dtr_month_year = ? " . ($empno ? " AND dtr_empno = ? " : "");
		$arg = [$year_month];
		if ($empno) {
			$arg[] = $empno;
		}

		$sql = Database::getConnection('pi')->prepare($query);
		$sql->execute($arg);

		$arr = [];
		foreach ($sql->fetchall() as $v) {
			$data = json_decode($v['dtr_data'], true);
			foreach ($data as $k2 => $v2) {
				$arr[$k2][$v['dtr_empno']] = $v2;
			}
		}

		return $arr;
	}

	public static function GetPIList()
	{
		return Database::getConnection('pi')->query("SELECT * FROM tbl_pi_list ORDER BY pi_year_month DESC");
	}

	public static function GetPIListLatest()
	{
		return Database::getConnection('pi')->query("SELECT * FROM tbl_pi_list ORDER BY pi_year_month DESC LIMIT 1")->fetch();
	}

	public static function GetPIListByYM($year_month)
	{
		$sql = Database::getConnection('pi')->prepare("SELECT * FROM tbl_pi_list WHERE pi_year_month = ?");
		$sql->execute([$year_month]);
		return $sql->fetch();
	}

	public static function GetPITotal($year_month)
	{
		$sql = Database::getConnection('pi')->prepare("SELECT * 
			FROM tbl_total_pi 
			LEFT JOIN tbl_additional_incentive ON ci_date = tpi_month_year AND ci_outlet = tpi_outlet
			WHERE tpi_month_year = ?");
		$sql->execute([$year_month]);

		$arr = [];
		foreach ($sql->fetchall() as $v) {
			$arr[$v['tpi_area']][$v['tpi_outlet']] = $v;
		}

		return $arr;
	}

	public function PostPI($year_month, $empno, $date, $signature = null)
	{
		if (!$this->pi_db) $this->pi_db = Database::getConnection('pi');

		try {

			$sql = $this->pi_db->prepare("UPDATE tbl_pi_list 
				SET pi_posted_by = ?,
					pi_posted_date = ?,
					pi_posted_sign = ?,
					pi_status = 'pending'
				WHERE pi_year_month = ?");

			$sql->execute([$empno, $date, $signature, $year_month]);

			return json_encode([
				"status" => 1
			]);
		} catch (PDOException $e) {
			return json_encode([
				"status" => 0,
				"err" => $e->getMessage()
			]);
		}
	}

	public function ReviewPI($year_month, $empno, $date, $signature = null)
	{
		if (!$this->pi_db) $this->pi_db = Database::getConnection('pi');

		try {

			$sql = $this->pi_db->prepare("UPDATE tbl_pi_list 
				SET pi_reviewed_by = ?,
					pi_reviewed_date = ?,
					pi_reviewed_sign = ?,
					pi_status = 'reviewed'
				WHERE pi_year_month = ?");

			$sql->execute([$empno, $date, $signature, $year_month]);

			return json_encode([
				"status" => 1
			]);
		} catch (PDOException $e) {
			return json_encode([
				"status" => 0,
				"err" => $e->getMessage()
			]);
		}
	}

	public function AuditPI($year_month, $empno, $date, $signature = null)
	{
		if (!$this->pi_db) $this->pi_db = Database::getConnection('pi');

		try {

			$sql = $this->pi_db->prepare("UPDATE tbl_pi_list 
				SET pi_audited_by = ?,
					pi_audited_date = ?,
					pi_audited_sign = ?,
					pi_status = 'audited'
				WHERE pi_year_month = ?");

			$sql->execute([$empno, $date, $signature, $year_month]);

			return json_encode([
				"status" => 1
			]);
		} catch (PDOException $e) {
			return json_encode([
				"status" => 0,
				"err" => $e->getMessage()
			]);
		}
	}

	/*public function NotePI($year_month, $empno, $date, $signature = null)
	{
		if(!$this->pi_db) $this->pi_db = Database::getConnection('pi');

		try {

			$sql = $this->pi_db->prepare("UPDATE tbl_pi_list 
				SET pi_noted_by = ?,
					pi_noted_date = ?,
					pi_noted_sign = ?,
					pi_status = 'noted'
				WHERE pi_year_month = ?");

			$sql->execute([ $empno, $date, $signature, $year_month ]);

			return json_encode([
				"status" => 1
			]);
			
		} catch (PDOException $e) {
			return json_encode([
				"status" => 0,
				"err" => $e->getMessage()
			]);
		}
	}*/

	public function ApprovePI($year_month, $empno, $date, $signature = null)
	{
		if (!$this->pi_db) $this->pi_db = Database::getConnection('pi');

		try {

			$sql = $this->pi_db->prepare("UPDATE tbl_pi_list 
				SET pi_approved_by = ?,
					pi_approved_date = ?,
					pi_approved_sign = ?,
					pi_status = 'approved'
				WHERE pi_year_month = ?");

			$sql->execute([$empno, $date, $signature, $year_month]);

			return json_encode([
				"status" => 1
			]);
		} catch (PDOException $e) {
			return json_encode([
				"status" => 0,
				"err" => $e->getMessage()
			]);
		}
	}

	public function ReleasePI($year_month)
	{
		if (!$this->pi_db) $this->pi_db = Database::getConnection('pi');

		try {

			$sql = $this->pi_db->prepare("UPDATE tbl_pi_list 
				SET pi_status = 'released'
				WHERE pi_year_month = ?");

			$sql->execute([$year_month]);

			return json_encode([
				"status" => 1
			]);
		} catch (PDOException $e) {
			return json_encode([
				"status" => 0,
				"err" => $e->getMessage()
			]);
		}
	}
}
