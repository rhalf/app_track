<?php
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class command and supplies the requests such as select, insert, update & delete.
*/
class Command implements IQuery {

	public function __construct() {
	}

	public static function prepare() {
			

		try {

			$command = json_decode(file_get_contents("php://input"));

			if ($command == null) {
				throw new Exception(json_get_error());
			}
			
			$unitImei = $command->vehicle->unit->imei;
			$unitType = $command->vehicle->unit->unitType->name;
			$unitBrand = $command->vehicle->unit->unitType->brand;

			$commandType = $command->type;
			$commandParam = $command->param;

			//unitImei,unitType,unitBrand,commandType,commandParam
			$data = null;
			$data = "$unitImei,$unitType,$unitBrand,$commandType,$commandParam";

			Command::send($data);

			$result = new Result();
			$result->status = Result::INSERTED;
			$result->id = $unitImei ;
			$result->message = 'Done';

			return $result;
		
		} catch (Exception $exception) {
			throw $exception;
		} 
	}


	private static function send($data) {

		// $socket = fsockopen("72.55.132.41", 50000, $errno, $errstr, 30);
		$socket = fsockopen("184.107.175.158", 50000, $errno, $errstr, 30);

		if (!$socket) {
		    throw new Exception("Socket : $errstr ($errno).", 1);
		} else {
		    fwrite($socket, $data);
		    fclose($socket);
		}
	}
}
?>