<?php
	error_reporting(E_ALL ^ E_WARNING);

	require_once('bin/common_config.php');

	$test = new Test('117.102.94.1801', '8080');


	if($test->testProxy()){
		echo "El proxy funciono\n";
	}else{
		echo "El proxy fallo\n";
	}

	$test->insertProxy(true);
	
	//$test->updateProxy();
?>