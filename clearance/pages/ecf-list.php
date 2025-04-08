<?php
date_default_timezone_set('Asia/Manila');
require_once($sr_root . '/db/HR.php');
$db_hr = new HR();

$user_empno = $_SESSION['user_id'] ?? '';

if (isset($_POST["getecf"])) {
	$stat = $_POST["getecf"] == "checked" ? "pending" : $_POST["getecf"];

	$req_cat_res = [];
	$req_cat_clr_res = [];

	if ($_POST["getecf"] == "checked") {
		$sql = "SELECT ecf_id,
					ecf_no,
					ecf_empno,
					ecf_name,
					ecf_company,
					ecf_dept,
					ecf_outlet,
					ecf_pos,
					ecf_empstatus,
					ecf_lastday,
					ecf_separation,
					ecf_reqby,
					ecf_reqdate,
					ecf_salholddt,
					ecf_status,
					catstat_dtchecked,
					ecf_dtcleared,
					cat_priority,
					catstat_stat

			FROM db_ecf2.tbl_request 
			LEFT JOIN db_ecf2.tbl_req_category a ON catstat_ecfid=ecf_id 
			LEFT JOIN db_ecf2.tbl_category b ON cat_id=catstat_cat 
			WHERE ecf_status='$stat' AND (catstat_emp='$user_empno' OR FIND_IN_SET('$user_empno', cat_checker) > 0) AND (NOT(catstat_sign='' OR catstat_sign IS NULL) OR catstat_stat!='pending') 
			GROUP BY ecf_id 
			ORDER BY ecf_lastday ASC, catstat_dtchecked DESC";
	} else if ($stat == "cleared") {
		$sql = "SELECT ecf_id,
					ecf_no,
					ecf_empno,
					ecf_name,
					ecf_company,
					ecf_dept,
					ecf_outlet,
					ecf_pos,
					ecf_empstatus,
					ecf_lastday,
					ecf_separation,
					ecf_reqby,
					ecf_reqdate,
					ecf_salholddt,
					ecf_status,
					catstat_dtchecked,
					ecf_dtcleared,
					cat_priority,
					catstat_stat

			FROM db_ecf2.tbl_request 
			LEFT JOIN db_ecf2.tbl_req_category a ON a.catstat_ecfid=ecf_id 
			LEFT JOIN db_ecf2.tbl_category b ON b.cat_id=a.catstat_cat 
			WHERE ecf_status='$stat' AND ( ecf_reqby='$user_empno' OR a.catstat_emp='$user_empno' OR FIND_IN_SET('$user_empno', b.cat_checker) > 0 ) AND a.catstat_stat='cleared' 
			GROUP BY ecf_id 
			ORDER BY ecf_lastday ASC";

		if (HR::get_assign('ecfreq', 'viewitems', $user_empno, 'ECF')) {
			$sql = "SELECT ecf_id,
					ecf_no,
					ecf_empno,
					ecf_name,
					ecf_company,
					ecf_dept,
					ecf_outlet,
					ecf_pos,
					ecf_empstatus,
					ecf_lastday,
					ecf_separation,
					ecf_reqby,
					ecf_reqdate,
					ecf_salholddt,
					ecf_status,
					catstat_dtchecked,
					ecf_dtcleared,
					cat_priority,
					catstat_stat

			FROM db_ecf2.tbl_request 
			LEFT JOIN db_ecf2.tbl_req_category a ON a.catstat_ecfid=ecf_id 
			LEFT JOIN db_ecf2.tbl_category b ON b.cat_id=a.catstat_cat 
			WHERE ecf_status='$stat' AND a.catstat_stat='cleared' 
			GROUP BY ecf_id 
			ORDER BY ecf_lastday ASC";
		}
	} else {
		$sql = "SELECT ecf_id,
					ecf_no,
					ecf_empno,
					ecf_name,
					ecf_company,
					ecf_dept,
					ecf_outlet,
					ecf_pos,
					ecf_empstatus,
					ecf_lastday,
					ecf_separation,
					ecf_reqby,
					ecf_reqdate,
					ecf_salholddt,
					ecf_status,
					a.catstat_dtchecked,
					ecf_dtcleared,
					b.cat_priority,
					a.catstat_stat
			FROM db_ecf2.tbl_request 
			LEFT JOIN db_ecf2.tbl_req_category a ON a.catstat_ecfid=ecf_id 
			LEFT JOIN db_ecf2.tbl_category b ON b.cat_id=a.catstat_cat 
			WHERE ecf_status='$stat' AND ( ecf_reqby='$user_empno' OR ( (a.catstat_emp='$user_empno' OR FIND_IN_SET('$user_empno', b.cat_checker) > 0) AND (a.catstat_sign='' OR a.catstat_sign IS NULL) AND a.catstat_stat='pending' ) ) 
			GROUP BY ecf_id 
			ORDER BY ecf_lastday ASC";

		if (HR::get_assign('ecfreq', 'viewitems', $user_empno, 'ECF')) {
			$sql = "SELECT ecf_id,
					ecf_no,
					ecf_empno,
					ecf_name,
					ecf_company,
					ecf_dept,
					ecf_outlet,
					ecf_pos,
					ecf_empstatus,
					ecf_lastday,
					ecf_separation,
					ecf_reqby,
					ecf_reqdate,
					ecf_salholddt,
					ecf_status,
					a.catstat_dtchecked,
					ecf_dtcleared,
					b.cat_priority,
					a.catstat_stat
			FROM db_ecf2.tbl_request 
			LEFT JOIN db_ecf2.tbl_req_category a ON a.catstat_ecfid=ecf_id 
			LEFT JOIN db_ecf2.tbl_category b ON b.cat_id=a.catstat_cat 
			WHERE ecf_status='$stat' 
			GROUP BY ecf_id 
			ORDER BY ecf_lastday ASC";
		}
	}

	$q1 = $db_hr->getConnection()->query($sql);
	$r1 = $q1->fetchall(PDO::FETCH_ASSOC);

	$q2 = $db_hr->getConnection()->prepare("SELECT c.catstat_ecfid, d.cat_priority
						FROM db_ecf2.tbl_req_category c 
					  	LEFT JOIN db_ecf2.tbl_category d ON d.cat_id = c.catstat_cat
					  	WHERE FIND_IN_SET(c.catstat_ecfid, ?) > 0");
	$q2->execute([implode(",", array_column($r1, "ecf_id"))]);
	$req_cat_res = $q2->fetchall(PDO::FETCH_ASSOC);

	$q2 = $db_hr->getConnection()->prepare("SELECT c.catstat_ecfid, d.cat_priority
						FROM db_ecf2.tbl_req_category c 
					  	LEFT JOIN db_ecf2.tbl_category d ON d.cat_id = c.catstat_cat
					  	WHERE FIND_IN_SET(c.catstat_ecfid, ?) > 0 AND (NOT(c.catstat_sign='' OR c.catstat_sign IS NULL) OR c.catstat_stat = 'uncleared')");
	$q2->execute([implode(",", array_column($r1, "ecf_id"))]);
	$req_cat_clr_res = $q2->fetchall(PDO::FETCH_ASSOC);

	$arrset = [];
	foreach ($r1 as $r) {

		$cnthipri = 0;
		$cnthipriclr = 0;

		if ($_POST["getecf"] == "pending") {

			$cnthipri = count(array_filter($req_cat_res, function ($v, $k) use ($r) {
				return $v['catstat_ecfid'] == $r["ecf_id"] && $v['cat_priority'] < $r["cat_priority"];
			}, ARRAY_FILTER_USE_BOTH));
			$cnthipriclr = count(array_filter($req_cat_clr_res, function ($v, $k) use ($r) {
				return $v['catstat_ecfid'] == $r["ecf_id"] && $v['cat_priority'] < $r["cat_priority"];
			}, ARRAY_FILTER_USE_BOTH));
		}

		if ($cnthipri == $cnthipriclr || $r["ecf_reqby"] == $user_empno) {

			$arrset[] = [
				$r["ecf_id"],
				$r["ecf_no"],
				$r["ecf_empno"],
				$r["ecf_name"],
				$r["ecf_company"],
				$r["ecf_dept"],
				$r["ecf_outlet"],
				$r["ecf_pos"],
				$r["ecf_empstatus"],
				$r["ecf_lastday"],
				$r["ecf_separation"],
				$r["ecf_reqby"],
				$r["ecf_reqdate"],
				$r["ecf_salholddt"],
				$r["ecf_status"],
				!($r["catstat_dtchecked"] == '' || $r["catstat_dtchecked"] == "0000-00-00 00:00:00") ? $r["catstat_dtchecked"] : "",
				$r["ecf_dtcleared"],
				$r["catstat_stat"]
			];
		}
	}

	echo json_encode($arrset);
} else { ?>
	<style>
		.pcoded[theme-layout="vertical"] .pcoded-container {
			overflow: auto;
		}

		#disp_ecf {
			padding-top: 1rem;
		}

		#disp_ecf table td {
			padding: 5px;
		}

		.btn-custom-sm {
			padding: 3px;
		}

		.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
			color: #495057;
			background-color: #fff;
			border-color: #dee2e6 #dee2e6 #fff !important;
		}
		.nav-tabs .nav-link {
			margin-bottom: -1px;
			background-color: transparent;
			border: 1px solid transparent !important;
			border-top-left-radius: .25rem;
			border-top-right-radius: .25rem;
		}
	</style>
	<div class="container-fluid">
		<div class="card bg-white">
			<div class="card-header">
				<label>Clearance List</label>
				<?php if (HR::get_assign('ecfreq', 'viewitems', $user_empno, 'ECF')) { ?>
					<span class="pull-right">
						<button id="create-ecf" class="btn btn-primary btn-custom-sm">Create Clearance</button>&emsp;
						<a href="?page=ecf-category" class="btn btn-outline-secondary btn-custom-sm"><i class="fa fa-gears"></i></a>
					</span>
				<?php } ?>
			</div>
			<div class="card-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item" role="presentation">
						<a class="nav-link active" onclick="getecf('draft')" href="#tab-ecf-draft" data-target="#tab-ecf-draft" data-toggle="tab" type="button" role="tab">Draft&emsp;<span class="pull-right" style='color: gray;' id="ecf-draft-cnt"></span></a>
					</li>
					<li class="nav-item" role="presentation">
						<a class="nav-link" onclick="getecf('pending')" href="#tab-ecf-pending" data-target="#tab-ecf-pending" data-toggle="tab" type="button" role="tab">Pending&emsp;<span class="pull-right" style='color: red;' id="ecf-pending-cnt"></span></a>
					</li>
					<li class="nav-item" role="presentation">
						<a class="nav-link" onclick="getecf('checked')" href="#tab-ecf-checked" data-target="#tab-ecf-checked" data-toggle="tab" type="button" role="tab">Checked&emsp;<span class="pull-right" style='color: gray;' id="ecf-checked-cnt"></span></a>
					</li>
					<li class="nav-item" role="presentation">
						<a class="nav-link" onclick="getecf('cleared')" href="#tab-ecf-cleared" data-target="#tab-ecf-cleared" data-toggle="tab" type="button" role="tab">Cleared&emsp;<span class="pull-right" style='color: gray;' id="ecf-cleared-cnt"></span></a>
					</li>
				</ul>

				<div class="tab-content" id="disp_ecf"></div>
			</div>
		</div>
	</div>
	<div id="changedtmodal" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Change Last Day</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="form-changedt" class="form-horizontal">
					<div class="modal-body">
						<div class="form-group">
							<label class="col-md-3">Last Day:</label>
							<div class="col-md-7">
								<input type="date" id="ecf-changedt" min="<?= date("Y-m-d") ?>" class="form-control" required>
								<input type="hidden" id="ecf-changeid" value="">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Post</button>
						<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
					</div>
				</form>
			</div>

		</div>
	</div>

	<div id="ecfcompanymodal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Select Company</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="list-group">
						<?php
						foreach ($db_hr->getConnection()->query("SELECT * FROM tbl_company WHERE C_owned='True'") as $c_row) { ?>
							<a href="addecf?c=<?= $c_row["C_Code"] ?>" class="list-group-item"><?= $c_row["C_Name"] ?></a>
						<?php	} ?>
					</div>
				</div>
			</div>

		</div>
	</div>

	<script type="text/javascript">
		var tbl1_ecf;
		var hash = document.location.hash;
		var prefix = "";
		var ajax1 = '';
		$(function() {
			// Javascript to enable link to tab
			if (hash) {
				$('.nav-tabs a[href="' + hash.replace(prefix, "") + '"]').click();
			} else {
				$('.nav-tabs a[href="#tab-ecf-pending"]').click();
				window.location.hash = "#tab-ecf-pending";
			}
			// Change hash for page-reload
			$('.nav-tabs a').on('shown.bs.tab', function(e) {
				window.location.hash = e.target.hash.replace("#", "#" + prefix);
			});

			$("#create-ecf").on('click', function() {
				$("#ecfcompanymodal").modal("show");
			});

			$("#form-changedt").submit(function(e) {
				e.preventDefault();

				$.post("process/ecf", {
					action: "changedate",
					ecf: $("#ecf-changeid").val(),
					lastday: $("#ecf-changedt").val()
				}, function(res) {
					if (res == "1") {
						alert("Last Day changed");
						window.location.reload();
					} else {
						alert(res);
					}
				});
			});

		});

		function getecfcnt() {
			if (ajax1 && ajax1.readyState != 4) {
				ajax1.abort();
			}
			ajax1 = $.post("check_count", {
				countthis: "ecf"
			}, function(res) {
				if (res) {
					var obj1 = JSON.parse(res);

					$("#ecf-draft-cnt").html("( " + obj1[0] + " )");
					$("#ecf-pending-cnt").html("( " + obj1[1] + " )");
					$("#ecf-checked-cnt").html("( " + obj1[2] + " )");
					$("#ecf-cleared-cnt").html("( " + obj1[3] + " )");
				}
			});
		}

		function getecf(_stat) {
			$("#disp_ecf").html("Loading...");
			if (ajax1 && ajax1.readyState != 4) {
				ajax1.abort();
			}
			ajax1 = $.post("ecflist", {
				getecf: _stat
			}, function(res1) {

				var obj1 = JSON.parse(res1);
				var txt1 = "";

				txt1 += "<table class='table table-bordered' id='tbl-ecf-list-" + _stat + "' width='100%'>";
				txt1 += "<thead>";
				txt1 += "<tr>";
				txt1 += "<th>#</th>";
				txt1 += "<th>ECF NO</th>";
				txt1 += "<th>Name</th>";
				txt1 += "<th>Company</th>";
				txt1 += "<th>Department</th>";
				txt1 += "<th>Last Day</th>";
				if (_stat == "checked") {
					txt1 += "<th>Date Checked</th>";
					txt1 += "<th>Status</th>";
				} else if (_stat == "cleared") {
					txt1 += "<th>Date Cleared</th>";
				}
				txt1 += "<th></th>";
				txt1 += "</tr>";
				txt1 += "</thead>";

				txt1 += "<tbody>";
				for (x in obj1) {
					txt1 += "<tr>";
					txt1 += "<td>" + (parseInt(x) + 1) + "</td>";
					txt1 += "<td>" + obj1[x][1] + "</td>";
					txt1 += "<td>" + obj1[x][3] + "</td>";
					txt1 += "<td>" + obj1[x][4] + "</td>";
					txt1 += "<td>" + obj1[x][5] + "</td>";
					txt1 += "<td>" + obj1[x][9] + "</td>";
					if (_stat == "checked") {
						txt1 += "<td>" + obj1[x][15] + "</td>";
						txt1 += "<td>" + obj1[x][17] + "</td>";
					} else if (_stat == "cleared") {
						txt1 += "<td>" + obj1[x][16] + "</td>";
					}
					txt1 += "<td>";
					txt1 += "<a href=\"viewecf?id=" + obj1[x][0] + "\" class=\"btn btn-info btn-custom-sm\" ><i class=\"fa fa-eye\"></i></a>&nbsp;";
					if ((_stat == "pending" || _stat == "draft") && obj1[x][11] == "<?= $user_empno ?>") {
						<?php if (HR::get_assign('ecfreq', 'edit', $user_empno, 'ECF')) { ?>
							txt1 += "<a href=\"addecf?id=" + obj1[x][0] + "\" class=\"btn btn-success btn-custom-sm\" ><i class=\"fa fa-edit\"></i></a>&nbsp;";
							txt1 += "<button class=\"btn btn-outline-secondary btn-custom-sm\" onclick=\"ecfchangedt('" + obj1[x][0] + "', '" + obj1[x][9] + "')\" style='border: green 1px solid;'>Change Date</button>&nbsp;";
							txt1 += "<button class=\"btn btn-outline-secondary btn-custom-sm\" onclick=\"cancelecf('" + obj1[x][0] + "')\" style='border: red 1px solid;'>Cancel</button>";
						<?php } ?>
					}
					txt1 += "</td>";
					txt1 += "</tr>";
				}
				txt1 += "</tbody>";
				txt1 += "</table>";

				$("#disp_ecf").html(txt1);

				tbl1_ecf = $("#tbl-ecf-list-" + _stat).DataTable({
					"scrollY": "45vh",
					"scrollX": "100%",
					"scrollCollapse": true,
					"paging": false,
					"ordering": false
				});

				getecfcnt();
			});
		}

		function cancelecf(_id1) {
			if (confirm("Are you sure?")) {
				$.post("process/ecf", {
					action: "cancel",
					ecf: _id1
				}, function(res1) {
					if (res1 == "1") {
						alert("Cancelled");
					} else {
						alert(res1);
					}
				});
			}
		}

		function ecfchangedt(_id1, _date) {
			$("#ecf-changeid").val(_id1);
			$("#ecf-changedt").val(_date);
			$("#changedtmodal").modal("show");
		}
	</script>
<?php
}
