<?php 

class UnitData implements IQuery {

	public $Id;
	public $DtServer;
	public $DtDevice;
	public $Command;
	public $Event;
	public $Byte;
	public $Coordinate;
	public $Altitude;
	public $Rfid;
	public $Mode;
	public $Speed;
	public $Time;
	public $Odometer;
	public $Heading;
	public $Picture;
	public $GpsSatellite;
	public $GpsStatus;
	public $GpsAccuracy;
	public $GprsSignal;
	public $GprsStatus;
	public $Reserve;

	public $Di = array();
	public $Do = array();
	public $Ai = array();
	public $Ao = array();
	


	
	public function __construct() {

	}

	public static function select($id) {
		
		$connection = Flight::dbData();

		$tableName = 'data_' . $id;

		try {

			$sql = "SELECT * FROM data_". $id . " ORDER BY dt_device ASC LIMIT 1;";
			$query = $connection->prepare($sql);
			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$unitData = new UnitData();
			$unitData->Id = (int) $row['id'];
			$unitData->DtServer = $row['dt_server'];
			$unitData->DtDevice = $row['dt_device'];
			$unitData->Command = $row['command'];

			$unitData->Event =  (int) $row['event'];
			$unitData->Byte = (int) $row['byte'];
			$unitData->Rfid =  $row['rfid'];
			$unitData->Mode = (int)$row['mode'];
			$unitData->Coordinate =  new Coordinate($row['latitude'], $row['longitude']);
			$unitData->Altitude =  (int)$row['altitude'];
			$unitData->Mode =  $row['mode'];
			$unitData->Speed =  (int)$row['speed'];
			$unitData->Time =  (int)$row['time'];
			$unitData->Odometer = (int)$row['odometer'];
			$unitData->Heading =  (int)$row['heading'];
			$unitData->Picture = $row['picture'];
			$unitData->GpsSatellite =  (int)$row['gps_satellite'];
			$unitData->GpsStatus =  (int)$row['gps_status'];
			$unitData->GpsAccuracy =  (int)$row['gps_accuracy'];
			$unitData->GprsSignal =  (int)$row['gprs_signal'];
			$unitData->GprsStatus =  $row['gprs_status'];
			$unitData->Reserve =  $row['reserve'];


			for($index = 0; $index < 11; $index++) {
				array_push($unitData->Di, (int)$row['di_' . $index]);
				array_push($unitData->Ai, (int)$row['ai_' . $index]);

			}

			for($index = 0; $index < 4; $index++) {
				array_push($unitData->Do,(int)$row['do_' . $index]);
				array_push($unitData->Ao,(int)$row['ao_' . $index]);
			}

			return $unitData;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}

	public static function insert() {

		$connection = Flight::dbMain();
		$dateTime = Flight::dateTime();

		try {

			$unitData = json_decode(file_get_contents("php://input"));

			if ($unitData == null) {
				throw new Exception(json_get_error());
			}
			
			/* Begin Transaction */
			$connection->beginTransaction();

			
			//Query 1 //=================================

			$sql = "
			INSERT INTO unitData 
			(UnitData_imei, UnitData_serial_number, sim_id, UnitData_type_id, company_id, e_status_UnitData_id, UnitData_dt_created)
			VALUES
			(:UnitData_imei, :UnitData_serial_number, :sim_id, :UnitData_type_id, :company_id, :e_status_UnitData_id, :UnitData_dt_created);";


			$query = $connection->prepare($sql);

			$query->bindParam(':UnitData_imei', $unitData->Imei, PDO::PARAM_INT);
			$query->bindParam(':UnitData_serial_number', $unitData->SerialNumber, PDO::PARAM_STR);
			$query->bindParam(':sim_id', $unitData->Sim->Id, PDO::PARAM_INT);
			$query->bindParam(':UnitData_type_id', $unitData->UnitDataType->Id, PDO::PARAM_INT);
			$query->bindParam(':company_id', $unitData->Company->Id, PDO::PARAM_INT);
			$query->bindParam(':e_status_UnitData_id', $unitData->UnitDataStatus->Id, PDO::PARAM_INT);
			$query->bindParam(':UnitData_dt_created',$dateTime, PDO::PARAM_STR);

			$query->execute();

			$result = new Result();
			$result->Status = Result::INSERTED;
			$result->Id = $connection->lastInsertId();
			$result->Message = 'Done';

			//Query 2 //=================================

			$year = date('Y');
			$schema = "app_data_$year";

			// $tableName = "data_id_" .  $result->Id;
			
			$imei = $unitData->Imei;
			$tableName = "data_$imei";


			$sql = "
			CREATE TABLE IF NOT EXISTS `" . $schema ."`.`" . $tableName . "` (
			`id` BIGINT NOT NULL AUTO_INCREMENT COMMENT '',
			`dt_server` TIMESTAMP NULL COMMENT '',
			`dt_device` TIMESTAMP NULL COMMENT '',
			`command` SMALLINT NULL COMMENT '',
			`event` SMALLINT NULL COMMENT '',
			`byte` BIGINT NULL COMMENT '',
			`latitude` DOUBLE NULL COMMENT '',
			`longitude` DOUBLE NULL COMMENT '',
			`altitude` DOUBLE NULL COMMENT '',
			`rfid` BIGINT NULL COMMENT '',
			`mode` TINYINT NULL COMMENT '',
			`speed` SMALLINT NULL COMMENT '',
			`time` BIGINT NULL COMMENT '',
			`odometer` BIGINT NULL COMMENT '',
			`heading` SMALLINT NULL COMMENT '',
			`picture` BIGINT NULL COMMENT '',
			`gps_satellite` SMALLINT NULL COMMENT '',
			`gps_status` SMALLINT NULL COMMENT '',
			`gps_accuracy` SMALLINT NULL COMMENT '',
			`gprs_signal` SMALLINT NULL COMMENT '',
			`gprs_status` VARCHAR(25) NULL COMMENT '',
			`di_0` TINYINT(1) NULL COMMENT '',
			`di_1` TINYINT(1) NULL COMMENT '',
			`di_2` TINYINT(1) NULL COMMENT '',
			`di_3` TINYINT(1) NULL COMMENT '',
			`di_4` TINYINT(1) NULL COMMENT '',
			`di_5` TINYINT(1) NULL COMMENT '',
			`di_6` SMALLINT NULL COMMENT '',
			`di_7` SMALLINT NULL COMMENT '',
			`di_8` SMALLINT NULL COMMENT '',
			`di_9` TINYINT(1) NULL COMMENT '',
			`di_10` TINYINT(1) NULL COMMENT '',
			`do_0` TINYINT(1) NULL COMMENT '',
			`do_1` TINYINT(1) NULL COMMENT '',
			`do_2` TINYINT(1) NULL COMMENT '',
			`do_3` TINYINT(1) NULL COMMENT '',
			`ai_0` SMALLINT NULL COMMENT '',
			`ai_1` SMALLINT NULL COMMENT '',
			`ai_2` SMALLINT NULL COMMENT '',
			`ai_3` SMALLINT NULL COMMENT '',
			`ai_4` SMALLINT NULL COMMENT '',
			`ai_5` SMALLINT NULL COMMENT '',
			`ai_6` SMALLINT NULL COMMENT '',
			`ai_7` SMALLINT NULL COMMENT '',
			`ai_8` SMALLINT NULL COMMENT '',
			`ai_9` SMALLINT NULL COMMENT '',
			`ao_0` SMALLINT NULL COMMENT '',
			`ao_1` SMALLINT NULL COMMENT '',
			`ao_2` SMALLINT NULL COMMENT '',
			`ao_3` SMALLINT NULL COMMENT '',
			PRIMARY KEY (`id`)  COMMENT '')
			ENGINE = InnoDB
			PACK_KEYS = DEFAULT
			KEY_BLOCK_SIZE = 8;";

			$query = $connection->prepare($sql);	

			$query->execute();

			$connection->commit();

			Flight::ok($result);

		} catch (PDOException $pdoException) {
			$connection->rollBack();
			Flight::error($pdoException);
		} catch (Exception $exception) {
			$connection->rollBack();
			Flight::error($exception);
		} finally {
			$connection = null;
		}
	}

	
}

?>