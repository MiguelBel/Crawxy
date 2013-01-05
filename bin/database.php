<?php
	/*
	* Proxies status
	* 0 -> Not tested 
	* 1 -> Working normally last time tested
	* 2 -> Not active (Tested only one time)
	* 3 -> Not active (Tested on two or more times if worked before, 1 if never worked)
	*/

	class Database{
		function __construct(){
			//Set config of MySQL
			$db['host'] = 'localhost';
			$db['db_name'] = 'crawxy';
			$db['user'] = 'root';
			$db['password'] = '12345678';

			$this->pdo = new PDO('mysql:host='. $db['host'] .';dbname=' . $db['db_name'], $db['user'], $db['password']);
		}

		public function issetProxy($ip, $port){
			$rows = $this->pdo->query("SELECT count(*) FROM proxies WHERE ip='". $ip ."' AND port='". $port ."'");
			return $rows->fetchColumn() > 0;
		}

		public function insertNewProxy($ip, $port){
			if(false == $this->issetProxy($ip, $port)){
				return $this->pdo->exec("INSERT INTO proxies (ip, port, last_time, created_time, status) VALUES ('". $ip ."','". $port ."','". time() ."','". time() ."','0')");
			}else{
				return false;
			}
		}

		public function updateStatusOfProxy($ip, $port, $status){
			return $this->pdo->exec("UPDATE proxies SET status='". $status ."', last_time='". time() ."' WHERE ip='". $ip ."' AND port='". $port ."'");
		}

		public function getStatusOfProxy($ip, $port){
			if($this->issetProxy($ip, $port)){
				$query[0] = $this->pdo->query("SELECT status FROM proxies WHERE ip='". $ip ."' AND port='". $port ."'");
				$results = $query[0]->fetchAll(PDO::FETCH_ASSOC);
				return $results[0]['status'];
			}

			return false;
		}

	}

?>