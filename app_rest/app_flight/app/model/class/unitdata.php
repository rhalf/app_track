<?php 

class UnitData implements IQuery {

	public $Id;
	public $DateTimeServer;
	public $DateTimeDevice;
	public $Command;
	public $Event;
	public $Byte;
	public $UnitDataType;
	public $Company;
	
	public function __construct() {
	}

	public static function selectAll() {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM UnitData;";
			$query = $connection->prepare($sql);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$UnitData = new UnitData();
				$UnitData->Id = (int) $row['id'];
				$UnitData->Imei = $row['UnitData_imei'];
				$UnitData->DtCreated = $row['UnitData_dt_created'];
				$UnitData->SerialNumber = $row['UnitData_serial_number'];

				$UnitData->Sim = $row['sim_id'] == null ? null : (int) $row['sim_id'];

				$UnitData->UnitDataType = (int) $row['UnitData_type_id'];
				$UnitData->Company = (int) $row['company_id'];
				$UnitData->UnitDataStatus = (int) $row['e_status_UnitData_id'];
				
				array_push($result, $UnitData);
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

	public static function selectByCompany($id) {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM UnitData WHERE company_id = :company;";
			$query = $connection->prepare($sql);
			$query->bindParam(':company',$id, PDO::PARAM_INT);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$UnitData = new UnitData();
				$UnitData->Id = (int) $row['id'];
				$UnitData->Imei = $row['UnitData_imei'];
				$UnitData->DtCreated = $row['UnitData_dt_created'];
				$UnitData->SerialNumber = $row['UnitData_serial_number'];

				$UnitData->Sim = $row['sim_id'] == null ? null : (int) $row['sim_id'];

				$UnitData->UnitDataType = (int) $row['UnitData_type_id'];
				$UnitData->Company = (int) $row['company_id'];
				$UnitData->UnitDataStatus = (int) $row['e_status_UnitData_id'];
				
				array_push($result, $UnitData);
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

			$sql = "SELECT * FROM UnitData WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				Flight::notFound("id not found");
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$UnitData = new UnitData();
			$UnitData->Id = (int) $row['id'];
			$UnitData->Imei = $row['UnitData_imei'];
			$UnitData->DtCreated = $row['UnitData_dt_created'];
			$UnitData->SerialNumber = $row['UnitData_serial_number'];

			$UnitData->Sim = $row['sim_id'] == null ? null : (int) $row['sim_id'];

			$UnitData->UnitDataType = (int) $row['UnitData_type_id'];
			$UnitData->Company = (int) $row['company_id'];
			$UnitData->UnitDataStatus = (int) $row['e_status_UnitData_id'];

			Flight::ok($UnitData);

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
		$dateTime = Flight::dateTime();

		try {

			$UnitData = json_decode(file_get_contents("php://input"));

			if ($UnitData == null) {
				throw new Exception(json_get_error());
			}
			
			/* Begin Transaction */
			$connection->beginTransaction();

			
			//Query 1 //=================================

			$sql = "
			INSERT INTO UnitData 
			(UnitData_imei, UnitData_serial_number, sim_id, UnitData_type_id, company_id, e_status_UnitData_id, UnitData_dt_created)
			VALUES
			(:UnitData_imei, :UnitData_serial_number, :sim_id, :UnitData_type_id, :company_id, :e_status_UnitData_id, :UnitData_dt_created);";


			$query = $connection->prepare($sql);

			$query->bindParam(':UnitData_imei', $UnitData->Imei, PDO::PARAM_INT);
			$query->bindParam(':UnitData_serial_number', $UnitData->SerialNumber, PDO::PARAM_STR);
			$query->bindParam(':sim_id', $UnitData->Sim, PDO::PARAM_INT);
			$query->bindParam(':UnitData_type_id', $UnitData->UnitDataType, PDO::PARAM_INT);
			$query->bindParam(':company_id', $UnitData->Company, PDO::PARAM_INT);
			$query->bindParam(':e_status_UnitData_id', $UnitData->UnitDataStatus, PDO::PARAM_INT);
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
			
			$imei = $UnitData->Imei;
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

	public static function update($id) {

		$connection = Flight::dbMain();

		try {

			$UnitDataNew = json_decode(file_get_contents("php://input"));

			if ($UnitDataNew == null) {
				throw new Exception(json_get_error());
			}


			/* Begin Transaction */
			$connection->beginTransaction();

			/*Query 1 Select UnitData(old) */
			$sql = "SELECT * FROM UnitData WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$UnitDataOld = new UnitData();
			$UnitDataOld->Id = (int) $row['id'];
			$UnitDataOld->Imei = $row['UnitData_imei'];
			$UnitDataOld->DtCreated = $row['UnitData_dt_created'];
			$UnitDataOld->SerialNumber = $row['UnitData_serial_number'];
			$UnitDataOld->Sim = (int) $row['sim_id'];
			$UnitDataOld->UnitDataType = (int) $row['UnitData_type_id'];
			$UnitDataOld->Company = (int) $row['company_id'];
			$UnitDataOld->UnitDataStatus = (int) $row['e_status_UnitData_id'];

			/*Query 2 Update UnitData*/
			$sql = "
			UPDATE UnitData 
			SET 
			UnitData_imei = :UnitData_imei,
			UnitData_dt_created = :UnitData_dt_created, 
			UnitData_serial_number = :UnitData_serial_number,
			sim_id = :sim_id, 
			UnitData_type_id = :UnitData_type_id,
			company_id = :company_id,
			e_status_UnitData_id = :e_status_UnitData_id
			WHERE
			id = :id;";

			$query = $connection->prepare($sql);
			$query->bindParam(':UnitData_imei', $UnitDataNew->Imei, PDO::PARAM_INT);
			$query->bindParam(':UnitData_dt_created', $UnitDataNew->DtCreated, PDO::PARAM_STR);
			$query->bindParam(':UnitData_serial_number', $UnitDataNew->SerialNumber, PDO::PARAM_STR);
			$query->bindParam(':sim_id', $UnitDataNew->Sim, PDO::PARAM_INT);
			$query->bindParam(':UnitData_type_id', $UnitDataNew->UnitDataType, PDO::PARAM_BOOL);
			$query->bindParam(':company_id', $UnitDataNew->Company, PDO::PARAM_INT);
			$query->bindParam(':e_status_UnitData_id', $UnitDataNew->UnitDataStatus, PDO::PARAM_INT);

			
			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();


			/*Query 2 Alter table "data_$imei" name*/
			$year = date('Y');
			$schema = "app_data_$year";

			$imeiOld = $UnitDataOld->Imei;
			$imeiNew = $UnitDataNew->Imei;

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

			/*Query 1 Select UnitData*/
			$sql = "SELECT * FROM UnitData WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$row = $rows[0];

			$UnitData = new UnitData();
			$UnitData->Id = (int) $row['id'];
			$UnitData->Imei = $row['UnitData_imei'];
			$UnitData->DtCreated = $row['UnitData_dt_created'];
			$UnitData->SerialNumber = $row['UnitData_serial_number'];
			$UnitData->Sim = (int) $row['sim_id'];
			$UnitData->UnitDataType = (int) $row['UnitData_type_id'];
			$UnitData->Company = (int) $row['company_id'];
			$UnitData->UnitDataStatus = (int) $row['e_status_UnitData_id'];



			/*Query 2 Delete UnitData*/
			$sql = "
			DELETE FROM UnitData 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);
			$query->bindParam(':id', $id, PDO::PARAM_INT);
			$query->execute();

			/*Query 3 Drop data_UnitData.imei table*/
			$year = date('Y');
			$schema = "app_data_$year";

			$imei = $UnitData->Imei;

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