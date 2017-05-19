<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class simVendor and supplies the requests such as select, insert, update & delete.
*/
class SimVendor implements IQuery {

	public $id;
	public $name;
	public $desc;
	public $nation;
	
	
	public function __construct() {
	}

	public static function selectAll() {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM e_sim_vendor;";
			$query = $connection->prepare($sql);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$simVendor = new SimVendor();
				$simVendor->id = (int) $row['id'];
				$simVendor->name = $row['sim_vendor_name'];
				$simVendor->desc = $row['sim_vendor_desc'];
				$simVendor->nation = Nation::select($row['e_nation_id']);
				

				array_push($result, $simVendor);
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

			$sql = "SELECT * FROM e_sim_vendor WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$simVendor = new SimVendor();
			$simVendor->id = (int) $row['id'];
			$simVendor->name = $row['sim_vendor_name'];
			$simVendor->desc = $row['sim_vendor_desc'];
			$simVendor->nation = Nation::select($row['e_nation_id']);

			return $simVendor;

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

			$simVendor = json_decode(file_get_contents("php://input"));

			if ($simVendor == null) {
				throw new Exception(json_get_error());
			}
			
			$sql = "
			INSERT INTO e_sim_vendor 
			(sim_vendor_name, sim_vendor_desc, e_nation_id)
			VALUES
			(:sim_vendor_name, :sim_vendor_desc, :e_nation_id);";

			$query = $connection->prepare($sql);

			$query->bindParam(':sim_vendor_name', $simVendor->name, PDO::PARAM_STR);
			$query->bindParam(':sim_vendor_desc', $simVendor->desc, PDO::PARAM_STR);
			$query->bindParam(':e_nation_id', $simVendor->nation->id, PDO::PARAM_INT);
			
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

			$simVendor = json_decode(file_get_contents("php://input"));

			if ($simVendor == null) {
				throw new Exception(json_get_error());
			}
			
			$sql = "
			UPDATE e_sim_vendor 
			SET 
			sim_vendor_name = :sim_vendor_name,
			sim_vendor_desc = :sim_vendor_desc, 
			e_nation_id = :e_nation_id
			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':sim_vendor_name', $simVendor->name, PDO::PARAM_STR);
			$query->bindParam(':sim_vendor_desc', $simVendor->desc, PDO::PARAM_STR);
			$query->bindParam(':e_nation_id', $simVendor->nation->id, PDO::PARAM_INT);
			
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
			DELETE FROM  e_sim_vendor 
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