<?php 

class UnitStatus implements IQuery {

	public $Id;
	public $Name;
	public $Desc;
	public $Value;
	
	public function __construct() {
	}

	public static function selectAll() {

		$connection = Flight::dbMain();

		try {
			$sql = "SELECT * FROM e_status_unit;";
			$query = $connection->prepare($sql);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$unitStatus = new UnitStatus();
				$unitStatus->Id = (int) $row['id'];
				$unitStatus->Name = $row['status_name'];
				$unitStatus->Desc = $row['status_desc'];
				$unitStatus->Value = (int)$row['status_value'];
				
				array_push($result, $unitStatus);
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
			$sql = "SELECT * FROM e_status_unit WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				Flight::notFound("id not found");
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);


			$unitStatus = new UnitStatus();
			$unitStatus->Id = (int) $row['id'];
			$unitStatus->Name = $row['status_name'];
			$unitStatus->Desc = $row['status_desc'];
			$unitStatus->Value = (int)$row['status_value'];

			Flight::ok($unitStatus);

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

			$unitStatus = json_decode(file_get_contents("php://input"));

			if ($unitStatus == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			INSERT INTO e_status_unit 
			(status_name, status_desc, status_value)
			VALUES
			(:status_name, :status_desc, :status_value);";

			$query = $connection->prepare($sql);

			$query->bindParam(':status_name', $unitStatus->Name, PDO::PARAM_STR);
			$query->bindParam(':status_desc', $unitStatus->Desc, PDO::PARAM_STR);
			$query->bindParam(':status_value',$unitStatus->Value, PDO::PARAM_INT);
			
			$query->execute();
			
			$result = new Result();
			$result->UnitStatus = Result::INSERTED;
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

			$unitStatus = json_decode(file_get_contents("php://input"));

			if ($unitStatus == null) {
				throw new Exception(json_get_error());
			}

			
			$sql = "
			UPDATE e_status_unit 
			SET 
			status_name = :status_name,
			status_desc = :status_desc, 
			status_value = :status_value
			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':status_name', $unitStatus->Name, PDO::PARAM_STR);
			$query->bindParam(':status_desc', $unitStatus->Desc, PDO::PARAM_STR);
			$query->bindParam(':status_value', $unitStatus->Value, PDO::PARAM_INT);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->UnitStatus = Result::UPDATED;
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
			DELETE FROM e_status_unit 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->UnitStatus = Result::DELETED;
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