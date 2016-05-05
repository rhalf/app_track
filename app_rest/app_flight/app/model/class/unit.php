<?php 

class Unit implements IQuery {

	public $Id;
	public $Imei;
	public $DtCreated;
	public $SerialNumber;
	public $DataSize;
	public $UnitSim;
	public $UnitType;
	public $Company;
	
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
				$unit->DataSize = $row['unit_data_size'];
				$unit->UnitSim = (int) $row['sim_id'];
				$unit->UnitType = (int) $row['unit_type_id'];
				$unit->Company = (int) $row['company_id'];

				
				array_push($result, $unit);
			}

			Flight::ok($result);

		} catch (PDOException $pdoException) {
			Flight::error($pdoException);
		} catch (Exception $exception) {
			Flight::error($exception);
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
				Flight::notFound("id not found");
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$unit = new Unit();
			$unit->Id = (int) $row['id'];
			$unit->Imei = $row['unit_imei'];
			$unit->DtCreated = $row['unit_dt_created'];
			$unit->SerialNumber = $row['unit_serial_number'];
			$unit->DataSize = $row['unit_data_size'];
			$unit->UnitSim = (int) $row['sim_id'];
			$unit->UnitType = (int) $row['unit_type_id'];
			$unit->Company = (int) $row['company_id'];

			Flight::ok($unit);

		} catch (PDOException $pdoException) {
			Flight::error($pdoException);
		} catch (Exception $exception) {
			Flight::error($exception);
		} finally {
			$connection = null;
		}
	}

	public static function insert() {

		$connection = Flight::dbMain();

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
			(unit_imei, unit_dt_created, unit_serial_number, unit_data_size, sim_id, unit_type_id, company_id)
			VALUES
			(:unit_imei, :unit_dt_created, :unit_serial_number, :unit_data_size, :sim_id, :unit_type_id, :company_id);";


			$query = $connection->prepare($sql);

			$query->bindParam(':unit_imei', $unit->Imei, PDO::PARAM_INT);
			$query->bindParam(':unit_dt_created', $unit->DtCreated, PDO::PARAM_STR);
			$query->bindParam(':unit_serial_number', $unit->SerialNumber, PDO::PARAM_STR);
			$query->bindParam(':unit_data_size', $unit->DataSize, PDO::PARAM_INT);
			$query->bindParam(':sim_id', $unit->UnitSim, PDO::PARAM_INT);
			$query->bindParam(':unit_type_id', $unit->UnitType, PDO::PARAM_INT);
			$query->bindParam(':company_id', $unit->UnitType, PDO::PARAM_INT);

			
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
			`data_datetime` DATETIME NULL COMMENT '',
			`data_command` SMALLINT NULL COMMENT '',
			`data_event` SMALLINT NULL COMMENT '',
			`data_res1` TINYINT NULL COMMENT '',
			`data_latitude` DOUBLE NULL COMMENT '',
			`data_longitude` DOUBLE NULL COMMENT '',
			`data_altitude` DOUBLE NULL COMMENT '',
			`data_rfid` BIGINT NULL COMMENT '',
			`data_mode` TINYINT NULL COMMENT '',
			`data_speed` SMALLINT NULL COMMENT '',
			`data_time` BIGINT NULL COMMENT '',
			`data_odometer` BIGINT NULL COMMENT '',
			`data_heading` SMALLINT NULL COMMENT '',
			`data_picture` BIGINT NULL COMMENT '',
			`data_gps_satellite` SMALLINT NULL COMMENT '',
			`data_gps_status` SMALLINT NULL COMMENT '',
			`data_gps_accuracy` SMALLINT NULL COMMENT '',
			`data_gprs_signal` SMALLINT NULL COMMENT '',
			`data_gprs_status` VARCHAR(25) NULL COMMENT '',
			`data_di_0` TINYINT(1) NULL COMMENT '',
			`data_di_1` TINYINT(1) NULL COMMENT '',
			`data_di_2` TINYINT(1) NULL COMMENT '',
			`data_di_3` TINYINT(1) NULL COMMENT '',
			`data_di_4` TINYINT(1) NULL COMMENT '',
			`data_di_5` TINYINT(1) NULL COMMENT '',
			`data_di_6` SMALLINT NULL COMMENT '',
			`data_di_7` SMALLINT NULL COMMENT '',
			`data_di_8` SMALLINT NULL COMMENT '',
			`data_di_9` TINYINT(1) NULL COMMENT '',
			`data_di_10` TINYINT(1) NULL COMMENT '',
			`data_do_0` TINYINT(1) NOT NULL COMMENT '',
			`data_do_1` TINYINT(1) NULL COMMENT '',
			`data_do_2` TINYINT(1) NULL COMMENT '',
			`data_do_3` TINYINT(1) NULL COMMENT '',
			`data_ai_0` SMALLINT NULL COMMENT '',
			`data_ai_1` SMALLINT NULL COMMENT '',
			`data_ai_2` SMALLINT NULL COMMENT '',
			`data_ai_3` SMALLINT NULL COMMENT '',
			`data_ai_4` SMALLINT NULL COMMENT '',
			`data_ai_5` SMALLINT NULL COMMENT '',
			`data_ai_6` SMALLINT NULL COMMENT '',
			`data_ai_7` SMALLINT NULL COMMENT '',
			`data_ai_8` SMALLINT NULL COMMENT '',
			`data_ai_9` SMALLINT NULL COMMENT '',
			`data_ao_0` SMALLINT NULL COMMENT '',
			`data_ao_1` SMALLINT NULL COMMENT '',
			`data_ao_2` SMALLINT NULL COMMENT '',
			`data_ao_3` SMALLINT NULL COMMENT '',
			PRIMARY KEY (`id`, `data_do_0`)  COMMENT '')
			ENGINE = InnoDB
			PACK_KEYS = DEFAULT
			KEY_BLOCK_SIZE = 8
			";

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
			$unitOld->DataSize = $row['unit_data_size'];
			$unitOld->UnitSim = (int) $row['sim_id'];
			$unitOld->UnitType = (int) $row['unit_type_id'];
			$unitOld->Company = (int) $row['company_id'];


			/*Query 2 Update unit*/
			$sql = "
			UPDATE unit 
			SET 
			unit_imei = :unit_imei,
			unit_dt_created = :unit_dt_created, 
			unit_serial_number = :unit_serial_number,
			unit_data_size = :unit_data_size,
			sim_id = :sim_id, 
			unit_type_id = :unit_type_id,
			company_id = :company_id
			WHERE
			id = :id;";

			$query = $connection->prepare($sql);
			$query->bindParam(':unit_imei', $unitNew->Imei, PDO::PARAM_INT);
			$query->bindParam(':unit_dt_created', $unitNew->DtCreated, PDO::PARAM_STR);
			$query->bindParam(':unit_serial_number', $unitNew->SerialNumber, PDO::PARAM_STR);
			$query->bindParam(':unit_data_size', $unitNew->DataSize, PDO::PARAM_STR);
			$query->bindParam(':sim_id', $unitNew->UnitSim, PDO::PARAM_INT);
			$query->bindParam(':unit_type_id', $unitNew->UnitType, PDO::PARAM_BOOL);
			$query->bindParam(':company_id', $unitNew->UnitType, PDO::PARAM_INT);
			
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
			$unit->DataSize = $row['unit_data_size'];
			$unit->UnitSim = (int) $row['sim_id'];
			$unit->UnitType = (int) $row['unit_type_id'];
			$unit->Company = (int) $row['company_id'];

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