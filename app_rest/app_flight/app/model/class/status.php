<?php 

class Status implements IQuery {

	public $Id;
	public $Name;
	public $Desc;
	public $Value;
	
	public function __construct() {
	}

	public static function selectAll() {

		$connection = Flight::dbMain();

		try {
			$sql = "SELECT * FROM e_status;";
			$query = $connection->prepare($sql);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$status = new Status();
				$status->Id = (int) $row['id'];
				$status->Name = $row['status_name'];
				$status->Desc = $row['status_desc'];
				$status->Value = (int)$row['status_value'];
				
				array_push($result, $status);
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
			$sql = "SELECT * FROM e_status WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				Flight::notFound("id not found");
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);


			$status = new Status();
			$status->Id = (int) $row['id'];
			$status->Name = $row['status_name'];
			$status->Desc = $row['status_desc'];
			$status->Value = (int)$row['status_value'];

			Flight::ok($status);

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

			$status = json_decode(file_get_contents("php://input"));

			if ($status == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			INSERT INTO e_status 
			(status_name, status_desc, status_value)
			VALUES
			(:status_name, :status_desc, :status_value);";

			$query = $connection->prepare($sql);

			$query->bindParam(':status_name', $status->Name, PDO::PARAM_STR);
			$query->bindParam(':status_desc', $status->Desc, PDO::PARAM_STR);
			$query->bindParam(':status_value',$status->Value, PDO::PARAM_INT);
			
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

			$status = json_decode(file_get_contents("php://input"));

			if ($status == null) {
				throw new Exception(json_get_error());
			}

			
			$sql = "
			UPDATE e_status 
			SET 
			status_name = :status_name,
			status_desc = :status_desc, 
			status_value = :status_value
			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':status_name', $status->Name, PDO::PARAM_STR);
			$query->bindParam(':status_desc', $status->Desc, PDO::PARAM_STR);
			$query->bindParam(':status_value', $status->Value, PDO::PARAM_INT);

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
			DELETE FROM e_status 
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