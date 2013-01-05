<?php
	function freeproxyCH($page = 1){
		$html = file_get_contents('http://freeproxy.ch/proxy'. $page .'.htm');
		$cuts = explode('<td width="45%" align="left">', $html);

		foreach ($cuts as $k => $v) {
			if($k != 0){
				$final_cut = explode('</td>', $v);
				$final_proxy[] = explode(':',$final_cut[0]);
			}
		}

		return $final_proxy;	
	}
?>