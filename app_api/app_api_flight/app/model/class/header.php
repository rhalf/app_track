<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Class definition of header.
*/
class Header {
	public $dtServer;
	public $dtClient;
	public $command;
	public $event;
	public $length;
	

	public function __construct($dtServer, $dtClient, $command, $event, $length) {
		$this->dtServer = $dtServer;
		$this->dtClient = $dtClient;
		$this->command = $command;
		$this->event = $event;	
		$this->length = $length;
	}

}

?>
