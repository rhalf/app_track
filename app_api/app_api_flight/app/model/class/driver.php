<?php 

class Driver implements IQuery {

	public $Id;
	public $DriverId;
	public $Name;
	public $NameFirst;
	public $NameMiddle;
	public $NameLast;
	public $DtCreated;
	public $Rfid;
	public $Company;
	public $Status;


	public function __construct() {
	}

	public static function selectAll() {

		$connection = Flight::dbMain();
		
		try {

			$sql = "SELECT * FROM driver;";
			$query = $connection->prepare($sql);
			
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$driver = new Driver();
				$driver->Id = (int) $row['id'];
				$driver->DriverId = $row['driver_id'];
				$driver->Name = $row['driver_name'];
				$driver->NameFirst = $row['driver_name_f'];
				$driver->NameMiddle = $row['driver_name_m'];
				$driver->NameLast = $row['driver_name_l'];
				$driver->Rfid = $row['driver_rfid'];
				$driver->DtCreated = $row['driver_dt_created'];
				
				$driver->Status = Status::select($row['e_status_id']);
				$driver->Company = Company::select($row['company_id']);

				array_push($result, $driver);
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

			$sql = "SELECT * FROM driver WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$driver = new Driver();
			$driver->Id = (int) $row['id'];
			$driver->DriverId = $row['driver_id'];
			$driver->Name = $row['driver_name'];
			$driver->NameFirst = $row['driver_name_f'];
			$driver->NameMiddle = $row['driver_name_m'];
			$driver->NameLast = $row['driver_name_l'];
			$driver->Rfid = $row['driver_rfid'];
			$driver->DtCreated = $row['driver_dt_created'];

			$driver->Status = Status::select($row['e_status_id']);
			$driver->Company = Company::select($row['company_id']);

			return $driver;

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

			$sql = "SELECT * FROM driver WHERE company_id = :company;";
			$query = $connection->prepare($sql);
			$query->bindParam(':company',$id, PDO::PARAM_INT);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$driver = new Driver();
				$driver->Id = (int) $row['id'];
				$driver->DriverId = $row['driver_id'];
				$driver->Name = $row['driver_name'];
				$driver->NameFirst = $row['driver_name_f'];
				$driver->NameMiddle = $row['driver_name_m'];
				$driver->NameLast = $row['driver_name_l'];
				$driver->Rfid = $row['driver_rfid'];
				$driver->DtCreated = $row['driver_dt_created'];
				$driver->Status = Status::select($row['e_status_id']);
				$driver->Company = Company::select($row['company_id']);
				array_push($result, $driver);
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

	public static function insert() {

		$connection = Flight::dbMain();
		$dateTime = Flight::dateTime();

		try {

			$driver = json_decode(file_get_contents("php://input"));

			if ($driver == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO driver 
			(driver_id, driver_name, driver_name_f, driver_name_m, driver_name_l, driver_rfid, e_status_id, company_id, driver_dt_created)
			VALUES
			(:driver_id, :driver_name, :driver_name_f, :driver_name_m, :driver_name_l, :driver_rfid, :e_status_id, :company_id, :driver_dt_created);";


			$query = $connection->prepare($sql);

			$query->bindParam(':driver_id', $driver->DriverId, PDO::PARAM_STR);
			$query->bindParam(':driver_name', $driver->Name, PDO::PARAM_STR);
			$query->bindParam(':driver_name_f', $driver->NameFirst, PDO::PARAM_STR);
			$query->bindParam(':driver_name_m', $driver->NameMiddle, PDO::PARAM_STR);
			$query->bindParam(':driver_name_l', $driver->NameLast, PDO::PARAM_STR);
			$query->bindParam(':driver_rfid', $driver->Rfid, PDO::PARAM_STR);
			$query->bindParam(':e_status_id', $driver->Status->Id, PDO::PARAM_INT);
			$query->bindParam(':company_id', $driver->Company->Id, PDO::PARAM_INT);
			$query->bindParam(':driver_dt_created', $dateTime, PDO::PARAM_STR);

			$query->execute();
			
			$result = new Result();
			$result->Status = Result::INSERTED;
			$result->Id = $connection->lastInsertId();
			$result->Message = 'Done';

			return $result;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}
	
	public static function update($id) {

		$connection = Flight::dbMain();

		try {

			$driver = json_decode(file_get_contents("php://input"));

			if ($driver == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE driver 
			SET
			driver_id = :driver_id,
			driver_name = :driver_name,
			driver_name_f = :driver_name_f,
			driver_name_m = :driver_name_m,
			driver_name_l = :driver_name_l,
			driver_rfid = :driver_rfid,
			e_status_id = :e_status_id,
			company_id = :company_id

			WHERE
			id = :id;";


			$query = $connection->prepare($sql);

			$query->bindParam(':driver_id', $driver->DriverId, PDO::PARAM_STR);
			$query->bindParam(':driver_name', $driver->Name, PDO::PARAM_STR);
			$query->bindParam(':driver_name_f', $driver->NameFirst, PDO::PARAM_STR);
			$query->bindParam(':driver_name_m', $driver->NameMiddle, PDO::PARAM_STR);
			$query->bindParam(':driver_name_l', $driver->NameLast, PDO::PARAM_STR);
			$query->bindParam(':driver_rfid', $driver->Rfid, PDO::PARAM_STR);
			$query->bindParam(':e_status_id', $driver->Status->Id, PDO::PARAM_INT);
			$query->bindParam(':company_id', $driver->Company->Id, PDO::PARAM_INT);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::UPDATED;
			$result->Id = $id;
			$result->Message = 'Done.';

			return $result;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}
	
	public static function delete($id) {
		
		$connection = Flight::dbMain();
		
		try {

			$sql = "
			DELETE FROM driver 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::DELETED;
			$result->Message = 'Done';
			$result->Id = $id;

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