<?php 

class Model implements IQuery {

	public $Id;
	public $Name;
	public $Brand;
	public $Desc;
	public $Type;
	public $Categ;

	public function __construct() {
	}

	public static function onSelect(Url $url, $data) {
		
		$connection = Flight::dbMain();

		try {

			if (!empty($url->Id)) {
				$sql = "SELECT * FROM model WHERE id = :id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':id',$url->Id, PDO::PARAM_INT);
			} else if (isset($data['name'])) {
				$sql = "SELECT * FROM model WHERE model_name LIKE :name;";
				$query = $connection->prepare($sql);
				$query->bindParam(':name',$data['name'], PDO::PARAM_STR);
			} else {
				$sql = "SELECT * FROM model;";
				$query = $connection->prepare($sql);
			}

			$query->execute();

			$result = new Result();
			$result->Item = $query->rowCount();
			$result->Object = array();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			foreach ($rows as $row) {	
				$model = new Model();
				$model->Id = (int) $row['id'];
				$model->Name = $row['model_name'];
				$model->Desc = $row['model_desc'];
				$model->Brand = $row['model_brand'];
				$model->Type = $row['model_type'];
				$model->Categ = (int) $row['model_category'];

				array_push($result->Object, $model);
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
		
		$connection = Flight::dbMain();

		try {

			if (!isset($data['Object'])) {
				throw new Exception("Input object is not set.");
			}

			$model = json_decode($data['Object']);
			if ($model == null) {
				throw new Exception(json_get_error());
			}


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
			$query->bindParam(':model_category', $model->Categ, PDO::PARAM_INT);

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

		$connection = Flight::dbMain();

		try {
			if (empty($url->Id)) {
				throw new Exception("Input id is empty.");
			}

			if (!isset($data['Object'])) {
				throw new Exception("Input object is not set.");
			}

			$model = json_decode($data['Object']);
			if ($model == null) {
				throw new Exception(json_get_error());
			}

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
			$query->bindParam(':model_category', $model->Categ, PDO::PARAM_INT);

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
		
		$connection = Flight::dbMain();
		
		try {
			
			if (empty($url->Id)) {
				throw new Exception("Input id is empty");
			}

			$sql = "
			DELETE FROM model 
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