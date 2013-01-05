<?php

	//Cut a string from one piece to another
	function cut($from, $to, $content){
		if(eregi($from ,$content)){
			$end = explode($from, $content);
			$end = $end[1];
			$end = explode($to, $end);
			$end = $end[0];
			return $end;

		}else{
			return FALSE;
		}
	}
	
?>