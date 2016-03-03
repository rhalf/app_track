<?php 

require_once('/app/model/interface/iquery.php');

class Model implements IQuery {

	public $Id;
	public $Name;
	public $Brand;
	public $Desc;
	public $Type;
	public $Category;

	public function __construct() {
	}

	public static function onSelect(Url $url, $get) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		$array['result'] = array();
		$array['model'] = array();


		try {
			if (isset($get['id'])) {
				$sql = "SELECT * FROM model WHERE id = :id;";
			} else {
				$sql = "SELECT * FROM model;";
			}
			

			$query = $connection->prepare($sql);
			$query->bindParam(':id', $get['id'], PDO::PARAM_INT);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			if (!$rows) {
				throw new PDOException( "Object with id " . $get['id'] ." doesn't exist.", '02000');
			}

			foreach ($rows as $row) {	
				$model = new Model();
				$model->Id = (int) $row['id'];
				$model->Name = $row['model_name'];
				$model->Desc = $row['model_desc'];
				$model->Brand = $row['model_brand'];
				$model->Type = $row['model_type'];
				$model->Category = (int) $row['model_category'];
	
				array_push($array['model'], $model);
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
	public static function onInsert(Url $url, $post) {
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

			$model = $object->model[0];

			$sql = "
			INSERT INTO model 
			(model_name, model_desc, model_brand, model_type, model_category)
			VALUES
			(:model_name, :model_desc, :model_brand, :model_type, :model_category);";


			$query = $connection->prepare($sql);

			$query->bindParam(':model_name', $model->Name, PDO::PARAM_STR);
			$query->bindParam(':model_desc', $model->Desc, PDO::PARAM_STR);
			$query->bindParam(':model_brand', $model->Brand, PDO::PARAM_STR);
			$query->bindParam(':model_type', $model->Type, PDO::PARAM_STR);
			$query->bindParam(':model_category', $model->Info, PDO::PARAM_INT);

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
	public static function onUpdate(Url $url, $put) {
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

			$model = $object->model[0];


			$sql = "
			UPDATE model 
			SET 
			model_name = :model_name,
			model_desc = :model_desc, 
			model_brand = :model_brand,
			model_type = :model_type, 
			model_category = :model_category
			WHERE
			id = :id;";

			

			$query = $connection->prepare($sql);

			$query->bindParam(':model_name', $model->Name, PDO::PARAM_STR);
			$query->bindParam(':model_desc', $model->Desc, PDO::PARAM_STR);
			$query->bindParam(':model_brand', $model->Brand, PDO::PARAM_STR);
			$query->bindParam(':model_type', $model->Type, PDO::PARAM_STR);
			$query->bindParam(':model_category', $model->Category, PDO::PARAM_INT);

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
	public static function onDelete(Url $url, $delete) {
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
			DELETE FROM model 
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