<?php 
// echo $_SERVER['DOCUMENT_ROOT'];exit;
if(session_status() === PHP_SESSION_NONE) session_start();
if(empty($_SESSION['user_id']) && !in_array($_SERVER['REQUEST_URI'], ['/Portal/login', '/Portal/signIn', '/Portal/signOut'])){
    header("LOCATION: /Portal/login");
}

$portal_root = $_SERVER['DOCUMENT_ROOT']."/Portal";
$main_root = $portal_root."/main";
$sr_root = $portal_root."/leave";

// sidenav
 $sidenav = $main_root."/layout/sidenav.php";

// layout + route
include_once($main_root."/routes/route.php");