<?php 
error_reporting(E_ALL ^ E_DEPRECATED);
if(session_status() === PHP_SESSION_NONE) session_start();
if(empty($_SESSION['user_id']) && !in_array($_SERVER['REQUEST_URI'], ['/Portal/login', '/Portal/signIn', '/Portal/signOut'])){
    header("LOCATION: /Portal/login");
}
// session_destroy();
// print_r(session_status());
// phpinfo();exit();
// $_SESSION['pi_session'] = '1';

$portal_root = $_SERVER['DOCUMENT_ROOT']."/Portal";

$com_root = $portal_root."/compliance";

// sidenav
// $sidenav = $sr_root."/layout/sidenav.php";

// layout + route
include_once($com_root."/routes/route.php");