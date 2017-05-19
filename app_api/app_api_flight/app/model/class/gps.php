<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Class definition of gps.
*/
class Gps {
	public $coordinate;
	public $satellite;
	public $status;
	public $accuracy;
	

	public function __construct($coordinate, $satellite,$status, $accuracy) {
		$this->coordinate = $coordinate;
		$this->satellite = (int) $satellite;
		$this->status = (int) $status;
		$this->accuracy = (int) $accuracy;
	}

}

?>
