# Crawxy - Proxy checker and crawler

## Requeriments
1. PHP 5 or higher
2. MySQL support
3. Cross domains petitions avaliable

## Install
Just run this two MySQL commands:
   
	create database crawxy;
	create table proxies (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, ip CHAR(30) NOT NULL, port CHAR(5) NOT NULL, last_time BIGINT NOT NULL, created_time BIGINT NOT NULL, status INT NOT NULL);

And change the connection to database in bin/database.php:
	
    	class Database{
		function __construct(){
			//Set config of MySQL
			$db['host'] = 'localhost';
			$db['db_name'] = 'crawxy';
			$db['user'] = 'root';
			$db['password'] = '12345678';

## Automate
Configure some simple crons:

	*/30 * * * * php /path/to/crawler.php
    0 1 * * * php /path/to/app.php
    
Or with daemons.

## Retrieve proxies
Use:

	$database = new Database;
    $database->getActiveProxies(-1); /* -1 for all */