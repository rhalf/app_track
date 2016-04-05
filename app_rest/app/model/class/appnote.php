<?php 

class AppNote implements IQuery {

	public $Id;
	public $Name;
	public $Message;
	public $DtCreated;

	

	public function __construct() {
	}

	public static function onSelect(Url $url, $data) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {

			if (!empty($url->Id)) {
				$sql = "SELECT * FROM app_note WHERE id = :id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':id',$url->Id, PDO::PARAM_INT);
			} else if (isset($data['name'])) {
				$sql = "SELECT * FROM app_note WHERE note_name LIKE :name;";
				$query = $connection->prepare($sql);
				$query->bindParam(':note_name',$data['name'], PDO::PARAM_STR);
			} else {
				$sql = "SELECT * FROM app_note;";
				$query = $connection->prepare($sql);
			}

			$query->execute();

			$result = new Result();
			$result->Item = $query->rowCount();
			$result->Object = array();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			foreach ($rows as $row) {	
				$appNote = new AppNote();
				$appNote->Id = (int) $row['id'];
				$appNote->Name = $row['note_name'];
				$appNote->Message =  $row['note_message'];
				$appNote->DtCreated = $row['note_dt_created'];
				array_push($result->Object, $appNote);
			}

			$result->Status = Result::SUCCESS;
			$result->Message = 'Done.';

		} catch (PDOException $pdoException) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $pdoException->getMessage();
		} catch (Exception $exception) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $exception->getMessage();
		}

		$connection = null;

		return $result;
	}
	public static function onInsert(Url $url, $data) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {

			if (!isset($data['Object'])) {
				throw new Exception("Input object is not set.");
			}

			$appNote = json_decode($data['Object']);
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
			$result->Status = Result::SUCCESS;
			$result->Item = $query->rowCount();
			$result->Message = 'Done.';

		} catch (PDOException $pdoException) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $pdoException->getMessage();
		} catch (Exception $exception) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $exception->getMessage();
		}

		$connection = null;

		return $result;
	}
	public static function onUpdate(Url $url, $data) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {
			if (empty($url->Id)) {
				throw new Exception("Input id is empty.");
			}

			if (!isset($data['Object'])) {
				throw new Exception("Input object is not set.");
			}

			$appNote = json_decode($data['Object']);
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
			$query->bindParam(':id', $url->Id, PDO::PARAM_INT);
		

			$query->execute();

			$result = new Result();
			$result->Status = Result::SUCCESS;
			$result->Item = $query->rowCount();
			$result->Message = 'Done.';

		} catch (PDOException $pdoException) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $pdoException->getMessage();
		} catch (Exception $exception) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $exception->getMessage();
		}

		$connection = null;
		return $result;
	}
	public static function onDelete(Url $url, $data) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {
			
			if (empty($url->Id)) {
				throw new Exception("Input id is empty");
			}

			$sql = "
			DELETE FROM app_note 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);

			$query->bindParam(':id', $url->Id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::SUCCESS;
			$result->Item = $query->rowCount();
			$result->Message = 'Done.';

		} catch (PDOException $pdoException) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $pdoException->getMessage();
		} catch (Exception $exception) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $exception->getMessage();
		}

		$connection = null;
		return $result;
	}
}

?>