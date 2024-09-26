<?php
require_once($pi_root."/db/db.php");

/**
 * user mapping class
 */
class HR
{
	// private $hr_db;

	function __construct()
	{
		// $this->hr_db = Database::getConnection('hr');
	}

	public static function getSLSEmpList()
	{
		$stmt = "SELECT
				a.bi_empno,
				UPPER(TRIM(CONCAT(a.bi_empfname, ' ', a.bi_emplname))) AS fullname,
				CASE
				    WHEN c.jrec_position LIKE 'TL%' THEN 'TL'
				    WHEN c.jrec_position LIKE 'ASH%' THEN 'ASH'
				    WHEN c.jrec_position LIKE 'SOM%' THEN 'SOM'
				    WHEN c.jrec_position LIKE 'SD%' THEN 'SD'
				    WHEN c.jrec_position LIKE 'EC%' THEN 'EC'
				    WHEN c.jrec_position LIKE 'SIC%' THEN 'SIC'
				    WHEN c.jrec_position = 'SO' OR a.bi_empno LIKE'SO%' THEN 'SO'
				    ELSE c.jrec_position
				END AS position_type,
				c.jrec_position,
				d.jd_title,
				b.ji_datehired
			FROM tbl201_basicinfo a
			JOIN tbl201_jobinfo b ON b.ji_empno = a.bi_empno AND LOWER(b.ji_remarks) = 'active'
			LEFT JOIN tbl201_jobrec c ON c.jrec_empno = a.bi_empno AND LOWER(c.jrec_status) = 'primary'
			LEFT JOIN tbl_jobdescription d ON d.jd_code = c.jrec_position
			WHERE
				a.datastat = 'current'
				AND (c.jrec_position LIKE 'TL%'
					OR c.jrec_position LIKE 'ASH%'
					OR c.jrec_position LIKE 'SOM%'
					OR c.jrec_position LIKE 'SD%'
					OR c.jrec_position LIKE 'EC%'
					OR c.jrec_position LIKE 'SIC%'
					OR c.jrec_position = 'SO'
					OR a.bi_empno LIKE'SO%')
			ORDER BY 
				CASE
					WHEN c.jrec_position LIKE 'SD%' THEN 1
					WHEN c.jrec_position LIKE 'SOM%' THEN 2
					WHEN c.jrec_position LIKE 'ASH%' THEN 3
					WHEN c.jrec_position LIKE 'TL%' THEN 4
					WHEN c.jrec_position LIKE 'SIC%' THEN 5
					WHEN c.jrec_position LIKE 'EC%' THEN 6
					ELSE 7
				END ASC,
				TRIM(CONCAT(a.bi_empfname, ' ', a.bi_emplname)) ASC";

		$sql = Database::getConnection('hr')->query($stmt);
		
		return $sql->fetchall();
	}

	public static function getSLSEmpListForMonth($year_month)
	{
		$sql = Database::getConnection('hr')->prepare("SELECT
			a.bi_empno,
			UPPER(TRIM(CONCAT(a.bi_empfname, ' ', a.bi_emplname))) AS fullname,
			CASE
				WHEN c.jrec_position LIKE 'TL%' THEN 'TL'
				WHEN c.jrec_position LIKE 'ASH%' THEN 'ASH'
				WHEN c.jrec_position LIKE 'SOM%' THEN 'SOM'
				WHEN c.jrec_position LIKE 'SD%' THEN 'SD'
				WHEN c.jrec_position LIKE 'EC%' THEN 'EC'
				WHEN c.jrec_position LIKE 'SIC%' THEN 'SIC'
				WHEN c.jrec_position = 'SO' OR a.bi_empno LIKE'SO%' THEN 'SO'
				ELSE c.jrec_position
			END AS position_type,
			c.jrec_position,
			d.jd_title,
			b.ji_datehired
		FROM tbl201_basicinfo a
		JOIN tbl201_jobinfo b ON b.ji_empno = a.bi_empno 
			AND DATE_FORMAT(ji_datehired, '%Y-%m') <= ?
			AND (LOWER(b.ji_remarks) = 'active'
				OR DATE_FORMAT(ji_resdate, '%Y-%m') >= ?)
		LEFT JOIN tbl201_jobrec c ON c.jrec_empno = a.bi_empno AND LOWER(c.jrec_status) = 'primary'
		LEFT JOIN tbl_jobdescription d ON d.jd_code = c.jrec_position
		WHERE
			a.datastat = 'current'
			AND (c.jrec_position LIKE 'TL%'
				OR c.jrec_position LIKE 'ASH%'
				OR c.jrec_position LIKE 'SOM%'
				OR c.jrec_position LIKE 'SD%'
				OR c.jrec_position LIKE 'EC%'
				OR c.jrec_position LIKE 'SIC%'
				OR c.jrec_position = 'SO'
				OR a.bi_empno LIKE'SO%')
		ORDER BY 
			CASE
				WHEN c.jrec_position LIKE 'SD%' THEN 1
				WHEN c.jrec_position LIKE 'SOM%' THEN 2
				WHEN c.jrec_position LIKE 'ASH%' THEN 3
				WHEN c.jrec_position LIKE 'TL%' THEN 4
				WHEN c.jrec_position LIKE 'SIC%' THEN 5
				WHEN c.jrec_position LIKE 'EC%' THEN 6
				ELSE 7
			END ASC,
			TRIM(CONCAT(a.bi_empfname, ' ', a.bi_emplname)) ASC");
		
		$sql->execute([ $year_month, $year_month ]);
		
		return $sql->fetchall();
	}

	public static function getSLPositions()
	{
		$stmt = "SELECT
				jd_code,
				jd_title
			FROM tbl_jobdescription
			WHERE
				jd_stat = 'active'
				AND (jd_code LIKE 'TL%'
					OR jd_code LIKE 'ASH%'
					OR jd_code LIKE 'SOM%'
					OR jd_code LIKE 'SD%')
			ORDER BY
				CASE
					WHEN jd_code LIKE 'SD%' THEN 4
					WHEN jd_code LIKE 'SOM%' THEN 3
					WHEN jd_code LIKE 'ASH%' THEN 2
					ELSE 1
				END ASC";

		$sql = Database::getConnection('hr')->query("$stmt");
		
		return $sql->fetchall();
	}
}