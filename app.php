<?php
	error_reporting(E_ALL ^ E_WARNING);

	require_once('bin/common_config.php');

	$database->updateMassProxies(-1, -1);
?>