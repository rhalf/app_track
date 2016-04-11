<?php 

class Unit implements IQuery {

	public $Id;
	public $Imei;
	public $DtCreated;
	public $SerialNumber;
	public $DataSize;
	public $UnitSim;
	public $UnitType;
	
	public function __construct() {
	}

	public static function onSelect(Url $url, $data) {
		
		$connection = Flight::dbMain();

		try {

			if (!empty($url->Id)) {
				$sql = "SELECT * FROM unit WHERE id = :id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':id',$url->Id, PDO::PARAM_INT);
			} else if (isset($data['imei'])) {
				$sql = "SELECT * FROM unit WHERE unit_imei LIKE :imei;";
				$query = $connection->prepare($sql);
				$query->bindParam(':imei',$data['imei'], PDO::PARAM_STR);
			} else {
				$sql = "SELECT * FROM unit;";
				$query = $connection->prepare($sql);
			}

			$query->execute();

			$result = new Result();
			$result->Item = $query->rowCount();
			$result->Object = array();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			foreach ($rows as $row) {	
				$unit = new Unit();
				$unit->Id = (int) $row['id'];
				$unit->Imei = (int)$row['unit_imei'];
				$unit->DtCreated = $row['unit_dt_created'];
				$unit->SerialNumber = $row['unit_serial_number'];
				$unit->DataSize = $row['unit_data_size'];
				$unit->UnitSim = (int) $row['sim_id'];
				$unit->UnitType = (int) $row['unit_type_id'];
				
				array_push($result->Object, $unit);
			}

			$result->Status = Result::SUCCESS;
			$result->Message = 'Done.';

		} catch (PDOException $pdoException) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $pdoException->getMessage();
		} catch (Exception $exception) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $exception->getMessage();
		}

		$connection = null;

		return $result;
	}
	public static function onInsert(Url $url, $data) {
		
		$connection = Flight::dbMain();

		try {

			if (!isset($data['Object'])) {
				throw new Exception("Input object is not set.");
			}

			$unit = json_decode($data['Object']);
			if ($unit == null) {
				throw new Exception(json_get_error());
			}
			
			/* Begin Transaction */
			$connection->beginTransaction();

			//Query 1
			$sql = "
			INSERT INTO unit 
			(unit_imei, unit_dt_created, unit_serial_number, unit_data_size, sim_id, unit_type_id)
			VALUES
			(:unit_imei, :unit_dt_created, :unit_serial_number, :unit_data_size, :sim_id, :unit_type_id);";


			$query = $connection->prepare($sql);

			$query->bindParam(':unit_imei', $unit->Imei, PDO::PARAM_INT);
			$query->bindParam(':unit_dt_created', $unit->DtCreated, PDO::PARAM_STR);
			$query->bindParam(':unit_serial_number', $unit->SerialNumber, PDO::PARAM_STR);
			$query->bindParam(':unit_data_size', $unit->DataSize, PDO::PARAM_INT);
			$query->bindParam(':sim_id', $unit->UnitSim, PDO::PARAM_INT);
			$query->bindParam(':unit_type_id', $unit->UnitType, PDO::PARAM_INT);
			
			$query->execute();

			//Query 2
			$year = date('Y');
			$schema = "app_data_$year";

			$unitImei =  $unit->Imei;
			$tableName = "data_$unitImei";

			$sql = "
			CREATE TABLE IF NOT EXISTS `" . $schema ."`.`" . $tableName . "` (
			`id` BIGINT NOT NULL AUTO_INCREMENT COMMENT '',
			`data_dt_server` DATETIME NULL COMMENT '',
			`data_dt_client` DATETIME NULL COMMENT '',
			`data_command` SMALLINT NULL COMMENT '',
			`data_event` SMALLINT NULL COMMENT '',
			`data_gps_satellite` SMALLINT NULL COMMENT '',
			`data_gps_status` SMALLINT NULL COMMENT '',
			`data_gprs_signal` SMALLINT NULL COMMENT '',
			`data_gprs_status` VARCHAR(25) NULL COMMENT '',
			`data_speed` SMALLINT NULL COMMENT '',
			`data_altitude` DOUBLE NULL COMMENT '',
			`data_latitude` DOUBLE NULL COMMENT '',
			`data_longitude` DOUBLE NULL COMMENT '',
			`data_accuracy_h` FLOAT NULL COMMENT '',
			`data_accuracy_v` FLOAT NULL COMMENT '',
			`data_heading` SMALLINT NULL COMMENT '',
			`data_odometer` BIGINT NULL COMMENT '',
			`data_runningtime` BIGINT NULL COMMENT '',
			`data_sleepmode` SMALLINT NULL COMMENT '',
			`data_res1` INT NULL COMMENT '',
			`data_rfid` BIGINT NULL COMMENT '',
			`data_camera` BIGINT NULL COMMENT '',
			`data_digital_io` BIGINT NULL COMMENT '',
			`data_analog_io` VARCHAR(80) NULL COMMENT '',
			PRIMARY KEY (`id`)  COMMENT '')
			ENGINE = InnoDB
			PACK_KEYS = DEFAULT;
			";

			$query = $connection->prepare($sql);	

			$query->execute();

			$connection->commit();

			$result = new Result();
			$result->Status = Result::SUCCESS;
			$result->Item = $query->rowCount();
			$result->Message = 'Done.';

		} catch (PDOException $pdoException) {
			
			$connection->rollBack();

			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $pdoException->getMessage();
		} catch (Exception $exception) {

			$connection->rollBack();

			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $exception->getMessage();
		}

		$connection = null;

		return $result;
	}
	public static function onUpdate(Url $url, $data) {
		
		$connection = Flight::dbMain();

		try {
			if (empty($url->Id)) {
				throw new Exception("Input id is empty.");
			}

			if (!isset($data['Object'])) {
				throw new Exception("Input object is not set.");
			}

			$unit = json_decode($data['Object']);
			if ($unit == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE unit 
			SET 
			unit_imei = :unit_imei,
			unit_dt_created = :unit_dt_created, 
			unit_serial_number = :unit_serial_number,
			unit_data_size = :unit_data_size,
			sim_id = :sim_id, 
			unit_type_id = :unit_type_id
			WHERE
			id = :id;";

			$query = $connection->prepare($sql);
			$query->bindParam(':unit_imei', $unit->Imei, PDO::PARAM_STR);
			$query->bindParam(':unit_dt_created', $unit->DtCreated, PDO::PARAM_STR);
			$query->bindParam(':unit_serial_number', $unit->SerialNumber, PDO::PARAM_STR);
			$query->bindParam(':unit_data_size', $unit->DataSize, PDO::PARAM_STR);
			$query->bindParam(':sim_id', $unit->UnitSim, PDO::PARAM_INT);
			$query->bindParam(':unit_type_id', $unit->UnitType, PDO::PARAM_BOOL);
			$query->bindParam(':id', $url->Id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::SUCCESS;
			$result->Item = $query->rowCount();
			$result->Message = 'Done.';

		} catch (PDOException $pdoException) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $pdoException->getMessage();
		} catch (Exception $exception) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $exception->getMessage();
		}

		$connection = null;
		return $result;
	}
	public static function onDelete(Url $url, $data) {
		
		$connection = Flight::dbMain();

		try {
			
			if (empty($url->Id)) {
				throw new Exception("Input id is empty");
			}

			/* Begin Transaction */
			$connection->beginTransaction();


			/*Query 1 Select unit*/
			$sql = "SELECT * FROM unit WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$url->Id, PDO::PARAM_INT);
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$row = $rows[0];

			$unit = new Unit();
			$unit->Id = (int) $row['id'];
			$unit->Imei = (int)$row['unit_imei'];
			$unit->DtCreated = $row['unit_dt_created'];
			$unit->SerialNumber = $row['unit_serial_number'];
			$unit->DataSize = $row['unit_data_size'];
			$unit->UnitSim = (int) $row['sim_id'];
			$unit->UnitType = (int) $row['unit_type_id'];


			/*Query 2 Delete unit*/
			$sql = "
			DELETE FROM unit 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);
			$query->bindParam(':id', $url->Id, PDO::PARAM_INT);
			$query->execute();

			/*Query 3 Drop data_unit.imei table*/
			$year = date('Y');
			$schema = "app_data_$year";

			$unitImei = $unit->Imei;
			$tableName = "data_$unitImei";

			$sql = "
			
			DROP TABLE IF EXISTS $schema.$tableName;

			";

			$query = $connection->prepare($sql);
			$query->execute();

			$connection->commit();

			$result = new Result();
			$result->Status = Result::SUCCESS;
			$result->Item = 1;
			$result->Message = 'Done.';

		} catch (PDOException $pdoException) {
			
			$connection->rollBack();
			
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $pdoException->getMessage();
		} catch (Exception $exception) {

			$connection->rollBack();

			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $exception->getMessage();
		}

		$connection = null;
		return $result;
	}
}

?>