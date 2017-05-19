<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class unit and supplies the requests such as select, insert, update & delete.
*/
class Unit implements IQuery {

	public $id;
	public $imei;
	public $dtCreated;
	public $dtExpired;
	public $dtSubscribed;
	public $serial;
	public $sim;
	public $unitType;
	public $company;
	public $unitData;
	
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
				$unit->id = (int) $row['id'];
				$unit->imei = $row['unit_imei'];
				$unit->dtCreated = $row['unit_dt_created'];
				$unit->dtExpired = $row['unit_dt_expired'];
				$unit->dtSubscribed = $row['unit_dt_subscribed'];
				$unit->serial = $row['unit_serial_number'];

				$unit->sim = Sim::select($row['sim_id']);
				$unit->unitStatus = UnitStatus::select($row['e_status_unit_id']);
				$unit->unitType = UnitType::select($row['unit_type_id']);
				$unit->company = Company::select($row['company_id']);
				$unit->unitData = UnitData::select($unit->imei, $unit->company);

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
				$unit->id = (int) $row['id'];
				$unit->imei = $row['unit_imei'];

				$unit->dtCreated = $row['unit_dt_created'];
				$unit->dtExpired = $row['unit_dt_expired'];
				$unit->dtSubscribed = $row['unit_dt_subscribed'];

				$unit->serial = $row['unit_serial_number'];

				$unit->sim = Sim::select($row['sim_id']);
				$unit->unitStatus = UnitStatus::select($row['e_status_unit_id']);
				$unit->unitType = UnitType::select($row['unit_type_id']);
				$unit->company = Company::select($row['company_id']);
				$unit->unitData = UnitData::select($unit->imei, $unit->company);
				
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
			$unit->id = (int) $row['id'];
			$unit->imei = $row['unit_imei'];
			
			$unit->dtCreated = $row['unit_dt_created'];
			$unit->dtExpired = $row['unit_dt_expired'];
			$unit->dtSubscribed = $row['unit_dt_subscribed'];

			$unit->serial = $row['unit_serial_number'];

			$unit->sim = Sim::select($row['sim_id']);
			$unit->unitStatus = UnitStatus::select($row['e_status_unit_id']);
			$unit->unitType = UnitType::select($row['unit_type_id']);
			$unit->company = Company::select($row['company_id']);
			$unit->unitData = UnitData::select($unit->imei, $unit->company);

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
			(unit_imei, unit_serial_number, sim_id, unit_type_id, company_id, e_status_unit_id, unit_dt_created, unit_dt_subscribed, unit_dt_expired)
			VALUES
			(:unit_imei, :unit_serial_number, :sim_id, :unit_type_id, :company_id, :e_status_unit_id, :unit_dt_created, :unit_dt_subscribed, :unit_dt_expired);";


			$query = $connection->prepare($sql);

			$query->bindParam(':unit_imei', $unit->imei, PDO::PARAM_INT);
			$query->bindParam(':unit_serial_number', $unit->serial, PDO::PARAM_STR);
			$query->bindParam(':sim_id', $unit->sim->id, PDO::PARAM_INT);
			$query->bindParam(':unit_type_id', $unit->unitType->id, PDO::PARAM_INT);
			$query->bindParam(':company_id', $unit->company->id, PDO::PARAM_INT);
			$query->bindParam(':e_status_unit_id', $unit->unitStatus->id, PDO::PARAM_INT);

			$query->bindParam(':unit_dt_created',$dateTime, PDO::PARAM_STR);
			$query->bindParam(':unit_dt_subscribed',$unit->dtSubscribed, PDO::PARAM_STR);
			$query->bindParam(':unit_dt_expired',$unit->dtExpired, PDO::PARAM_STR);

			$query->execute();

			$result = new Result();
			$result->status = Result::INSERTED;
			$result->id = $connection->lastInsertid();
			$result->message = 'Done';

			//Query 2 //=================================

			$year = date('Y');
			$schema = "app_data_$year";

			// $tableName = "data_id_" .  $result->id;
			
			$imei = $unit->imei;
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
			$result->status = Result::INSERTED;
			$result->message = 'Done';
			$result->id = $connection->lastInsertid();

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
			$unitOld->id = (int) $row['id'];
			$unitOld->imei = $row['unit_imei'];
			$unitOld->serial = $row['unit_serial_number'];

			$unitOld->dtCreated = $row['unit_dt_created'];
			$unitOld->dtSubscribed = $row['unit_dt_subscribed'];
			$unitOld->dtExpired = $row['unit_dt_expired'];

			
			$unitOld->sim = Sim::select($row['sim_id']);
			$unitOld->unitStatus = UnitStatus::select($row['e_status_unit_id']);
			$unitOld->unitType = UnitType::select($row['unit_type_id']);
			$unitOld->company = Company::select($row['company_id']);

			/*Query 2 Update unit*/
			$sql = "
			UPDATE unit 
			SET 
			unit_imei = :unit_imei,
			unit_serial_number = :unit_serial_number,

			unit_dt_created = :unit_dt_created, 
			unit_dt_subscribed = :unit_dt_subscribed, 
			unit_dt_expired = :unit_dt_expired, 

			sim_id = :sim_id, 
			unit_type_id = :unit_type_id,
			company_id = :company_id,
			e_status_unit_id = :e_status_unit_id
			WHERE
			id = :id;";

			$query = $connection->prepare($sql);
			$query->bindParam(':unit_imei', $unitNew->imei, PDO::PARAM_INT);
			$query->bindParam(':unit_serial_number', $unitNew->serial, PDO::PARAM_STR);
			
			$query->bindParam(':unit_dt_created', $unitNew->dtCreated, PDO::PARAM_STR);
			$query->bindParam(':unit_dt_expired',$unitNew->dtExpired, PDO::PARAM_STR);
			$query->bindParam(':unit_dt_subscribed',$unitNew->dtSubscribed, PDO::PARAM_STR);

			$query->bindParam(':sim_id', $unitNew->sim->id, PDO::PARAM_INT);
			$query->bindParam(':unit_type_id', $unitNew->unitType->id, PDO::PARAM_BOOL);
			$query->bindParam(':company_id', $unitNew->company->id, PDO::PARAM_INT);
			$query->bindParam(':e_status_unit_id', $unitNew->unitStatus->id, PDO::PARAM_INT);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();


			/*Query 2 Alter table "data_$imei" name*/
			$year = date('Y');
			$schema = "app_data_$year";

			$imeiOld = $unitOld->imei;
			$imeiNew = $unitNew->imei;

			if (strcmp($imeiOld,$imeiNew) != 0) {
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
			}

			$connection->commit();

			$result = new Result();
			$result->status = Result::UPDATED;
			$result->message = 'Done';
			$result->id = $id;

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
			$unit->id = (int) $row['id'];
			$unit->imei = $row['unit_imei'];
			$unit->dtCreated = $row['unit_dt_created'];
			$unit->serial = $row['unit_serial_number'];
			
			$unit->sim = Sim::select($row['sim_id']);
			$unit->unitStatus = UnitStatus::select($row['e_status_unit_id']);
			$unit->unitType = UnitType::select($row['unit_type_id']);
			$unit->company = Company::select($row['company_id']);



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

			$imei = $unit->imei;

			$tableName = "data_$imei";

			$sql = "
			
			DROP TABLE IF EXISTS $schema.$tableName;

			";

			$query = $connection->prepare($sql);
			$query->execute();

			$connection->commit();

			
			$result = new Result();
			$result->status = Result::DELETED;
			$result->message = 'Done';
			$result->id = $id;

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