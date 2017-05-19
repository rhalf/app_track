<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class type and supplies the requests such as select, insert, update & delete.
*/
class Type implements IQuery {

	public $id;
	public $name;
	public $desc;
	public $value;


	public function __construct() {
	}

	public static function selectAll() {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM e_type;";
			$query = $connection->prepare($sql);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$type = new Type();
				$type->id = (int) $row['id'];
				$type->name = $row['type_name'];
				$type->desc = $row['type_desc'];
				$type->value = (int) $row['type_value'];

				array_push($result, $type);
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

			$sql = "SELECT * FROM e_type WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$type = new Type();
			$type->id = (int) $row['id'];
			$type->name = $row['type_name'];
			$type->desc = $row['type_desc'];
			$type->value = (int) $row['type_value'];

			return $type;

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

			$type = json_decode(file_get_contents("php://input"));

			if ($type == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO e_type 
			(type_name, type_desc, type_value)
			VALUES
			(:type_name, :type_desc, :type_value);";


			$query = $connection->prepare($sql);

			$query->bindParam(':type_name', $type->name, PDO::PARAM_STR);
			$query->bindParam(':type_desc', $type->desc, PDO::PARAM_STR);
			$query->bindParam(':type_value', $type->value, PDO::PARAM_INT);


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

			$type = json_decode(file_get_contents("php://input"));

			if ($type == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE e_type 
			SET 
			type_name = :type_name,
			type_desc = :type_desc, 
			type_value = :type_value
		
			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':type_name', $type->name, PDO::PARAM_STR);
			$query->bindParam(':type_desc', $type->desc, PDO::PARAM_STR);
			$query->bindParam(':type_value', $type->value, PDO::PARAM_INT);


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
			DELETE FROM e_type 
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