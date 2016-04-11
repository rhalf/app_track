<?php 

class Collection implements IQuery {

	public $Id;
	public $Name;
	public $Desc;

	public function __construct() {
	}

	public static function onSelect(Url $url, $data) {
		
		$connection = Flight::dbMain();

		try {
			if (!empty($url->Id)) {
				$sql = "SELECT * FROM collection WHERE id = :id;";
				$query = $connection->prepare($sql);

				$query->bindParam(':id',$url->Id, PDO::PARAM_INT);
			} else if (isset($data['name'])) {
				$sql = "SELECT * FROM collection WHERE collection_name LIKE :name;";
				$query = $connection->prepare($sql);
				$query->bindParam(':name',$data['name'], PDO::PARAM_STR);
			} else {
				$sql = "SELECT * FROM collection;";
				$query = $connection->prepare($sql);
			}

			$query->execute();

			$result = new Result();
			$result->Item = $query->rowCount();
			$result->Object = array();


			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			foreach ($rows as $row) {	
				$collection = new Collection();
				$collection->Id = (int) $row['id'];
				$collection->Name = $row['collection_name'];
				$collection->Desc = $row['collection_desc'];

				array_push($result->Object, $collection);
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


			$collection = json_decode($data['Object']);
			if ($collection == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			INSERT INTO collection 
			(collection_name, collection_desc)
			VALUES
			(:collection_name, :collection_desc);";

			$query = $connection->prepare($sql);

			$query->bindParam(':collection_name', $collection->Name, PDO::PARAM_STR);
			$query->bindParam(':collection_desc', $collection->Desc, PDO::PARAM_STR);

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

		//$connection->beginTransaction();

		try {
			if (empty($url->Id)) {
				throw new Exception("Input id is empty.");
			}

			if (!isset($data['Object'])) {
				throw new Exception("Input object is not set.");
			}

			$collection = json_decode($data['Object']);
			if ($collection == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			UPDATE collection 
			SET 
			collection_name = :collection_name,
			collection_desc = :collection_desc
			
			WHERE
			id = :id;";
			

			$query = $connection->prepare($sql);


			$query->bindParam(':collection_name', $collection->Name, PDO::PARAM_STR);
			$query->bindParam(':collection_desc', $collection->Desc, PDO::PARAM_STR);

			$query->bindParam(':id', $url->Id, PDO::PARAM_INT);

			$query->execute();

			//$connection->commit();

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
			DELETE FROM collection 
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