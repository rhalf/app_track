<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Supplies the request of the class field such as select, insert, update & delete.
*/
class Field implements IQuery {

	public $id;
	public $name;
	public $desc;
	
	public function __construct() {
	}

	public static function selectAll() {
		
		$connection = Flight::dbMain();

		try {
			
			$sql = "SELECT * FROM e_field;";
			$query = $connection->prepare($sql);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$field = new Field();
				$field->id = (int) $row['id'];
				$field->name = $row['field_name'];
				$field->desc = $row['field_desc'];
				
				array_push($result, $field);
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
			
			$sql = "SELECT * FROM e_field WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$field = new Field();
			$field->id = (int) $row['id'];
			$field->name = $row['field_name'];
			$field->desc = $row['field_desc'];

			return $field;

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

			$field = json_decode(file_get_contents("php://input"));

			if ($field == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO e_field 
			(field_name, field_desc)
			VALUES
			(:field_name, :field_desc);";


			$query = $connection->prepare($sql);

			$query->bindParam(':field_name', $field->name, PDO::PARAM_STR);
			$query->bindParam(':field_desc', $field->desc, PDO::PARAM_STR);

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

			$field = json_decode(file_get_contents("php://input"));

			if ($field == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE e_field 
			SET 
			field_name = :field_name,
			field_desc = :field_desc
			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':field_name', $field->name, PDO::PARAM_STR);
			$query->bindParam(':field_desc', $field->desc, PDO::PARAM_STR);
			
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
			DELETE FROM e_field 
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