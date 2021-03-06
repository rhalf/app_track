<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class unitStatus and supplies the requests such as select, insert, update & delete.
*/
class UnitStatus implements IQuery {

	public $id;
	public $name;
	public $desc;
	public $value;
	
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
				$unitStatus->id = (int) $row['id'];
				$unitStatus->name = $row['status_name'];
				$unitStatus->desc = $row['status_desc'];
				$unitStatus->value = (int)$row['status_value'];
				
				array_push($result, $unitStatus);
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
			$sql = "SELECT * FROM e_status_unit WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);


			$unitStatus = new UnitStatus();
			$unitStatus->id = (int) $row['id'];
			$unitStatus->name = $row['status_name'];
			$unitStatus->desc = $row['status_desc'];
			$unitStatus->value = (int)$row['status_value'];

			return $unitStatus;

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

			$query->bindParam(':status_name', $unitStatus->name, PDO::PARAM_STR);
			$query->bindParam(':status_desc', $unitStatus->desc, PDO::PARAM_STR);
			$query->bindParam(':status_value',$unitStatus->value, PDO::PARAM_INT);
			
			$query->execute();
			
			$result = new Result();
			$result->status = Result::INSERTED;
			$result->id = $connection->lastInsertid();
			$result->message = 'Done';

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

			$query->bindParam(':status_name', $unitStatus->name, PDO::PARAM_STR);
			$query->bindParam(':status_desc', $unitStatus->desc, PDO::PARAM_STR);
			$query->bindParam(':status_value', $unitStatus->value, PDO::PARAM_INT);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->status = Result::UPDATED;
			$result->id = $id;
			$result->message = 'Done.';

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
			DELETE FROM e_status_unit 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->status = Result::DELETED;
			$result->message = 'Done';
			$result->id = $id;

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