<?php 

class Collection implements IQuery {

	public $Id;
	public $Name;
	public $Desc;

	public function __construct() {
	}

	public static function selectAll() {
		
		$connection = Flight::dbMain();

		try {
			
			$sql = "SELECT * FROM collection;";
			$query = $connection->prepare($sql);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$collection = new Collection();
				$collection->Id = (int) $row['id'];
				$collection->Name = $row['collection_name'];
				$collection->Desc = $row['collection_desc'];

				array_push($result, $collection);
			}

			Flight::ok($result);

		} catch (PDOException $pdoException) {
			Flight::error($pdoException);
		} catch (Exception $exception) {
			Flight::error($exception);
		} finally {
			$connection = null;
		}
	}

	public static function select($id) {
		
		$connection = Flight::dbMain();

		try {
			
			$sql = "SELECT * FROM collection WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				Flight::notFound("id not found");
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$collection = new Collection();
			$collection->Id = (int) $row['id'];
			$collection->Name = $row['collection_name'];
			$collection->Desc = $row['collection_desc'];

			Flight::ok($collection);

		} catch (PDOException $pdoException) {
			Flight::error($pdoException);
		} catch (Exception $exception) {
			Flight::error($exception);
		} finally {
			$connection = null;
		}
	}

	public static function insert() {

		$connection = Flight::dbMain();

		try {

			$collection = json_decode(file_get_contents("php://input"));

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
			$result->Status = Result::INSERTED;
			$result->Id = $connection->lastInsertId();
			$result->Message = 'Done';

			Flight::ok($result);

		} catch (PDOException $pdoException) {
			Flight::error($pdoException);
		} catch (Exception $exception) {
			Flight::error($exception);
		} finally {
			$connection = null;
		}
	}
	public static function update($id) {

		$connection = Flight::dbMain();

		try {

			$collection = json_decode(file_get_contents("php://input"));

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

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::UPDATED;
			$result->Id = $id;
			$result->Message = 'Done.';

			Flight::ok($result);

		} catch (PDOException $pdoException) {
			Flight::error($pdoException);
		} catch (Exception $exception) {
			Flight::error($exception);
		} finally {
			$connection = null;
		}
	}
	public static function delete($id) {
		
		$connection = Flight::dbMain();
		
		try {
			
			$sql = "
			DELETE FROM collection 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::DELETED;
			$result->Message = 'Done';
			$result->Id = $id;

			Flight::ok($result);

		} catch (PDOException $pdoException) {
			Flight::error($pdoException);
		} catch (Exception $exception) {
			Flight::error($exception);
		} finally {
			$connection = null;
		}
	}
}
?>