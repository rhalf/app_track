<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class collection and supplies the requests such as select, insert, update & delete.
*/
class Collection implements IQuery {

	public $id;
	public $name;
	public $desc;
	public $user;
	public $company;
	public $vehiclesIds;

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
				$collection->id = (int) $row['id'];
				$collection->name = $row['collection_name'];
				$collection->desc = $row['collection_desc'];
				$collection->user = User::select($row['user_id']);
				$collection->company = Company::select($row['company_id']);
				$collection->vehiclesIds = VehicleCollection::selectByCollection($collection->id);
			

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
			$collection->id = (int) $row['id'];
			$collection->name = $row['collection_name'];
			$collection->desc = $row['collection_desc'];
			// $collection->user = $row['user_id'] == null ? null : (int)$row['user_id'];
			// $collection->company = (int)$row['company_id'];
			$collection->user = User::select($row['user_id']);
			$collection->company = Company::select($row['company_id']);
			$collection->vehiclesIds = VehicleCollection::selectByCollection($collection->id);

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
				$collection->id = (int) $row['id'];
				$collection->name = $row['collection_name'];
				$collection->desc = $row['collection_desc'];
				$collection->user = User::select($row['user_id']);
				$collection->company = Company::select($row['company_id']);
				$collection->vehiclesIds = VehicleCollection::selectByCollection($collection->id);

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

			$query->bindParam(':collection_name', $collection->name, PDO::PARAM_STR);
			$query->bindParam(':collection_desc', $collection->desc, PDO::PARAM_STR);
			// $query->bindParam(':user_id', $collection->user, PDO::PARAM_INT);
			// $query->bindParam(':company_id', $collection->company, PDO::PARAM_INT);
			$query->bindParam(':user_id', $collection->user->id, PDO::PARAM_INT);
			$query->bindParam(':company_id', $collection->company->id, PDO::PARAM_INT);

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

			$query->bindParam(':collection_name', $collection->name, PDO::PARAM_STR);
			$query->bindParam(':collection_desc', $collection->desc, PDO::PARAM_STR);
			// $query->bindParam(':user_id', $collection->user, PDO::PARAM_INT);
			// $query->bindParam(':company_id', $collection->company, PDO::PARAM_INT);
			$query->bindParam(':user_id', $collection->user->id, PDO::PARAM_INT);
			$query->bindParam(':company_id', $collection->company->id, PDO::PARAM_INT);



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
			DELETE FROM collection 
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