<?php

	class Test{
		function __construct($ip, $port){
			$this->database = new Database;
			$this->ip = $ip;
			$this->port = $port;
			$this->proxy = $ip . ':' . $port;
			$this->testPage = 'http://jsonip.com/';
		}

		public function testProxy(){
			$context = array(
				'http' => array(
				'proxy' => 'tcp://' . $this->proxy,
				'request_fulluri' => true,
				),
			);

			$createContext = stream_context_create($context);

			$file = file_get_contents($this->testPage, False, $createContext);
			$output = json_decode($file, true);

			return $this->ip == $output['ip'];
		}

		public function insertProxy($test = false){
			if($test){
				$this->database->insertNewProxy($this->ip, $this->port);				
				$this->updateProxy();
			}else{
				$this->database->insertNewProxy($this->ip, $this->port);				
			}
		}

		public function updateProxy(){
			if($this->testProxy()){
				return $this->database->updateStatusOfProxy($this->ip, $this->port, 1);

			}else{
				$current = $this->database->getStatusOfProxy($this->ip, $this->port);
				
				if($current == 2){
					return $this->database->updateStatusOfProxy($this->ip, $this->port, 3);
				}else{
					return $this->database->updateStatusOfProxy($this->ip, $this->port, 2);
				}
			}
		}
	}

?>