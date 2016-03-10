<?php 

class Driver implements IQuery {

	public $Id;
	public $DriverId;
	public $NameFirst;
	public $NameMiddle;
	public $NameLast;
	public $Info;
	public $Rfid;
	public $Company;
	public $Status;


	public function __construct() {
	}

	public static function onSelect(Url $url, $data) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {
			if (!empty($url->Id)) {
				$sql = "SELECT * FROM driver WHERE id = :id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':id',$url->Id, PDO::PARAM_INT);
			} else if (isset($data['name'])) {
				$sql = "SELECT * FROM driver WHERE driver_name_f LIKE :name OR  driver_name_m LIKE :name OR driver_name_l LIKE :name ;";
				$query = $connection->prepare($sql);
				$query->bindParam(':name',$data['name'], PDO::PARAM_STR);
			} else {
				$sql = "SELECT * FROM driver;";
				$query = $connection->prepare($sql);
			}

			$query->execute();

			$result = new Result();
			$result->Item = $query->rowCount();
			$result->Object = array();


			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			foreach ($rows as $row) {	
				$driver = new Driver();
				$driver->Id = (int) $row['id'];
				$driver->DriverId = $row['driver_id'];
				$driver->NameFirst = $row['driver_name_f'];
				$driver->NameMiddle = $row['driver_name_m'];
				$driver->NameLast = $row['driver_name_l'];
				$driver->Rfid = (int) $row['driver_id'];
				$driver->Status = (int) $row['e_status_id'];
				$driver->Company = (int) $row['company_id'];
				$driver->Info = (int) $row['info_id'];

				array_push($result->Object, $driver);
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

			$driver = json_decode($data['Object']);
			if ($driver == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO driver 
			(driver_id, driver_name_f, driver_name_m, driver_name_l, driver_rfid, e_status_id, company_id, info_id)
			VALUES
			(:driver_id, :driver_name_f, :driver_name_m, :driver_name_l, :driver_rfid, :e_status_id, :company_id, :info_id);";


			$query = $connection->prepare($sql);

			$query->bindParam(':driver_id', $driver->DriverId, PDO::PARAM_STR);
			$query->bindParam(':driver_name_f', $driver->NameFirst, PDO::PARAM_STR);
			$query->bindParam(':driver_name_m', $driver->NameMiddle, PDO::PARAM_STR);
			$query->bindParam(':driver_name_l', $driver->NameLast, PDO::PARAM_STR);
			$query->bindParam(':driver_rfid', $driver->Rfid, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $driver->Status, PDO::PARAM_INT);
			$query->bindParam(':company_id', $driver->Company, PDO::PARAM_INT);
			$query->bindParam(':info_id', $driver->Info, PDO::PARAM_INT);

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

		//$connection->beginTransaction();
		try {
			if (empty($url->Id)) {
				throw new Exception("Input id is empty.");
			}

			if (!isset($data['Object'])) {
				throw new Exception("Input object is not set.");
			}

			$driver = json_decode($data['Object']);
			if ($driver == null) {
				throw new Exception(json_get_error());
			}
			$sql = "
			UPDATE driver 
			SET
			driver_id = :driver_id,
			driver_name_f = :driver_name_f,
			driver_name_m = :driver_name_m,
			driver_name_l = :driver_name_l,
			driver_rfid = :driver_rfid,
			e_status_id = :e_status_id,
			company_id = :company_id,
			info_id = :info_id

			WHERE
			id = :id;";


			$query = $connection->prepare($sql);

			$query->bindParam(':driver_id', $driver->DriverId, PDO::PARAM_STR);
			$query->bindParam(':driver_name_f', $driver->NameFirst, PDO::PARAM_STR);
			$query->bindParam(':driver_name_m', $driver->NameMiddle, PDO::PARAM_STR);
			$query->bindParam(':driver_name_l', $driver->NameLast, PDO::PARAM_STR);
			$query->bindParam(':driver_rfid', $driver->Rfid, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $driver->Status, PDO::PARAM_INT);
			$query->bindParam(':company_id', $driver->Company, PDO::PARAM_INT);
			$query->bindParam(':info_id', $driver->Info, PDO::PARAM_INT);

			$query->bindParam(':id', $url->Id, PDO::PARAM_INT);

			$query->execute();

			//$connection->commit();

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
			DELETE FROM driver 
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