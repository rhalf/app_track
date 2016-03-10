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
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

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
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {

			if (!isset($data['Object'])) {
				throw new Exception("Input object is not set.");
			}

			$unit = json_decode($data['Object']);
			if ($unit == null) {
				throw new Exception(json_get_error());
			}
			
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
	public static function onUpdate(Url $url, $data) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

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
		$database = Flight::get('database');
		
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {
			
			if (empty($url->Id)) {
				throw new Exception("Input id is empty");
			}

			$sql = "
			DELETE FROM unit 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);

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
}

?>