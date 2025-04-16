<?php
require_once($com_root."/db/db.php");
require_once($com_root."/db/core.php");
require_once($com_root."/actions/get_person.php");

if(empty($user_empno)) {
  $user_empno=fn_get_user_info('bi_empno');
}

if(isset($_POST["ir"])){
  try {
    $port_db = Database::getConnection('port');
    $hr_pdo = Database::getConnection('hr');
    } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

  $arrset=[];
  $cnt=1;

  if(get_assign('grievance','review',$user_empno)){
    $sqlir = $hr_pdo->prepare("SELECT * FROM tbl_ir 
      WHERE ir_stat = ?
            ORDER BY IF(FIND_IN_SET(?, ir_read) = 0, 0 , 1) ASC");
    $sqlir->execute([ $_POST['ir'], $user_empno ]);
  }else{
    $sqlir = $hr_pdo->prepare("SELECT * FROM tbl_ir a
      LEFT JOIN tbl_ir_forward b ON b.irf_irid = a.ir_id AND b.irf_to = ?
      WHERE ir_stat = ? 
        AND (FIND_IN_SET(?, ir_cc) > 0 
        OR FIND_IN_SET(?, ir_from) > 0 
        OR FIND_IN_SET(?, ir_to) > 0
        OR (b.irf_irid != '' AND b.irf_irid IS NOT NULL))
            ORDER BY IF(FIND_IN_SET(?, ir_read) = 0, 0 , 1) ASC");
    $sqlir->execute([ $user_empno, $_POST['ir'], $user_empno, $user_empno, $user_empno, $user_empno ]);
  }

  foreach ($sqlir->fetchall(PDO::FETCH_ASSOC) as $v) {
    $arrset[]= [
      $cnt,
      $v["ir_id"],
      date("F d, Y",strtotime($v['ir_date'])),
      get_emp_name($v['ir_from']),
      get_emp_name($v['ir_to']),
      $v['ir_subject'],
      ( $user_empno==$v["ir_to"] || get_assign('grievance','review',$user_empno) || in_array($user_empno, explode(",", $v['ir_cc'])) ) && $user_empno!=$v["ir_from"] ? (in_array($user_empno, explode(",", $v['ir_read'])) ? "read" : "unread") : "created",
      $v['ir_resolve_remarks']
    ];
    $cnt++;
  }

  echo json_encode($arrset);

}else if(isset($_POST["_13a"])){
  try {
    $port_db = Database::getConnection('port');
    $hr_pdo = Database::getConnection('hr');
    } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

  if(get_assign('grievance','review',$user_empno)){
    $sql_13a=$hr_pdo->prepare("SELECT * FROM tbl_13a WHERE 13a_stat = ? ORDER BY IF(FIND_IN_SET(?, 13a_read) = 0, 0 , 1) ASC");
    $sql_13a->execute([ $_POST["_13a"], $user_empno ]);
  }else{
    $sql_13a=$hr_pdo->prepare("SELECT * FROM tbl_13a WHERE FIND_IN_SET(?, CONCAT(13a_to,',',13a_cc,',',13a_from,',',13a_issuedby,',',13a_notedby)) > 0 AND 13a_stat = ? ORDER BY IF(FIND_IN_SET(?, 13a_read) = 0, 0 , 1) ASC");
    $sql_13a->execute([ $user_empno, $_POST["_13a"], $user_empno ]);
  }

  $arrset=[];
  $cnt=1;
  foreach ($sql_13a->fetchAll(PDO::FETCH_ASSOC) as $_13a_k) {

    $_13b=0;
    foreach ($hr_pdo->query("SELECT COUNT(13b_id) as cnt1 FROM tbl_13b WHERE 13b_13a='".$_13a_k["13a_id"]."'") as $_13br) {
      $_13b=$_13br["cnt1"];
    }

    $_13a_id=$_13a_k["13a_id"];
    $issuedby=$_13a_k["13a_issuedby"];
    $notedby=[];
    if($_13a_k["13a_notedby"]){
      $notedby=explode(",", $_13a_k["13a_notedby"]);
    }

    $witness=[];
    if($_13a_k["13a_witness"]){
      $witness=explode(",", $_13a_k["13a_witness"]);
    }

    $sign_issued=($hr_pdo->query("SELECT gs_sign, gs_empno FROM tbl_grievance_sign WHERE gs_typeid='$_13a_id' AND gs_type='13a' AND gs_signtype='issued'"))->rowCount();

    $sign_noted=($hr_pdo->query("SELECT gs_sign, gs_empno FROM tbl_grievance_sign WHERE gs_typeid='$_13a_id' AND gs_type='13a' AND gs_signtype='reviewed' AND gs_empno='$user_empno'"))->rowCount();

    $sign_witness=($hr_pdo->query("SELECT gs_sign, gs_empno FROM tbl_grievance_sign WHERE gs_typeid='$_13a_id' AND gs_type='13a' AND gs_signtype='witness' AND gs_empno='$user_empno'"))->rowCount();

    if($_13a_k["13a_stat"]=="checked" && $sign_noted > 0){
      $_13a_k["13a_stat"]="reviewed";
    }

    $remarks="";
    foreach ($hr_pdo->query("SELECT * FROM tbl_grievance_remarks WHERE gr_typeid='$_13a_id' AND gr_type='13a' ORDER BY gr_id DESC LIMIT 1") as $rmks) {
      $remarks=$rmks["gr_remarks"];
    }

    // get_assign('grievance','review',$user_empno)
    if( $_POST["_13a"] == $_13a_k["13a_stat"] &&
      (
        $user_empno==$_13a_k["13a_from"] ||
        (get_assign('grievance','review',$user_empno) && $_13a_k["13a_stat"] != "draft") ||
        ( $user_empno==$issuedby && ($_13a_k["13a_stat"] == "reviewed" ||  $_13a_k["13a_stat"]=="refused" ||  $_13a_k["13a_stat"]=="received" || $sign_issued==0) ) ||
        ( $sign_issued>0 && $_13a_k["13a_stat"]=="checked" && in_array($user_empno, $notedby) && $sign_noted==0 ) ||
        ( $_13a_k["13a_stat"]=="reviewed" && in_array($user_empno, $notedby) ) ||
        ( $_13a_k["13a_stat"]=="refused" && in_array($user_empno, $witness) ) ||
        ( $user_empno==$_13a_k["13a_to"] && ($_13a_k["13a_stat"]=="issued" || $_13a_k["13a_stat"]=="received" || $_13a_k["13a_stat"]=="refused") )
      )
    ){


      $arrset[]= [
              $cnt,
              $_13a_k["13a_id"],
              $_13a_k["13a_memo_no"],
              date("F d, Y",strtotime($_13a_k["13a_date"])),
              get_emp_name($_13a_k["13a_to"]),
              $_13a_k["13a_regarding"],
              $remarks,
              $_13a_k["13a_ir"],
              $_13b,
              !in_array($user_empno, explode(",", $_13a_k['13a_read'])) ? "unread" : "read",
              $_13a_k['13a_cancel_remarks']
            ];

      $cnt++;
    }
  }

  echo json_encode($arrset);

}else if(isset($_POST["_13b"])){
  try {
    $port_db = Database::getConnection('port');
    $hr_pdo = Database::getConnection('hr');
    } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

    if(get_assign('grievance','review',$user_empno)){
        $sql_13b = $hr_pdo->prepare("SELECT * FROM tbl_13b WHERE 13b_stat = ? ORDER BY IF(FIND_IN_SET(?, 13b_read) = 0, 0 , 1) ASC");
        $sql_13b->execute([ $_POST["_13b"], $user_empno ]);
    }else{
      $sql_13b = $hr_pdo->prepare("SELECT * FROM tbl_13b WHERE FIND_IN_SET(?, CONCAT(13b_to,',',13b_cc,',',13b_from,',',13b_issuedby,',',13b_notedby)) > 0 AND 13b_stat = ? ORDER BY IF(FIND_IN_SET(?, 13b_read) = 0, 0 , 1) ASC");
      $sql_13b->execute([ $user_empno, $_POST["_13b"], $user_empno ]);
    }

  $arrset=[];
  $cnt=1;
  foreach ($sql_13b->fetchall(PDO::FETCH_ASSOC) as $_13b_k) {
    // $user_empno=fn_get_user_info('bi_empno');
    $_13b_id=$_13b_k["13b_id"];
    $issuedby=$_13b_k["13b_issuedby"];
    $notedby=[];
    if($_13b_k["13b_notedby"]){
      $notedby=explode(",", $_13b_k["13b_notedby"]);
    }

    $witness=[];
    if($_13b_k["13b_witness"]){
      $witness=explode(",", $_13b_k["13b_witness"]);
    }

    $sign_issued=($hr_pdo->query("SELECT gs_sign, gs_empno FROM tbl_grievance_sign WHERE gs_typeid='$_13b_id' AND gs_type='13b' AND gs_signtype='issued'"))->rowCount();

    $sign_noted=($hr_pdo->query("SELECT gs_sign, gs_empno FROM tbl_grievance_sign WHERE gs_typeid='$_13b_id' AND gs_type='13b' AND gs_signtype='reviewed' AND gs_empno='$user_empno'"))->rowCount();

    $sign_witness=($hr_pdo->query("SELECT gs_sign, gs_empno FROM tbl_grievance_sign WHERE gs_typeid='$_13b_id' AND gs_type='13b' AND gs_signtype='witness' AND gs_empno='$user_empno'"))->rowCount();

    $remarks="";
    foreach ($hr_pdo->query("SELECT * FROM tbl_grievance_remarks WHERE gr_typeid='$_13b_id' AND gr_type='13b' ORDER BY gr_id DESC LIMIT 1") as $rmks) {
      $remarks=$rmks["gr_remarks"];
    }

    // get_assign('grievance','review',$user_empno)
    if( 
      $user_empno==$_13b_k["13b_from"] ||
      (get_assign('grievance','review',$user_empno) && $_13b_k["13b_stat"] != "draft") ||
      ( $user_empno==$issuedby && ($_13b_k["13b_stat"] == "reviewed" || $_13b_k["13b_stat"] == "received" || $sign_issued==0) ) ||
      ( $sign_issued>0 && $_13b_k["13b_stat"]=="pending" && in_array($user_empno, $notedby) && $sign_noted==0 ) ||
      ( $_13b_k["13b_stat"]=="refused" && in_array($user_empno, $witness) ) ||
      ( $user_empno==$_13b_k["13b_to"] && ($_13b_k["13b_stat"]=="issued" || $_13b_k["13b_stat"]=="received" || $_13b_k["13b_stat"]=="refused") )
    ){

      $arrset[]= [
              $cnt,
              $_13b_k["13b_id"],
              $_13b_k["13b_memo_no"],
              date("F d, Y",strtotime($_13b_k["13b_date"])),
              get_emp_name($_13b_k["13b_to"]),
              $_13b_k["13b_regarding"],
              $remarks,
              $_13b_k["13b_13a"],
              !in_array($user_empno, explode(",", $_13b_k['13b_read'])) ? "unread" : "read"
            ];

      $cnt++;
    }
  }

  echo json_encode($arrset);

}else if(isset($_POST["commitment"])){
  try {
    $port_db = Database::getConnection('port');
    $hr_pdo = Database::getConnection('hr');
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

    if(get_assign('grievance','review',$user_empno)){
        $sql_commit = $hr_pdo->prepare("SELECT * FROM tbl_commitment_plan a
            JOIN tbl_13a b ON b.13a_id = a.commit_13a
            ORDER BY IF(FIND_IN_SET(?, commit_read) = 0, 0 , 1) ASC");
        $sql_commit->execute([ $user_empno ]);
    }else{
      $sql_commit = $hr_pdo->prepare("SELECT * FROM tbl_commitment_plan a
        JOIN tbl_13a b ON b.13a_id = a.commit_13a
        WHERE FIND_IN_SET(?, CONCAT(b.13a_to,',',b.13a_cc,',',b.13a_from,',',b.13a_issuedby,',',b.13a_notedby)) > 0
            ORDER BY IF(FIND_IN_SET(?, commit_read) = 0, 0 , 1) ASC");
      $sql_commit->execute([ $user_empno, $user_empno ]);
    }

  $arrset=[];
  $cnt=1;
  foreach ($sql_commit->fetchall(PDO::FETCH_ASSOC) as $cp_k) {
    // $user_empno=fn_get_user_info('bi_empno');
    $commit_id=$cp_k["commit_id"];

    // get_assign('grievance','review',$user_empno)
    if( get_assign('grievance','review',$user_empno) || $user_empno==$cp_k["commit_preparedby"] || $user_empno==$cp_k["commit_agreedby"] ){


      $arrset[]= [
              $cnt,
              $cp_k["commit_id"],
              get_emp_name($cp_k["commit_preparedby"]),
              get_emp_name($cp_k["commit_agreedby"]),
              date("F d, Y",strtotime($cp_k["commit_date"])),
              $cp_k["commit_13a"],
              !in_array($user_empno, explode(",", $cp_k['commit_read'])) ? "unread" : "read"
            ];

      $cnt++;
    }
  }

  echo json_encode($arrset);

}else if(isset($_POST["notification"])){
  try {
    $port_db = Database::getConnection('port');
    $hr_pdo = Database::getConnection('hr');
    } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

    session_write_close();

  switch ($_POST["notification"]) {
    case 'ir':
      
      $cnt_posted=0;
      $cnt_explain=0;
      $cnt_resolve=0;

            if(get_assign('grievance','review',$user_empno)){
                $sqlir = $hr_pdo->prepare("SELECT ir_stat, COUNT(ir_id) AS cnt 
                    FROM tbl_ir 
                    WHERE FIND_IN_SET(?, ir_read) = 0 OR ir_stat = 'posted'
                    GROUP BY ir_id, ir_stat");
                $sqlir->execute([ $user_empno ]);
            }else{
                $sqlir = $hr_pdo->prepare("SELECT a.ir_stat, COUNT(a.ir_id) AS cnt 
                    FROM tbl_ir a
                    LEFT JOIN tbl_ir_forward b ON b.irf_irid = a.ir_id AND b.irf_to = ?
                    WHERE (FIND_IN_SET(?, ir_cc) > 0 
                        OR FIND_IN_SET(?, ir_from) > 0 
                        OR FIND_IN_SET(?, ir_to) > 0
                        OR (b.irf_irid != '' AND b.irf_irid IS NOT NULL))
                        AND (ir_stat = 'posted' OR (ir_stat IN ('resolved','needs explanation') AND FIND_IN_SET(?, ir_read) = 0))
                    GROUP BY ir_id, ir_stat");
                $sqlir->execute([ $user_empno, $user_empno, $user_empno, $user_empno, $user_empno ]);
            }

            foreach ($sqlir->fetchall(PDO::FETCH_ASSOC) as $v) {
                if($v["ir_stat"]=="posted"){
                    $cnt_posted = (int) $v['cnt'];
                }else if($v["ir_stat"]=="needs explanation"){
                    $cnt_explain = (int) $v['cnt'];
                }else if($v["ir_stat"]=="resolved"){
                    $cnt_resolve = (int) $v['cnt'];
                }
            }

            echo json_encode([$cnt_posted, $cnt_explain, $cnt_resolve]);

      break;
    
    case '13a':
      
      $arrset13apending=0;
      $arrset13achecked=0;
      $arrset13anoted=0;
      $arrset13aissued=0;
      $arrset13areceived=0;
      $arrset13arefused=0;
      $arrset13aexplain=0;
      $arrset13acancelled=0;

            // if(get_assign('grievance','review',$user_empno)){
            //     $sql_13a=$hr_pdo->prepare("SELECT a.13a_stat, COUNT(a.13a_id) AS cnt 
            //         FROM tbl_13a a
            //         LEFT JOIN 
            //         WHERE FIND_IN_SET(?, a.13a_read) = 0
            //         GROUP BY a.13a_id, a.13a_stat");
            //     $sql_13a->execute([ $user_empno ]);
            // }else{
            //     $sql_13a=$hr_pdo->prepare("SELECT a.13a_stat, COUNT(a.13a_id) AS cnt 
            //         FROM tbl_13a  a
            //         WHERE FIND_IN_SET(?, CONCAT(a.13a_to,',',a.13a_cc,',',a.13a_from,',',a.13a_issuedby,',',a.13a_notedby)) > 0
            //         GROUP BY a.13a_id, a.13a_stat");
            //     $sql_13a->execute([ $user_empno ]);
            // }

            // foreach ($sql_13a->fetchAll(PDO::FETCH_ASSOC) as $v) {
            //     // code...
            // }


            foreach ($hr_pdo->query("SELECT * FROM tbl_13a WHERE 13a_stat!='draft'") as $_13a_k) {

                $_13b=0;
                foreach ($hr_pdo->query("SELECT COUNT(13b_id) as cnt1 FROM tbl_13b WHERE 13b_stat!='draft' AND 13b_13a='".$_13a_k["13a_id"]."'") as $_13br) {
                    $_13b=$_13br["cnt1"];
                }

                // $user_empno=fn_get_user_info('bi_empno');
                $_13a_id=$_13a_k["13a_id"];
                $issuedby=$_13a_k["13a_issuedby"];
                $notedby=[];
                if($_13a_k["13a_notedby"]){
                    $notedby=explode(",", $_13a_k["13a_notedby"]);
                }

                $witness=[];
                if($_13a_k["13a_witness"]){
                    $witness=explode(",", $_13a_k["13a_witness"]);
                }

                $sign_issued=($hr_pdo->query("SELECT gs_sign, gs_empno FROM tbl_grievance_sign WHERE gs_typeid='$_13a_id' AND gs_type='13a' AND gs_signtype='issued'"))->rowCount();

                $sign_noted=($hr_pdo->query("SELECT gs_sign, gs_empno FROM tbl_grievance_sign WHERE gs_typeid='$_13a_id' AND gs_type='13a' AND gs_signtype='reviewed' AND gs_empno='$user_empno'"))->rowCount();


                $sign_witness=($hr_pdo->query("SELECT gs_sign, gs_empno FROM tbl_grievance_sign WHERE gs_typeid='$_13a_id' AND gs_type='13a' AND gs_signtype='witness' AND gs_empno='$user_empno'"))->rowCount();

                $remarks="";
                foreach ($hr_pdo->query("SELECT * FROM tbl_grievance_remarks WHERE gr_typeid='$_13a_id' AND gr_type='13a' ORDER BY gr_id DESC LIMIT 1") as $rmks) {
                    $remarks=$rmks["gr_remarks"];
                }

                // get_assign('grievance','review',$user_empno)
                if( 
                    ($user_empno==$_13a_k["13a_from"] && $_13a_k["13a_stat"]=="needs explanation") ||
                    (get_assign('grievance','review',$user_empno) && ($_13a_k["13a_stat"] == "pending" || (($_13a_k["13a_stat"] == "received" || $_13a_k["13a_stat"] == "refused" || $_13a_k["13a_stat"] == "cancelled") && !in_array($user_empno, explode(",", $_13a_k['13a_read'])) ))) ||
                    ( $user_empno==$issuedby && ($_13a_k["13a_stat"] == "reviewed" || ($_13a_k["13a_stat"]=="refused" && count($witness)==0) || $sign_issued==0 ) ) ||
                    ( $sign_issued>0 && $_13a_k["13a_stat"]=="checked" && in_array($user_empno, $notedby) && $sign_noted==0 ) ||
                    ( $_13a_k["13a_stat"]=="refused" && in_array($user_empno, $witness) && $sign_witness ) ||
                    ( $user_empno==$_13a_k["13a_to"] && ($_13a_k["13a_stat"]=="issued" || $_13a_k["13a_stat"]=="refused") )
                ){

                  if($_13a_k["13a_stat"]=="pending"){
                    $arrset13apending++;
                  }
                  if($_13a_k["13a_stat"]=="checked"){
                    $arrset13achecked++;
                  }
                  if($_13a_k["13a_stat"]=="reviewed"){
                    $arrset13anoted++;
                  }
                  if($_13a_k["13a_stat"]=="issued"){
                    $arrset13aissued++;
                  }
                  if($_13a_k["13a_stat"]=="received"){
                    $arrset13areceived++;
                  }
                  if($_13a_k["13a_stat"]=="refused"){
                    $arrset13arefused++;
                  }
                  if($_13a_k["13a_stat"]=="needs explanation"){
                    $arrset13aexplain++;
                  }
                  if($_13a_k["13a_stat"]=="cancelled"){
                    $arrset13acancelled++;
                  }
                }
            }

            echo json_encode([
              (int) $arrset13apending, // 0
              (int) $arrset13achecked, // 1
              (int) $arrset13anoted, // 2
              (int) $arrset13aissued, // 3
              (int) $arrset13areceived, // 4
              (int) $arrset13arefused, // 5
              (int) $arrset13aexplain, // 6
              (int) $arrset13acancelled // 7
          ]);

      break;

    case '13b':
      
      $arrset13bpending=0;
      $arrset13bnoted=0;
      $arrset13bissued=0;
      $arrset13breceived=0;
      $arrset13brefused=0;
      $arrset13bcancelled=0;

            foreach ($hr_pdo->query("SELECT * FROM tbl_13b WHERE 13b_stat!='draft'") as $_13b_k) {
              // $user_empno=fn_get_user_info('bi_empno');
              $_13b_id=$_13b_k["13b_id"];
              $issuedby=$_13b_k["13b_issuedby"];
              $notedby=[];
              if($_13b_k["13b_notedby"]){
                $notedby=explode(",", $_13b_k["13b_notedby"]);
              }

              $witness=[];
              if($_13b_k["13b_witness"]){
                $witness=explode(",", $_13b_k["13b_witness"]);
              }

              $sign_issued=($hr_pdo->query("SELECT gs_sign, gs_empno FROM tbl_grievance_sign WHERE gs_typeid='$_13b_id' AND gs_type='13b' AND gs_signtype='issued'"))->rowCount();

              $sign_noted=($hr_pdo->query("SELECT gs_sign, gs_empno FROM tbl_grievance_sign WHERE gs_typeid='$_13b_id' AND gs_type='13b' AND gs_signtype='reviewed' AND gs_empno='$user_empno'"))->rowCount();


              $sign_witness=($hr_pdo->query("SELECT gs_sign, gs_empno FROM tbl_grievance_sign WHERE gs_typeid='$_13b_id' AND gs_type='13b' AND gs_signtype='witness' AND gs_empno='$user_empno'"))->rowCount();

              // get_assign('grievance','review',$user_empno)
              if( 
                (get_assign('grievance','review',$user_empno) && ($_13b_k["13b_stat"] == "pending" || (($_13b_k["13b_stat"] == "received" || $_13b_k["13b_stat"] == "refused" || $_13b_k["13b_stat"] == "cancelled") && !in_array($user_empno, explode(",", $_13b_k['13b_read'])) )) ) ||
                ( $user_empno==$issuedby && ( $_13b_k["13b_stat"] == "reviewed" || ( $_13b_k["13b_stat"] == "refused" && count($witness)==0 ) || $sign_issued==0 ) ) ||
                ( $sign_issued>0 && $_13b_k["13b_stat"]=="pending" && in_array($user_empno, $notedby) && $sign_noted==0 ) ||
                ( $_13b_k["13b_stat"]=="refused" && in_array($user_empno, $witness) ) ||
                ( $user_empno==$_13b_k["13b_to"] && ($_13b_k["13b_stat"]=="issued" || $_13b_k["13b_stat"]=="refused") )
              ){

                  if($_13b_k["13b_stat"]=="pending"){
                    $arrset13bpending++;
                  }
                  if($_13b_k["13b_stat"]=="reviewed"){
                    $arrset13bnoted++;
                  }
                  if($_13b_k["13b_stat"]=="issued"){
                    $arrset13bissued++;
                  }
                  if($_13b_k["13b_stat"]=="received"){
                    $arrset13breceived++;
                  }
                  if($_13b_k["13b_stat"]=="refused"){
                    $arrset13brefused++;
                  }
                  if($_13b_k["13b_stat"]=="cancelled"){
                    $arrset13bcancelled++;
                  }
              }
            }

            echo json_encode([
              (int) $arrset13bpending, // 0
              (int) $arrset13bnoted, // 1
              (int) $arrset13bissued, // 2
              (int) $arrset13breceived, // 3
              (int) $arrset13brefused, // 4
              (int) $arrset13bcancelled // 5
          ]);

      break;

    case 'commitment':
      
      $unread=0;
            foreach ($hr_pdo->query("SELECT * FROM tbl_commitment_plan") as $cp_k) {
        // $user_empno=fn_get_user_info('bi_empno');
        $commit_id=$cp_k["commit_id"];

        // get_assign('grievance','review',$user_empno)
        if( get_assign('grievance','review',$user_empno) || $user_empno==$cp_k["commit_preparedby"] || $user_empno==$cp_k["commit_agreedby"] ){

          if(!in_array($user_empno, explode(",", $cp_k['commit_read']))){
            $unread++;
          }
        }
      }

            echo json_encode([$unread]);

      break;
  }

}else{ ?>

<div class="container-fluid">
  <div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
      <div class="panel-body">
        <span class="pull-right">
          <a href="?page=rnr" class="btn btn-default">R&R Settings</a>
        </span>
        <ul class="nav nav-tabs">
           <li role="presentation" class="active"><a onclick="$('a[href=\'#tab_ir_posted\']').click()" href="#tab_ir" data-toggle="tab">IR <span class="pull-right" style='color: red;' id="ir-cnt"></span></a> </li>
           <li role="presentation" ><a onclick="$('a[href=\'#tab_13a_pending\']').click()" href="#tab_13a" data-toggle="tab">13A <span class="pull-right" style='color: red;' id="13a-cnt"></span></a> </li>
           <li role="presentation"><a onclick="$('a[href=\'#tab_13b_pending\']').click()" href="#tab_13b" data-toggle="tab">13B <span class="pull-right" style='color: red;' id="13b-cnt"></span></a> </li>
           <li role="presentation"><a onclick="get_commitment()" href="#tab_commitment" data-toggle="tab">Commitment Plan <span class="pull-right" style='color: red;' id="commitment-cnt"></span></a> </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade in active" id="tab_ir">
            <a href="?page=ir" class="btn btn-primary btn-sm pull-right">Create Incident Report</a>
              <br>
              <ul class="nav nav-tabs">
               <li role="presentation" class="active"><a onclick="get_ir('draft')" href="#tab_ir_draft" data-toggle="tab">Draft</a></li>
               <li role="presentation" ><a onclick="get_ir('posted')" href="#tab_ir_posted" data-toggle="tab">Posted <span class="pull-right" style='color: red;' id="ir-posted-cnt"></span></a></li>
               <li role="presentation"><a onclick="get_ir('needs explanation')" href="#tab_ir_needs_explanation" data-toggle="tab">Needs Explanation <span id="ir-explain-cnt"></span></a> </li>
               <li role="presentation"><a onclick="get_ir('resolved')" href="#tab_ir_resolved" data-toggle="tab">Resolved <span id="ir-resolved-cnt"></span></a> </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade in active" id="tab_ir_draft"></div>

                <div class="tab-pane fade " id="tab_ir_posted"></div>

                <div class="tab-pane fade " id="tab_ir_needs_explanation"></div>

                <div class="tab-pane fade " id="tab_ir_resolved"></div>
            </div>
            </div>

            <div class="tab-pane fade " id="tab_13a">
              <a href="?page=13a" class="btn btn-primary btn-sm pull-right">Create 13A</a>
              <br>
              <ul class="nav nav-tabs">
               <li role="presentation" class="active"><a onclick="get_13a('draft')" href="#tab_13a_draft" data-toggle="tab">Draft</a></li>
               <li role="presentation" ><a onclick="get_13a('pending')" href="#tab_13a_pending" data-toggle="tab">Pending <span class="pull-right" style='color: red;' id="13a-pending-cnt"></span></a> </li>
               <li role="presentation" ><a onclick="get_13a('checked')" href="#tab_13a_checked" data-toggle="tab">Checked <span class="pull-right" style='color: red;' id="13a-checked-cnt"></span></a> </li>
               <li role="presentation" ><a onclick="get_13a('reviewed')" href="#tab_13a_reviewed" data-toggle="tab">Reviewed <span class="pull-right" style='color: red;' id="13a-reviewed-cnt"></span></a> </li>
               <li role="presentation"><a onclick="get_13a('issued')" href="#tab_13a_issued" data-toggle="tab">Issued <span class="pull-right" style='color: red;' id="13a-issued-cnt"></span></a> </li>
               <li role="presentation"><a onclick="get_13a('received')" href="#tab_13a_received" data-toggle="tab">Received <span class="pull-right" style='color: red;' id="13a-received-cnt"></span></a> </li>
               <li role="presentation"><a onclick="get_13a('refused')" href="#tab_13a_refused" data-toggle="tab">Refused <span class="pull-right" style='color: red;' id="13a-refused-cnt"></span></a> </li>
               <li role="presentation"><a onclick="get_13a('needs explanation')" href="#tab_13a_needs_explanation" data-toggle="tab">Needs Explanation <span class="pull-right" style='color: red;' id="13a-explain-cnt"></span></a> </li>
               <li role="presentation"><a onclick="get_13a('cancelled')" href="#tab_13a_cancelled" data-toggle="tab">Cancelled <span class="pull-right" style='color: red;' id="13a-cancelled-cnt"></span></a> </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade in active" id="tab_13a_draft"></div>

                <div class="tab-pane fade " id="tab_13a_pending"></div>

                <div class="tab-pane fade " id="tab_13a_checked"></div>

                <div class="tab-pane fade " id="tab_13a_reviewed"></div>

                <div class="tab-pane fade " id="tab_13a_issued"></div>

                <div class="tab-pane fade " id="tab_13a_received"></div>

                <div class="tab-pane fade " id="tab_13a_refused"></div>

                <div class="tab-pane fade " id="tab_13a_needs_explanation"></div>

                <div class="tab-pane fade " id="tab_13a_cancelled"></div>
            </div>
            </div>

            <div class="tab-pane fade " id="tab_13b">
              <!-- <a href="?page=13b" class="btn btn-primary btn-sm pull-right">Create 13B</a> -->
              <br>
              <ul class="nav nav-tabs">
               <li role="presentation" class="active"><a onclick="get_13b('draft')" href="#tab_13b_draft" data-toggle="tab">Draft</a></li>
               <li role="presentation" ><a onclick="get_13b('pending')" href="#tab_13b_pending" data-toggle="tab">Pending <span class="pull-right" style='color: red;' id="13b-pending-cnt"></span></a> </li>
               <li role="presentation"><a onclick="get_13b('reviewed')" href="#tab_13b_reviewed" data-toggle="tab">Reviewed <span class="pull-right" style='color: red;' id="13b-reviewed-cnt"></span></a> </li>
               <li role="presentation"><a onclick="get_13b('issued')" href="#tab_13b_issued" data-toggle="tab">Issued <span class="pull-right" style='color: red;' id="13b-issued-cnt"></span></a> </li>
               <li role="presentation"><a onclick="get_13b('received')" href="#tab_13b_received" data-toggle="tab">Received <span class="pull-right" style='color: red;' id="13b-received-cnt"></span></a> </li>
               <li role="presentation"><a onclick="get_13b('refused')" href="#tab_13b_refused" data-toggle="tab">Refused <span class="pull-right" style='color: red;' id="13b-refused-cnt"></span></a> </li>
               <li role="presentation"><a onclick="get_13b('cancelled')" href="#tab_13b_cancelled" data-toggle="tab">Cancelled <span class="pull-right" style='color: red;' id="13b-cancelled-cnt"></span></a> </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade in active" id="tab_13b_draft"></div>

                <div class="tab-pane fade " id="tab_13b_pending"></div>

                <div class="tab-pane fade " id="tab_13b_reviewed"></div>

                <div class="tab-pane fade " id="tab_13b_issued"></div>

                <div class="tab-pane fade " id="tab_13b_received"></div>

                <div class="tab-pane fade " id="tab_13b_refused"></div>

                <div class="tab-pane fade " id="tab_13b_cancelled"></div>
            </div>
            </div>

            <div class="tab-pane fade " id="tab_commitment">
              
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('a[href=\'#tab_ir_posted\']').click()
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $.fn.dataTable.tables( { visible: true, api: true } ).columns.adjust();
      });
      get_notification("ir");
      get_notification("13a");
      get_notification("13b");
      get_notification("commitment");
  });

  function get_notification(_type1){
    $.post("dashboard",{ notification: _type1 },function(res1){
      var obj1=JSON.parse(res1);
      switch(_type1){
        case "ir":
          var _sum = obj1[0]+obj1[1]+obj1[2];
          if(obj1[0]>0 || obj1[1]>0 || obj1[2]>0){
            $("#ir-cnt").html("("+_sum+")");

            if(obj1[0]>0){
              $("#ir-posted-cnt").html("("+obj1[0]+")");
            }
            if(obj1[1]>0){
              $("#ir-explain-cnt").html("("+obj1[1]+")");
            }
            if(obj1[2]>0){
              $("#ir-resolved-cnt").html("("+obj1[2]+")");
            }
          }
        break;

        case "13a":
          var _sum1=obj1[0]+obj1[1]+obj1[2]+obj1[3]+obj1[4]+obj1[5]+obj1[6]+obj1[7];

          if(_sum1>0){
            $("#13a-cnt").html("("+_sum1+")");

            if(obj1[0]>0){
              $("#13a-pending-cnt").html("("+obj1[0]+")");
            }
            if(obj1[1]>0){
              $("#13a-checked-cnt").html("("+obj1[1]+")");
            }
            if(obj1[2]>0){
              $("#13a-reviewed-cnt").html("("+obj1[2]+")");
            }
            if(obj1[3]>0){
              $("#13a-issued-cnt").html("("+obj1[3]+")");
            }
            if(obj1[4]>0){
              $("#13a-received-cnt").html("("+obj1[4]+")");
            }
            if(obj1[5]>0){
              $("#13a-refused-cnt").html("("+obj1[5]+")");
            }
            if(obj1[6]>0){
              $("#13a-explain-cnt").html("("+obj1[6]+")");
            }
            if(obj1[7]>0){
              $("#13a-cancelled-cnt").html("("+obj1[7]+")");
            }
          }
        break;

        case "13b":
          var _sum1=obj1[0]+obj1[1]+obj1[2]+obj1[3]+obj1[4]+obj1[5];

          if(_sum1>0){
            $("#13b-cnt").html("("+_sum1+")");

            if(obj1[0]>0){
              $("#13b-pending-cnt").html("("+obj1[0]+")");
            }
            if(obj1[1]>0){
              $("#13b-reviewed-cnt").html("("+obj1[1]+")");
            }
            if(obj1[2]>0){
              $("#13b-issued-cnt").html("("+obj1[2]+")");
            }
            if(obj1[3]>0){
              $("#13b-received-cnt").html("("+obj1[3]+")");
            }
            if(obj1[4]>0){
              $("#13b-refused-cnt").html("("+obj1[4]+")");
            }
            if(obj1[5]>0){
              $("#13b-cancelled-cnt").html("("+obj1[5]+")");
            }
          }
        break;

        case "commitment" :
          if(obj1[0]>0){
            $("#commitment-cnt").html("("+obj1[0]+")");
          }
        break;
      }
    });
  }

  function get_ir(_tab1){
    $("#tab_ir_"+_tab1.replace(" ","_")).html("<img src='../../img/loading.gif' width='100px'>");
    $.post("dashboard",{ ir:_tab1 },function(data1){
      var obj1=JSON.parse(data1);
      var txt1 ="<br>";
        txt1 +="<table id='tbl-ir-"+_tab1.replace(" ","-")+"' class='table table-hover' width='100%'>";
        txt1 +="<thead>";
        txt1 +="<tr>";
        txt1 +="<th>#</th>";
        txt1 +="<th>Date</th>";
        txt1 +="<th>From</th>";
        txt1 +="<th>To</th>";
        txt1 +="<th>Subject</th>";
        txt1 += _tab1 == "resolved" ? "<th>Remarks</th>" : "";
        txt1 +="<th>Status</th>";
        txt1 +="<th></th>";
        txt1 +="</tr>";
        txt1 +="</thead>";
        txt1 +="<tbody>"; 
        for(x1 in obj1){
          txt1 +="<tr>";
          txt1 +="<td>"+obj1[x1][0]+"</td>";
          txt1 +="<td>"+obj1[x1][2]+"</td>";
          txt1 +="<td>"+obj1[x1][3]+"</td>";
          txt1 +="<td>"+obj1[x1][4]+"</td>";
          txt1 +="<td>"+obj1[x1][5]+"</td>";
          txt1 += _tab1 == "resolved" ? "<td>"+obj1[x1][7]+"</td>" : "";
          txt1 +="<td>"+obj1[x1][6]+"</td>";
          txt1 +="<td><a href='?page=ir&no="+obj1[x1][1]+"' class='btn btn-info btn-sm'><i class='fa fa-eye'></i></a></td>";
          txt1 +="</tr>";
        }
        txt1 +="</tbody>";
        txt1 +="</table>";

      $("#tab_ir_"+_tab1.replace(" ","_")).html(txt1);

      var table_ir=$('#tbl-ir-'+_tab1.replace(" ","-")).DataTable({
                "scrollY": "400px",
                "scrollX": "100%",
                    "scrollCollapse": true,
                    "paging": false,
                    "columnDefs": [
                    { "targets": _tab1 == "resolved" ? 7 : 6, "orderable": false }
                  ]
              });
    });
  }

  function get_13a(_tab1){
    $("#tab_13a_"+_tab1.replace(" ","_")).html("<img src='../../img/loading.gif' width='100px'>");
    $.post("dashboard",{ _13a:_tab1 },function(data1){
      var obj1=JSON.parse(data1);
      var txt1 ="<br>";
        txt1 +="<table id='tbl-13a-"+_tab1.replace(" ","-")+"' class='table table-hover' width='100%'>";
        txt1 +="<thead>";
        txt1 +="<tr>";
        txt1 +="<th>#</th>";
        txt1 +="<th>Memo No</th>";
        txt1 +="<th>Date</th>";
        txt1 +="<th>To</th>";
        txt1 +="<th>Regarding</th>";
        if(_tab1=="needs explanation" || _tab1=="cancelled"){
          txt1 +="<th>Remarks</th>";
        }
        txt1 +="<th></th>";
        txt1 +="</tr>";
        txt1 +="</thead>";
        txt1 +="<tbody>"; 
        for(x1 in obj1){
          txt1 +="<tr style='cursor: pointer;' onclick=location='?page=13a&no="+obj1[x1][1]+"&ir="+obj1[x1][7]+"'>";
          txt1 +="<td>"+obj1[x1][0]+"</td>";
          txt1 +="<td>"+obj1[x1][2]+"</td>";
          txt1 +="<td>"+obj1[x1][3]+"</td>";
          txt1 +="<td>"+obj1[x1][4]+"</td>";
          txt1 +="<td>"+obj1[x1][5]+"</td>";
          if(_tab1=="needs explanation"){
            txt1 +="<td>"+obj1[x1][6]+"</td>";
          }else if(_tab1=="cancelled"){
            txt1 +="<td>"+obj1[x1][10]+"</td>";
          }
          txt1 +="<td>"+obj1[x1][9]+"</td>";
          txt1 +="</tr>";
        }
        txt1 +="</tbody>";
        txt1 +="</table>";

      $("#tab_13a_"+_tab1.replace(" ","_")).html(txt1);

      var table_13a=$('#tbl-13a-'+_tab1.replace(" ","-")).DataTable({
                "scrollY": "400px",
                "scrollX": "100%",
                    "scrollCollapse": true,
                    "paging": false
              });
    });
  }

  function get_13b(_tab1){
    $("#tab_13b_"+_tab1).html("<img src='../../img/loading.gif' width='100px'>");
    $.post("dashboard",{ _13b:_tab1 },function(data1){
      var obj1=JSON.parse(data1);
      var txt1 ="<br>";
        txt1 +="<table id='tbl-13b-"+_tab1+"' class='table table-hover' width='100%'>";
        txt1 +="<thead>";
        txt1 +="<tr>";
        txt1 +="<th>#</th>";
        txt1 +="<th>Memo No</th>";
        txt1 +="<th>Date</th>";
        txt1 +="<th>To</th>";
        txt1 +="<th>Regarding</th>";
        if(_tab1=="refused"){
          txt1 +="<th>Remarks</th>";
        }
        txt1 +="<th></th>";
        txt1 +="</tr>";
        txt1 +="</thead>";
        txt1 +="<tbody>"; 
        for(x1 in obj1){
          txt1 +="<tr style='cursor: pointer;' onclick=location='?page=13b&no="+obj1[x1][1]+"&_13a="+obj1[x1][7]+"'>";
          txt1 +="<td>"+obj1[x1][0]+"</td>";
          txt1 +="<td>"+obj1[x1][2]+"</td>";
          txt1 +="<td>"+obj1[x1][3]+"</td>";
          txt1 +="<td>"+obj1[x1][4]+"</td>";
          txt1 +="<td>"+obj1[x1][5]+"</td>";
          if(_tab1=="refused"){
            txt1 +="<td>"+obj1[x1][6]+"</td>";
          }
          txt1 +="<td>"+obj1[x1][8]+"</td>";
          txt1 +="</tr>";
        }
        txt1 +="</tbody>";
        txt1 +="</table>";

      $("#tab_13b_"+_tab1).html(txt1);

      var table_13b=$('#tbl-13b-'+_tab1).DataTable({
                "scrollY": "400px",
                "scrollX": "100%",
                    "scrollCollapse": true,
                    "paging": false
              });
    });
  }

  function get_commitment(){
    $("#tab_commitment").html("<img src='../../img/loading.gif' width='100px'>");
    $.post("dashboard",{ commitment:"1" },function(data1){
      var obj1=JSON.parse(data1);
      var txt1 ="<br>";
        txt1 +="<table id='tbl-commitment' class='table table-hover' width='100%'>";
        txt1 +="<thead>";
        txt1 +="<tr>";
        txt1 +="<th>#</th>";
        txt1 +="<th>Prepared by</th>";
        txt1 +="<th>Agreed by</th>";
        txt1 +="<th>Date</th>";
        txt1 +="<th>Status</th>";
        txt1 +="<th></th>";
        txt1 +="</tr>";
        txt1 +="</thead>";
        txt1 +="<tbody>"; 
        for(x1 in obj1){
          txt1 +="<tr>";
          txt1 +="<td>"+obj1[x1][0]+"</td>";
          txt1 +="<td>"+obj1[x1][2]+"</td>";
          txt1 +="<td>"+obj1[x1][3]+"</td>";
          txt1 +="<td>"+obj1[x1][4]+"</td>";
          txt1 +="<td>"+obj1[x1][6]+"</td>";
          txt1 +="<td><a href='?page=commitment-plan&_13a="+obj1[x1][5]+"' class='btn btn-info btn-sm'><i class='fa fa-eye'></i></a></td>";
          txt1 +="</tr>";
        }
        txt1 +="</tbody>";
        txt1 +="</table>";

      $("#tab_commitment").html(txt1);

      var table_ir=$('#tbl-commitment').DataTable({
                "scrollY": "400px",
                "scrollX": "100%",
                    "scrollCollapse": true,
                    "paging": false,
                    "columnDefs": [
                    { "targets":5, "orderable": false }
                  ]
              });
    });
  }
</script>

<?php
}