<?php 

class Unit implements IQuery {

	public $Id;
	public $Imei;
	public $DtCreated;
	public $SerialNumber;
	public $Sim;
	public $UnitType;
	public $Company;
	public $UnitData;
	
	public function __construct() {
	}

	public static function selectAll() {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM unit;";
			$query = $connection->prepare($sql);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$unit = new Unit();
				$unit->Id = (int) $row['id'];
				$unit->Imei = $row['unit_imei'];
				$unit->DtCreated = $row['unit_dt_created'];
				$unit->SerialNumber = $row['unit_serial_number'];

				$unit->Sim = Sim::select($row['sim_id']);
				$unit->UnitStatus = UnitStatus::select($row['e_status_unit_id']);
				$unit->UnitType = UnitType::select($row['unit_type_id']);
				$unit->Company = Company::select($row['company_id']);
				$unit->UnitData = UnitData::select($row['unit_imei']);

				array_push($result, $unit);
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

	public static function selectByCompany($id) {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM unit WHERE company_id = :company;";
			$query = $connection->prepare($sql);
			$query->bindParam(':company',$id, PDO::PARAM_INT);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$unit = new Unit();
				$unit->Id = (int) $row['id'];
				$unit->Imei = $row['unit_imei'];
				$unit->DtCreated = $row['unit_dt_created'];
				$unit->SerialNumber = $row['unit_serial_number'];

				$unit->Sim = Sim::select($row['sim_id']);
				$unit->UnitStatus = UnitStatus::select($row['e_status_unit_id']);
				$unit->UnitType = UnitType::select($row['unit_type_id']);
				$unit->Company = Company::select($row['company_id']);
				$unit->UnitData = UnitData::select($row['unit_imei']);
				
				array_push($result, $unit);
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

	public static function select($id) {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM unit WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$unit = new Unit();
			$unit->Id = (int) $row['id'];
			$unit->Imei = $row['unit_imei'];
			$unit->DtCreated = $row['unit_dt_created'];
			$unit->SerialNumber = $row['unit_serial_number'];

			$unit->Sim = Sim::select($row['sim_id']);
			$unit->UnitStatus = UnitStatus::select($row['e_status_unit_id']);
			$unit->UnitType = UnitType::select($row['unit_type_id']);
			$unit->Company = Company::select($row['company_id']);
			$unit->UnitData = UnitData::select($row['unit_imei']);

			return $unit;

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

			$unit = json_decode(file_get_contents("php://input"));

			if ($unit == null) {
				throw new Exception(json_get_error());
			}
			
			/* Begin Transaction */
			$connection->beginTransaction();

			
			//Query 1 //=================================

			$sql = "
			INSERT INTO unit 
			(unit_imei, unit_serial_number, sim_id, unit_type_id, company_id, e_status_unit_id, unit_dt_created)
			VALUES
			(:unit_imei, :unit_serial_number, :sim_id, :unit_type_id, :company_id, :e_status_unit_id, :unit_dt_created);";


			$query = $connection->prepare($sql);

			$query->bindParam(':unit_imei', $unit->Imei, PDO::PARAM_INT);
			$query->bindParam(':unit_serial_number', $unit->SerialNumber, PDO::PARAM_STR);
			$query->bindParam(':sim_id', $unit->Sim->Id, PDO::PARAM_INT);
			$query->bindParam(':unit_type_id', $unit->UnitType->Id, PDO::PARAM_INT);
			$query->bindParam(':company_id', $unit->Company->Id, PDO::PARAM_INT);
			$query->bindParam(':e_status_unit_id', $unit->UnitStatus->Id, PDO::PARAM_INT);
			$query->bindParam(':unit_dt_created',$dateTime, PDO::PARAM_STR);

			$query->execute();

			$result = new Result();
			$result->Status = Result::INSERTED;
			$result->Id = $connection->lastInsertId();
			$result->Message = 'Done';

			//Query 2 //=================================

			$year = date('Y');
			$schema = "app_data_$year";

			// $tableName = "data_id_" .  $result->Id;
			
			$imei = $unit->Imei;
			$tableName = "data_$imei";


			$sql = "
			CREATE TABLE IF NOT EXISTS `" . $schema ."`.`" . $tableName . "` ( 
			`id` BIGINT NOT NULL AUTO_INCREMENT COMMENT '',
			`h_server` DATETIME NULL COMMENT '',
			`h_client` DATETIME NULL COMMENT '',
			`h_command` SMALLINT NULL COMMENT '',
			`h_event` SMALLINT NULL COMMENT '',
			`h_length` SMALLINT NULL COMMENT '',
			`g_latitude` DOUBLE NULL COMMENT '',
			`g_longitude` DOUBLE NULL COMMENT '',
			`g_altitude` SMALLINT NULL COMMENT '',
			`g_course` SMALLINT NULL COMMENT '',
			`g_satellite` SMALLINT NULL COMMENT '',
			`g_status` SMALLINT NULL COMMENT '',
			`g_accuracy` SMALLINT NULL COMMENT '',
			`c_signal` SMALLINT NULL COMMENT '',
			`c_status` VARCHAR(30) NULL COMMENT '',
			`i_speed` SMALLINT NULL COMMENT '',
			`i_runtime` BIGINT NULL COMMENT '',
			`i_odo` BIGINT NULL COMMENT '',
			`i_acc` SMALLINT NULL COMMENT '',
			`i_sos` SMALLINT NULL COMMENT '',
			`i_epc` SMALLINT NULL COMMENT '',
			`i_batt` SMALLINT NULL COMMENT '',
			`i_vcc` SMALLINT NULL COMMENT '',
			`i_accel` SMALLINT NULL COMMENT '',
			`i_decel` SMALLINT NULL COMMENT '',
			`i_tow` SMALLINT NULL COMMENT '',
			`i_motion` SMALLINT NULL COMMENT '',
			`i_fuel` SMALLINT NULL COMMENT '',
			`i_rpm` SMALLINT NULL COMMENT '',
			`i_alarm` SMALLINT NULL COMMENT '',
			`i_mode` SMALLINT NULL COMMENT '',
			`i_pic` VARCHAR(24) NULL COMMENT '',
			`i_ibutton` VARCHAR(24) NULL COMMENT '',
			`i_weight` SMALLINT NULL COMMENT '',
			`i_relay1` SMALLINT NULL COMMENT '',
			`i_relay2` SMALLINT NULL COMMENT '',
			`i_relay3` SMALLINT NULL COMMENT '',
			`i_relay4` SMALLINT NULL COMMENT '',
			PRIMARY KEY (`id`)  COMMENT '')
			ENGINE = InnoDB
			PACK_KEYS = DEFAULT
			KEY_BLOCK_SIZE = 8";

			$query = $connection->prepare($sql);	

			$query->execute();

			$connection->commit();

			$result = new Result();
			$result->Status = Result::INSERTED;
			$result->Message = 'Done';
			$result->Id = $connection->lastInsertId();

			return $result;

		} catch (PDOException $pdoException) {
			$connection->rollBack();
			throw $pdoException;
		} catch (Exception $exception) {
			$connection->rollBack();
			throw $exception;
		} finally {
			$connection = null;
		}
	}

	public static function update($id) {

		$connection = Flight::dbMain();

		try {

			$unitNew = json_decode(file_get_contents("php://input"));

			if ($unitNew == null) {
				throw new Exception(json_get_error());
			}


			/* Begin Transaction */
			$connection->beginTransaction();

			/*Query 1 Select unit(old) */
			$sql = "SELECT * FROM unit WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$unitOld = new Unit();
			$unitOld->Id = (int) $row['id'];
			$unitOld->Imei = $row['unit_imei'];
			$unitOld->DtCreated = $row['unit_dt_created'];
			$unitOld->SerialNumber = $row['unit_serial_number'];
			
			$unitOld->Sim = Sim::select($row['sim_id']);
			$unitOld->UnitStatus = UnitStatus::select($row['e_status_unit_id']);
			$unitOld->UnitType = UnitType::select($row['unit_type_id']);
			$unitOld->Company = Company::select($row['company_id']);

			/*Query 2 Update unit*/
			$sql = "
			UPDATE unit 
			SET 
			unit_imei = :unit_imei,
			unit_dt_created = :unit_dt_created, 
			unit_serial_number = :unit_serial_number,
			sim_id = :sim_id, 
			unit_type_id = :unit_type_id,
			company_id = :company_id,
			e_status_unit_id = :e_status_unit_id
			WHERE
			id = :id;";

			$query = $connection->prepare($sql);
			$query->bindParam(':unit_imei', $unitNew->Imei, PDO::PARAM_INT);
			$query->bindParam(':unit_dt_created', $unitNew->DtCreated, PDO::PARAM_STR);
			$query->bindParam(':unit_serial_number', $unitNew->SerialNumber, PDO::PARAM_STR);
			$query->bindParam(':sim_id', $unitNew->Sim->Id, PDO::PARAM_INT);
			$query->bindParam(':unit_type_id', $unitNew->UnitType->Id, PDO::PARAM_BOOL);
			$query->bindParam(':company_id', $unitNew->Company->Id, PDO::PARAM_INT);
			$query->bindParam(':e_status_unit_id', $unitNew->UnitStatus->Id, PDO::PARAM_INT);

			
			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();


			/*Query 2 Alter table "data_$imei" name*/
			$year = date('Y');
			$schema = "app_data_$year";

			$imeiOld = $unitOld->Imei;
			$imeiNew = $unitNew->Imei;

			$tableNameOld = "data_$imeiOld";
			$tableNameNew = "data_$imeiNew";

			$sql = "
			ALTER TABLE 
			$schema.$tableNameOld
			RENAME TO 
			$schema.$tableNameNew;
			";

			$query = $connection->prepare($sql);
			$query->execute();

			$connection->commit();

			$result = new Result();
			$result->Status = Result::UPDATED;
			$result->Message = 'Done';
			$result->Id = $id;

			return $result;

		} catch (PDOException $pdoException) {
			$connection->rollBack();
			throw $pdoException;
		} catch (Exception $exception) {
			$connection->rollBack();
			throw $exception;
		} finally {
			$connection = null;
		}
	}

	public static function delete($id) {

		$connection = Flight::dbMain();

		try {

			/* Begin Transaction */
			$connection->beginTransaction();

			/*Query 1 Select unit*/
			$sql = "SELECT * FROM unit WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$row = $rows[0];

			$unit = new Unit();
			$unit->Id = (int) $row['id'];
			$unit->Imei = $row['unit_imei'];
			$unit->DtCreated = $row['unit_dt_created'];
			$unit->SerialNumber = $row['unit_serial_number'];
			
			$unit->Sim = Sim::select($row['sim_id']);
			$unit->UnitStatus = UnitStatus::select($row['e_status_unit_id']);
			$unit->UnitType = UnitType::select($row['unit_type_id']);
			$unit->Company = Company::select($row['company_id']);



			/*Query 2 Delete unit*/
			$sql = "
			DELETE FROM unit 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);
			$query->bindParam(':id', $id, PDO::PARAM_INT);
			$query->execute();

			/*Query 3 Drop data_unit.imei table*/
			$year = date('Y');
			$schema = "app_data_$year";

			$imei = $unit->Imei;

			$tableName = "data_$imei";

			$sql = "
			
			DROP TABLE IF EXISTS $schema.$tableName;

			";

			$query = $connection->prepare($sql);
			$query->execute();

			$connection->commit();

			
			$result = new Result();
			$result->Status = Result::DELETED;
			$result->Message = 'Done';
			$result->Id = $id;

			return $result;

		} catch (PDOException $pdoException) {
			$connection->rollBack();
			throw $pdoException;
		} catch (Exception $exception) {
			$connection->rollBack();
			throw $exception;
		} finally {
			$connection = null;
		}
	}
}

?>