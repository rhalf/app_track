<?php 

class Driver implements IQuery {

	public $Id;
	public $DriverId;
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
				$driver->NameFirst = $row['driver_name_f'];
				$driver->NameMiddle = $row['driver_name_m'];
				$driver->NameLast = $row['driver_name_l'];
				$driver->Rfid = (int) $row['driver_id'];
				$driver->Status = (int) $row['e_status_value'];
				$driver->Company = (int) $row['company_id'];
				$driver->DtCreated = $row['driver_dt_created'];

				array_push($result, $driver);
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

			$sql = "SELECT * FROM driver WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				Flight::notFound("id not found");
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$driver = new Driver();
			$driver->Id = (int) $row['id'];
			$driver->DriverId = $row['driver_id'];
			$driver->NameFirst = $row['driver_name_f'];
			$driver->NameMiddle = $row['driver_name_m'];
			$driver->NameLast = $row['driver_name_l'];
			$driver->Rfid = (int) $row['driver_id'];
			$driver->Status = (int) $row['e_status_value'];
			$driver->Company = (int) $row['company_id'];
			$driver->DtCreated = $row['driver_dt_created'];


			Flight::ok($driver);

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

			$driver = json_decode(file_get_contents("php://input"));

			if ($driver == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO driver 
			(driver_id, driver_name_f, driver_name_m, driver_name_l, driver_rfid, e_status_value, company_id, driver_dt_created)
			VALUES
			(:driver_id, :driver_name_f, :driver_name_m, :driver_name_l, :driver_rfid, :e_status_value, :company_id, :driver_dt_created);";


			$query = $connection->prepare($sql);

			$query->bindParam(':driver_id', $driver->DriverId, PDO::PARAM_STR);
			$query->bindParam(':driver_name_f', $driver->NameFirst, PDO::PARAM_STR);
			$query->bindParam(':driver_name_m', $driver->NameMiddle, PDO::PARAM_STR);
			$query->bindParam(':driver_name_l', $driver->NameLast, PDO::PARAM_STR);
			$query->bindParam(':driver_rfid', $driver->Rfid, PDO::PARAM_INT);
			$query->bindParam(':e_status_value', $driver->Status, PDO::PARAM_INT);
			$query->bindParam(':company_id', $driver->Company, PDO::PARAM_INT);
			$query->bindParam(':driver_dt_created', $driver->DtCreated, PDO::PARAM_STR);

			$query->execute();
			
			$result = new Result();
			$result->Status = Result::INSERTED;
			$result->Id = $connection->lastInsertId();
			$result->Message = 'Done';

			Flight::ok($result);

		} catch (PDOException $pdoException) {
			Flight::error($pdoException);
		} catch (Exception $exception) {
			Flight::error($exception);
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
			driver_name_f = :driver_name_f,
			driver_name_m = :driver_name_m,
			driver_name_l = :driver_name_l,
			driver_rfid = :driver_rfid,
			e_status_value = :e_status_value,
			company_id = :company_id,
			driver_dt_created = :driver_dt_created

			WHERE
			id = :id;";


			$query = $connection->prepare($sql);

			$query->bindParam(':driver_id', $driver->DriverId, PDO::PARAM_STR);
			$query->bindParam(':driver_name_f', $driver->NameFirst, PDO::PARAM_STR);
			$query->bindParam(':driver_name_m', $driver->NameMiddle, PDO::PARAM_STR);
			$query->bindParam(':driver_name_l', $driver->NameLast, PDO::PARAM_STR);
			$query->bindParam(':driver_rfid', $driver->Rfid, PDO::PARAM_INT);
			$query->bindParam(':e_status_value', $driver->Status, PDO::PARAM_INT);
			$query->bindParam(':company_id', $driver->Company, PDO::PARAM_INT);
			$query->bindParam(':driver_dt_created', $driver->DtCreated, PDO::PARAM_STR);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::UPDATED;
			$result->Id = $id;
			$result->Message = 'Done.';

			Flight::ok($result);

		} catch (PDOException $pdoException) {
			Flight::error($pdoException);
		} catch (Exception $exception) {
			Flight::error($exception);
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

			Flight::ok($result);

		} catch (PDOException $pdoException) {
			Flight::error($pdoException);
		} catch (Exception $exception) {
			Flight::error($exception);
		} finally {
			$connection = null;
		}
	}
}
?>