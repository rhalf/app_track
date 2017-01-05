<?php 

class Database {
	public $Username;
	public $Password;
	public $Ip;
	public $Port;
	public $Database;


	/*
	MySQL
	Standard
	Server=myServerAddress;Database=myDataBase;Uid=myUsername;Pwd=myPassword;

	Specifying TCP port
	Server=myServerAddress;Port=1234;Database=myDataBase;Uid=myUsername;Pwd=myPassword;
	The port 3306 is the default MySql port.The value is ignored if Unix socket is used.	
	*/
	public function getConnectionString() {
		$connectionString = "Server=$this->Ip;Port=$this->Port;Database=$this->Database;Uid=$this->Username;Pwd=$this->Password;";
		return $connectionString;
	}

	function __construct($ip,  $port, $database, $username, $password) {
		$this->Username = $username;
		$this->Ip = $ip;
		$this->Database = $database;

		$this->Password = $password;
		$this->Port = $port;
	}
}
?>