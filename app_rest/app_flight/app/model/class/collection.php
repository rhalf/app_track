<?php 

class Collection implements IQuery {

	public $Id;
	public $Name;
	public $Desc;
	public $User;
	public $Company;
	public $Vehicles;

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
				// $collection->User = $row['user_id'] == null ? null : (int)$row['user_id'];
				// $collection->Company = (int)$row['company_id'];
				$collection->User = User::select($row['user_id']);
				$collection->Company = Company::select($row['company_id']);
				// $collection->Vehicles = array();
				// $vehicleCollections = VehicleCollection::selectByCollection($collection->Id);
				// foreach ($vehicleCollections as $vehicleCollection) {
				// 	array_push($collection->Vehicles, $vehicleCollection->Vehicle);
				// }

				array_push($result, $collection);
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
			
			$sql = "SELECT * FROM collection WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$collection = new Collection();
			$collection->Id = (int) $row['id'];
			$collection->Name = $row['collection_name'];
			$collection->Desc = $row['collection_desc'];
			// $collection->User = $row['user_id'] == null ? null : (int)$row['user_id'];
			// $collection->Company = (int)$row['company_id'];
			$collection->User = User::select($row['user_id']);
			$collection->Company = Company::select($row['company_id']);
			// $collection->Vehicles = array();
			// $vehicleCollections = VehicleCollection::selectByCollection($collection->Id);
			// foreach ($vehicleCollections as $vehicleCollection) {
			// 	array_push($collection->Vehicles, $vehicleCollection->Vehicle);
			// }

			return $collection;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}

	public static function selectByCompany($id) {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM collection WHERE company_id = :company;";
			$query = $connection->prepare($sql);
			$query->bindParam(':company',$id, PDO::PARAM_INT);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	

				$collection = new Collection();
				$collection->Id = (int) $row['id'];
				$collection->Name = $row['collection_name'];
				$collection->Desc = $row['collection_desc'];
				// $collection->User = $row['user_id'] == null ? null : (int)$row['user_id'];
				// $collection->Company = (int)$row['company_id'];
				$collection->User = User::select($row['user_id']);
				$collection->Company = Company::select($row['company_id']);
				// $vehicleCollections = VehicleCollection::selectByCollection($collection->Id);
				// foreach ($vehicleCollections as $vehicleCollection) {
				// 	array_push($collection->Vehicles, $vehicleCollection->Vehicle);
				// }

				array_push($result, $collection);
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

	public static function insert() {

		$connection = Flight::dbMain();

		try {

			$collection = json_decode(file_get_contents("php://input"));

			if ($collection == null) {
				throw new Exception(json_get_error());
			}

			//Query 1
			$sql = "
			INSERT INTO collection 
			(collection_name, collection_desc, user_id, company_id)
			VALUES
			(:collection_name, :collection_desc, :user_id, :company_id);";

			$query = $connection->prepare($sql);

			$query->bindParam(':collection_name', $collection->Name, PDO::PARAM_STR);
			$query->bindParam(':collection_desc', $collection->Desc, PDO::PARAM_STR);
			// $query->bindParam(':user_id', $collection->User, PDO::PARAM_INT);
			// $query->bindParam(':company_id', $collection->Company, PDO::PARAM_INT);
			$query->bindParam(':user_id', $collection->User->Id, PDO::PARAM_INT);
			$query->bindParam(':company_id', $collection->Company->Id, PDO::PARAM_INT);

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

			$collection = json_decode(file_get_contents("php://input"));

			if ($collection == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE collection 
			SET 
			collection_name = :collection_name,
			collection_desc = :collection_desc,
			user_id = :user_id,
			company_id = :company_id
			
			WHERE
			id = :id;";
			
			$query = $connection->prepare($sql);

			$query->bindParam(':collection_name', $collection->Name, PDO::PARAM_STR);
			$query->bindParam(':collection_desc', $collection->Desc, PDO::PARAM_STR);
			// $query->bindParam(':user_id', $collection->User, PDO::PARAM_INT);
			// $query->bindParam(':company_id', $collection->Company, PDO::PARAM_INT);
			$query->bindParam(':user_id', $collection->User->Id, PDO::PARAM_INT);
			$query->bindParam(':company_id', $collection->Company->Id, PDO::PARAM_INT);



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