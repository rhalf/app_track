<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class database and generate connection string.
*/
class Database {
	public $username;
	public $password;
	public $ip;
	public $port;
	public $database;


	/*
	MySQL
	Standard
	Server=myServerAddress;database=myDataBase;Uid=myusername;Pwd=mypassword;

	Specifying TCP port
	Server=myServerAddress;port=1234;database=myDataBase;Uid=myusername;Pwd=mypassword;
	The port 3306 is the default MySql port.The value is ignored if Unix socket is used.	
	*/
	public function getConnectionString() {
		$connectionString = "Server=$this->ip;Port=$this->port;database=$this->database;Uid=$this->username;Pwd=$this->password;";
		return $connectionString;
	}

	function __construct($ip,  $port, $database, $username, $password) {
		$this->username = $username;
		$this->ip = $ip;
		$this->database = $database;

		$this->password = $password;
		$this->port = $port;
	}
}
?>