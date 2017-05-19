<?php
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class coordinate and supplies the requests such as select, insert, update & delete.
*/
class Coordinate {

	public $latitude;
	public $longitude;
	public $altitude;
	public $course;


	public function __construct($latitude, $longitude, $altitude, $course) {
		$this->latitude = (double) $latitude;
		$this->longitude = (double) $longitude;
		$this->altitude = (int) $altitude;
		$this->course = (int) $course;
	}
}

?>