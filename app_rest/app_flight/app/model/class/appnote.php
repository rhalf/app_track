<?php 

class AppNote implements IQuery {

	public $Id;
	public $Name;
	public $Message;
	public $DtCreated;

	

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
				$appNote->Id = (int) $row['id'];
				$appNote->Name = $row['note_name'];
				$appNote->Message =  $row['note_message'];
				$appNote->DtCreated = $row['note_dt_created'];

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
			$appNote->Id = (int) $row['id'];
			$appNote->Name = $row['note_name'];
			$appNote->Message =  $row['note_message'];
			$appNote->DtCreated = $row['note_dt_created'];

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

			$query->bindParam(':note_name', $appNote->Name, PDO::PARAM_STR);
			$query->bindParam(':note_message', $appNote->Message, PDO::PARAM_STR);
			$query->bindParam(':note_dt_created', $appNote->DtCreated, PDO::PARAM_STR);

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

			$query->bindParam(':note_name', $appNote->Name, PDO::PARAM_STR);
			$query->bindParam(':note_message', $appNote->Message, PDO::PARAM_STR);
			$query->bindParam(':note_dt_created', $appNote->DtCreated, PDO::PARAM_STR);
			
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
			DELETE FROM app_note 
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