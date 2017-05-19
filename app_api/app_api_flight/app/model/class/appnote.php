<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class appNote and supplies the requests such as select, insert, update & delete.
*/
class AppNote implements IQuery {

	public $id;
	public $name;
	public $message;
	public $dtCreated;

	

	public function __construct() {
	}

	public static function selectAll() {

		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM app_note;";
			$query = $connection->prepare($sql);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$appNote = new AppNote();
				$appNote->id = (int) $row['id'];
				$appNote->name = $row['note_name'];
				$appNote->message =  $row['note_message'];
				$appNote->dtCreated = $row['note_dt_created'];

				array_push($result, $appNote);
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

			$sql = "SELECT * FROM app_note WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$appNote = new AppNote();
			$appNote->id = (int) $row['id'];
			$appNote->name = $row['note_name'];
			$appNote->message =  $row['note_message'];
			$appNote->dtCreated = $row['note_dt_created'];

			return $appNote;

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

			$appNote = json_decode(file_get_contents("php://input"));

			if ($appNote == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO app_note 
			(note_name, note_message,note_dt_created)
			VALUES
			(:note_name, :note_message, :note_dt_created);";

			$query = $connection->prepare($sql);

			$query->bindParam(':note_name', $appNote->name, PDO::PARAM_STR);
			$query->bindParam(':note_message', $appNote->message, PDO::PARAM_STR);
			$query->bindParam(':note_dt_created', $appNote->dtCreated, PDO::PARAM_STR);

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

			$appNote = json_decode(file_get_contents("php://input"));

			if ($appNote == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE app_note 
			SET 
			note_name = :note_name,
			note_message = :note_message,
			note_dt_created = :note_dt_created 
			WHERE
			id = :id;";

			
			$query = $connection->prepare($sql);

			$query->bindParam(':note_name', $appNote->name, PDO::PARAM_STR);
			$query->bindParam(':note_message', $appNote->message, PDO::PARAM_STR);
			$query->bindParam(':note_dt_created', $appNote->dtCreated, PDO::PARAM_STR);
			
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
			DELETE FROM app_note 
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