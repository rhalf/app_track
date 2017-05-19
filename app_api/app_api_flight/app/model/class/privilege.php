<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class privilege and supplies the requests such as select, insert, update & delete.
*/
class Privilege implements IQuery {

	public $id;
	public $name;
	public $desc;
	public $value;
	
	public function __construct() {
	}

	public static function selectAll() {

		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM e_privilege;";
			$query = $connection->prepare($sql);
			

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$privilege = new Privilege();
				$privilege->id = (int) $row['id'];
				$privilege->name = $row['privilege_name'];
				$privilege->desc = $row['privilege_desc'];
				$privilege->value = (int) $row['privilege_value'];
				
				array_push($result, $privilege);
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

			$sql = "SELECT * FROM e_privilege WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$privilege = new Privilege();
			$privilege->id = (int) $row['id'];
			$privilege->name = $row['privilege_name'];
			$privilege->desc = $row['privilege_desc'];
			$privilege->value = (int) $row['privilege_value'];
			
			return $privilege;

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

			$privilege = json_decode(file_get_contents("php://input"));

			if ($privilege == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO e_privilege 
			(privilege_name, privilege_desc, privilege_value)
			VALUES
			(:privilege_name, :privilege_desc, :privilege_value);";

			$query = $connection->prepare($sql);

			$query->bindParam(':privilege_name', $privilege->name, PDO::PARAM_STR);
			$query->bindParam(':privilege_desc', $privilege->desc, PDO::PARAM_STR);
			$query->bindParam(':privilege_value', $privilege->value, PDO::PARAM_STR);

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

			$privilege = json_decode(file_get_contents("php://input"));

			if ($privilege == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE e_privilege 
			SET 
			privilege_name = :privilege_name,
			privilege_desc = :privilege_desc, 
			privilege_value = :privilege_value
			WHERE
			id = :id;";

			
			$query = $connection->prepare($sql);

			$query->bindParam(':privilege_name', $privilege->name, PDO::PARAM_STR);
			$query->bindParam(':privilege_desc', $privilege->desc, PDO::PARAM_STR);
			$query->bindParam(':privilege_value', $privilege->value, PDO::PARAM_INT);
			
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
			DELETE FROM e_privilege 
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