<?php 

class TrackeeType implements IQuery {

	public $Id;
	public $Name;
	public $Desc;
	public $Value;


	public function __construct() {
	}

	public static function selectAll() {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM e_trackee_type;";
			$query = $connection->prepare($sql);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$trackeeType = new TrackeeType();
				$trackeeType->Id = (int) $row['id'];
				$trackeeType->Name = $row['type_name'];
				$trackeeType->Desc = $row['type_desc'];
				$trackeeType->Value = (int) $row['type_value'];

				array_push($result, $trackeeType);
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

			$sql = "SELECT * FROM e_trackee_type WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				Flight::notFound("id not found");
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$trackeeType = new TrackeeType();
			$trackeeType->Id = (int) $row['id'];
			$trackeeType->Name = $row['type_name'];
			$trackeeType->Desc = $row['type_desc'];
			$trackeeType->Value = (int) $row['type_value'];

			Flight::ok($trackeeType);

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

			$trackeeType = json_decode(file_get_contents("php://input"));

			if ($trackeeType == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO e_trackee_type 
			(type_name, type_desc, type_value)
			VALUES
			(:type_name, :type_desc, :type_value);";


			$query = $connection->prepare($sql);

			$query->bindParam(':type_name', $trackeeType->Name, PDO::PARAM_STR);
			$query->bindParam(':type_desc', $trackeeType->Desc, PDO::PARAM_STR);
			$query->bindParam(':type_value', $trackeeType->Value, PDO::PARAM_INT);


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

			$trackeeType = json_decode(file_get_contents("php://input"));

			if ($trackeeType == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE e_trackee_type 
			SET 
			type_name = :type_name,
			type_desc = :type_desc, 
			type_value = :type_value
		
			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':type_name', $trackeeType->Name, PDO::PARAM_STR);
			$query->bindParam(':type_desc', $trackeeType->Desc, PDO::PARAM_STR);
			$query->bindParam(':type_value', $trackeeType->Value, PDO::PARAM_INT);


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
			DELETE FROM e_trackee_type 
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