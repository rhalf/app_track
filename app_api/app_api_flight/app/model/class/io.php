<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Class definition of io.
*/
class Io {
	public $speed;
	public $runtime;
	public $odo;
	public $acc;
	public $sos;
	public $epc;
	public $batt;
	public $vcc;
	public $accel;
	public $decel;
	public $tow;
	public $motion;
	public $fuel;
	public $rpm;
	public $alarm;
	public $mode;
	public $pic;
	public $ibutton;
	public $weight;
	public $relay1;
	public $relay2;
	public $relay3;
	public $relay4;


	

	public function __construct(
		$speed, $runtime, $odo, $acc, $sos,	$epc,
		$batt, $vcc, $accel, $decel, $tow, $motion,
		$fuel, $rpm, $alarm, $mode,	$pic, $ibutton,
		$weight, $relay1, $relay2, $relay3,	$relay4	) {

		$this->speed = $speed;
		$this->runtime = $runtime;
		$this->odo = $odo;
		$this->acc = $acc;
		$this->sos = $sos;
		$this->epc = $epc;
		$this->batt = $batt;
		$this->vcc = $vcc;
		$this->accel = $accel;
		$this->decel = $decel;
		$this->tow = $tow;
		$this->motion = $motion;
		$this->fuel = $fuel;
		$this->rpm = $rpm;
		$this->alarm = $alarm;
		$this->mode = $mode;
		$this->pic = $pic;
		$this->ibutton = $ibutton;
		$this->weight = $weight;
		$this->relay1 = $relay1;
		$this->relay2 = $relay2;
		$this->relay3 = $relay3;
		$this->relay4 = $relay4;
	}

}

?>
