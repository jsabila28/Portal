<?php

	// $host ='localhost';
	$host ='13.213.190.95';
	//$host ='192.168.10.6';
	$uname='misadmin';
	$pword='88224646abxy@';
	//$pword='';
	$dbase = 'tngc_hrd2';
	
	try {

		$mysqlhelper = new PDO("mysql:host=$host;dbname=$dbase",$uname,$pword, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$mysqlhelper->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		echo $e->getMessage();
		die();
	}
	
?>