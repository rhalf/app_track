<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Class definition of gprs.
*/
class Gprs {
	public $signal;
	public $status;
	

	public function __construct($signal, $status) {
		$this->signal = (int) $signal;
		$this->status = (int) $status;
	}

}

?>
