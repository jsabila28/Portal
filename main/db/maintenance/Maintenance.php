<?php
require_once($pi_root."/db/db.php");

/**
 * user mapping class
 */
class Maintenance
{
	// private $hr_db;
	// private $pi_db;
	// private $scms_db;

	function __construct()
	{
		// $this->hr_db = Database::getConnection('hr');
		// $this->scms_db = Database::getConnection('scms');
		// $this->pi_db = Database::getConnection('pi');
	}

	public static function getUserMap()
	{
		// $scms_db = Database::getConnection('scms');

		$sql = Database::getConnection('scms')->query("SELECT a.*,
				UPPER(TRIM(CONCAT(a.fname, ' ', a.lname))) AS fullname
			FROM pos_user a
			-- LEFT JOIN pos_user_group b 
			WHERE (a.date_disabled = ''
				OR a.date_disabled IS NULL
				OR a.date_disabled = '0000-00-00') 
				AND (a.group_id = 2 OR a.group_id = 3)
			ORDER BY 
				IF(IFNULL(hr_id, '') = '', 0, 1) ASC,
				TRIM(CONCAT(a.fname, ' ', a.lname)) ASC");
		return $sql->fetchall();
	}

	public static function getSLGuidelines()
	{
		$sql = Database::getConnection('pi')->query("SELECT *
			FROM tbl_sl_guidelines
			ORDER BY
				CASE
					WHEN slg_type = 'SD' THEN 4
					WHEN slg_type = 'SOM' THEN 3
					WHEN slg_type = 'ASH' THEN 2
					ELSE 1
				END ASC");
		return $sql->fetchall();
	}

	public function saveSLGuidelines($arg)
	{	
		try {

			$con = Database::getConnection('pi');

			if(!empty($arg['id'])){
				$sql = $con->prepare("UPDATE tbl_sl_guidelines 
					SET slg_tc80 = ?,
						slg_tc90 = ?,
						slg_tc100 = ?,
						slg_ccr80 = ?,
						slg_ccr90 = ?,
						slg_ccr100 = ?
					WHERE slg_id = ?
						AND slg_type = ?");
				$sql->execute([
					$arg['tc80'],
					$arg['tc90'],
					$arg['tc100'],
					$arg['ccr80'],
					$arg['ccr90'],
					$arg['ccr100'],
					$arg['id'],
					$arg['type']
				]);
			}else{
				$sql = $con->prepare("INSERT INTO tbl_sl_guidelines (
						slg_type,
						slg_tc80,
						slg_tc90,
						slg_tc100,
						slg_ccr80,
						slg_ccr90,
						slg_ccr100
					)
					VALUES (?, ?, ?, ?, ?, ?, ?)");
				$sql->execute([
					$arg['type'],
					$arg['tc80'],
					$arg['tc90'],
					$arg['tc100'],
					$arg['ccr80'],
					$arg['ccr90'],
					$arg['ccr100']
				]);

				$arg['id'] = $con->lastInsertId();
			}

			return json_encode([
				"status" => 1,
				"id" => $arg['id']
			]);
		} catch (PDOException $e) {
			return json_encode([
				"status" => 0,
				"err" => $e->getMessage()
			]);
		}
	}
}