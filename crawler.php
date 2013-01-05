<?php

	error_reporting(E_ALL ^ E_WARNING);

	require_once('bin/common_config.php');
	
	//Insert proxies proxies
	foreach(freeproxyCH() as $k => $v){
		$proxy = new Test($v[0], $v[1]);
		$proxy->insertProxy();
	}

?>