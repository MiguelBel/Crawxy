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
			$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
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

		public function getProxiesByStatus($status, $number){
			if($status == '-1'){
				$status = '0 OR status=1 OR status=2';
			}

			if($number == '-1'){
				$number = 999999999;
			}
			
			$query[0] = $this->pdo->query("SELECT * FROM proxies WHERE status=$status LIMIT $number");
			$results = $query[0]->fetchAll(PDO::FETCH_ASSOC);
			return $results;			
		}

		public function updateMassProxies($status, $number){

			foreach($this->getProxiesByStatus($status, $number) as $k => $v){
				$test = new Test($v['ip'], $v['port']);
				$test->updateProxy();
			}
		}

		public function getActiveProxies($number){
			$query[0] = $this->pdo->query("SELECT * FROM proxies WHERE status=1  ORDER BY RAND() LIMIT $number");
			$results = $query[0]->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		}

	}

?>