<?php 

require_once('/app/model/interface/iquery.php');

class Privilege implements IQuery {

	public $Id;
	public $Name;
	public $Desc;
	public $Value;
	
	public function __construct() {
	}

	public static function onSelect($get) {
		$database = Flight::get('database');

		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		$array['result'] = array();
		$array['privilege'] = array();



		try {

			if (isset($get['id'])) {
				$sql = "SELECT * FROM e_privilege WHERE id = :id;";
			} else if (isset($get['name'])) {
				$sql = "SELECT * FROM e_privilege WHERE privilege_name LIKE :name;";
			} else {
				$sql = "SELECT * FROM e_privilege;";
			}

			$query = $connection->prepare($sql);
			$query->execute($get);


			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			if (!$rows) {
				throw new PDOException( "Object with id " . $get['id'] ." doesn't exist.", '02000');
			}

			foreach ($rows as $row) {	
				$privilege = new Privilege();
				$privilege->Id = (int) $row['id'];
				$privilege->Name = $row['privilege_name'];
				$privilege->Desc = $row['privilege_desc'];
				$privilege->Value = (int) $row['privilege_value'];


				array_push($array['privilege'], $privilege);
			}

			$result = new Result(0, RESULT::PDO, "Success");
			$array['result'] = $result;

		} catch (PDOException $pdoException) {
			$result = new Result($pdoException->getCode(), RESULT::PDO, $pdoException->getMessage());
			$array['result'] = $result;
		} catch (Exception $exception) {
			$result = new Result(1, RESULT::SYSTEM, $exception->getMessage());
			$array['result'] = $result;
		}


		$connection = null;

		return $array;
	}
	public static function onInsert($post) {
		$database = Flight::get('database');

		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {

			$array['result'] = array();

			if(!isset($post['object'])) {
				throw new Exception("Input object is null", 1);
			}

			$json = $post['object'];

			$object = json_decode($json);

			$privilege = $object->privilege[0];

			$sql = "
			INSERT INTO e_privilege 
			(privilege_name, privilege_desc, privilege_value)
			VALUES
			(:privilege_name, :privilege_desc, :privilege_value);";


			$query = $connection->prepare($sql);

			$query->bindParam(':privilege_name', $privilege->Name, PDO::PARAM_STR);
			$query->bindParam(':privilege_desc', $privilege->Desc, PDO::PARAM_STR);
			$query->bindParam(':privilege_value', $privilege->Value, PDO::PARAM_STR);
			

			$query->execute();

			$result = new Result(0, RESULT::PDO, "Success");
			$array['result'] = $result;

		} catch (PDOException $pdoException) {
			$result = new Result($pdoException->getCode(), RESULT::PDO, $pdoException->getMessage());
			$array['result'] = $result;
		} catch (Exception $exception) {
			$result = new Result(1, RESULT::SYSTEM, $exception->getMessage());
			$array['result'] = $result;
		}

		$connection = null;

		return $array;
	}
	public static function onUpdate($put) {
		$database = Flight::get('database');

		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		//$connection->beginTransaction();

		$array['result'] = array();

		try {
			if (!isset($put['id']) || !isset($put['object'])) {
				throw new Exception("Input object and id are null.", 1);
			}

			$id = $put['id'];
			$object = json_decode($put['object']);

			$privilege = $object->privilege[0];


			$sql = "
			UPDATE e_privilege 
			SET 
			privilege_name = :privilege_name,
			privilege_desc = :privilege_desc, 
			privilege_value = :privilege_value
			WHERE
			id = :id;";

			

			$query = $connection->prepare($sql);

			$query->bindParam(':privilege_name', $privilege->Name, PDO::PARAM_STR);
			$query->bindParam(':privilege_desc', $privilege->Desc, PDO::PARAM_STR);
			$query->bindParam(':privilege_value', $privilege->Value, PDO::PARAM_INT);
			$query->bindParam(':id', $id, PDO::PARAM_INT);


			$query->execute();

			//$connection->commit();

			$result = new Result(0, RESULT::PDO, "Success");
			$array['result'] = $result;

		} catch (PDOException $pdoException) {
			//$connection->rollback();
			$result = new Result($pdoException->getCode(), RESULT::PDO, $pdoException->getMessage());
			$array['result'] = $result;
		} catch (Exception $exception) {
			//$connection->rollback();
			$result = new Result(1, RESULT::SYSTEM, $exception->getMessage());
			$array['result'] = $result;
		}

		$connection = null;

		return $array;
	}
	public static function onDelete($delete) {
		$database = Flight::get('database');
		
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		$array['result'] = array();

		
		try {
			if (!isset($delete['id'])) {
				throw new Exception("Input id is null", 1);
			}

			$id = $delete['id'];
			
			$sql = "
			DELETE FROM e_privilege 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result(0, RESULT::PDO, "Success");
			$array['result'] = $result;

		} catch (PDOException $pdoException) {
			$result = new Result($pdoException->getCode(), RESULT::PDO, $pdoException->getMessage());
			$array['result'] = $result;
		} catch (Exception $exception) {
			$result = new Result(1, RESULT::SYSTEM, $exception->getMessage());
			$array['result'] = $result;
		}

		$connection = null;

		return $array;
	}
}

?>