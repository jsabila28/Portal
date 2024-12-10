<?php 
// echo $_SERVER['DOCUMENT_ROOT'];exit;
if(session_status() === PHP_SESSION_NONE) session_start();
if(empty($_SESSION['user_id']) && !in_array($_SERVER['REQUEST_URI'], ['/Portal/login', '/Portal/signIn', '/Portal/signOut'])){
    header("LOCATION: /Portal/login");
}

$portal_root = $_SERVER['DOCUMENT_ROOT']."/Portal";
$main_root = $portal_root."/main";
$atd_root = $portal_root."/ATD";
$sr_root = $portal_root."/profile";
$dtr_root = $portal_root."/dtr";

// sidenav
 $sidenav = $main_root."/layout/sidenav.php";
 $hotside = $main_root."/layout/hotside.php";

// layout + route
include_once($main_root."/routes/route.php");