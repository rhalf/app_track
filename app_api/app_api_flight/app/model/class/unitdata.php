<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class unitData and supplies the requests such as select, insert, update & delete.
*/
class UnitData implements IQuery {

	public $id;
	public $header;
	public $gps;
	public $gprs;
	public $io;
	public $geofence;
	public $area;
	
	
	public function __construct() {

	}

	public static function select($imei, $company) {
		
		$connection = Flight::dbData();


		//$geofences = Geofence::selectByCompany($company->id);
		//$areas = Area::selectAll();

		//$$R148,865734029500608,AAA,35,25.261175,51.492953,151204083437,V,0,31,0,0,0.0,0,92921,2340711,427|2|008E|53C1,0421,0006|0000|0000|0A6E|03BD,00000001,*D0\r\n
		$tableName = 'data_' . $imei;

		try {

			$sql = "SELECT * FROM ". $tableName . " ORDER BY h_client DESC LIMIT 1;";

			$query = $connection->prepare($sql);
			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$unitData = new UnitData();
			$unitData->id = (int) $row['id'];
			$unitData->header = new Header(
				$row['h_server'],
				$row['h_client'],
				$row['h_command'],
				$row['h_event'],
				$row['h_length']);

			$unitData->gps =  new Gps(
				new Coordinate(
					$row['g_latitude'],
					$row['g_longitude'],
					$row['g_altitude'],
					$row['g_course']),
				$row['g_satellite'],
				$row['g_status'],
				$row['g_accuracy']);

			$unitData->gprs =  new Gprs(
				$row['c_signal'],
				$row['c_status']);
			
			$unitData->io = new Io(
				$row['i_speed'],
				$row['i_runtime'],	
				$row['i_odo'],
				$row['i_acc'],
				$row['i_sos'],
				$row['i_epc'],
				$row['i_batt'],
				$row['i_vcc'],
				$row['i_accel'],
				$row['i_decel'],
				$row['i_tow'],
				$row['i_motion'],
				$row['i_fuel'],
				$row['i_rpm'],
				$row['i_alarm'],
				$row['i_mode'],
				$row['i_pic'],
				$row['i_ibutton'],
				$row['i_weight'],
				$row['i_relay1'],
				$row['i_relay2'],
				$row['i_relay3'],
				$row['i_relay4']);

				//$unitData->geofence = Geofence::selectByUnit($geofences, $unitData);

				//$unitData->area = Area::selectByUnitData($areas, $unitData);

			return $unitData;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}
}

?>

