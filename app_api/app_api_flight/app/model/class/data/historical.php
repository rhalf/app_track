<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class historical and generates unitData from an exact range of time.
*/
class Historical {


	public function __construct() {
	}


	public static function generate($param) {

		$connection = Flight::dbData();

		$vehicle = $param->vehicle;
		$dateFrom = $param->dateFrom;
		$dateTo = $param->dateTo;		
		$imei = $param->vehicle->unit->imei;

		$geofences = Geofence::selectByCompany($param->vehicle->company->id);
		$areas = Area::selectAll();

		try {
			$sql = "SELECT * FROM data_$imei WHERE data_$imei.h_client >= :dateFrom AND data_$imei.h_client <= :dateTo ORDER BY  data_$imei.h_client ASC;";
			$query = $connection->prepare($sql);
			$query->bindParam(':dateFrom', $dateFrom , PDO::PARAM_STR);
			$query->bindParam(':dateTo', $dateTo , PDO::PARAM_STR);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	

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

				$unitData->geofence = Geofence::selectByUnit($geofences, $unitData);

				$unitData->area = Area::selectByUnitData($areas, $unitData);

				array_push($result, $unitData);
			}

			return $result;

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