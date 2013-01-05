<?php
	error_reporting(E_ALL ^ E_WARNING);
	
	//Include files
	require_once 'Phactory/lib/Phactory.php';
	require_once('test_proxies.php');
	require_once('database.php');

	//Include crawler files
	include('crawler/freeproxyCH.php');

	//Init database class
	$database = new Database();
?>