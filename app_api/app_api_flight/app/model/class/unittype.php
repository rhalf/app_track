<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class unitType and supplies the requests such as select, insert, update & delete.
*/
class UnitType implements IQuery {

	public $id;
	public $name;
	public $desc;
	public $brand;
	
	
	public function __construct() {
	}

	
	public static function selectAll() {

		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM e_unit_type;";
			$query = $connection->prepare($sql);
			
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$unitType = new UnitType();
				$unitType->id = (int) $row['id'];
				$unitType->name = $row['unit_type_name'];
				$unitType->desc = $row['unit_type_desc'];
				$unitType->brand = $row['unit_type_brand'];
				
				array_push($result, $unitType);
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

			$sql = "SELECT * FROM e_unit_type WHERE id = :id;";
			$query = $connection->prepare($sql);
			
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$unitType = new UnitType();
			$unitType->id = (int) $row['id'];
			$unitType->name = $row['unit_type_name'];
			$unitType->desc = $row['unit_type_desc'];
			$unitType->brand = $row['unit_type_brand'];

			return $unitType;

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

			$unitType = json_decode(file_get_contents("php://input"));

			if ($unitType == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO e_unit_type 
			(unit_type_name, unit_type_desc, unit_type_brand)
			VALUES
			(:unit_type_name, :unit_type_desc, :unit_type_brand);";

			$query = $connection->prepare($sql);

			$query->bindParam(':unit_type_name', $unitType->name, PDO::PARAM_STR);
			$query->bindParam(':unit_type_desc', $unitType->desc, PDO::PARAM_STR);
			$query->bindParam(':unit_type_brand',$unitType->brand, PDO::PARAM_STR);
			
			
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

			$unitType = json_decode(file_get_contents("php://input"));

			if ($unitType == null) {
				throw new Exception(json_get_error());
			}

			
			$sql = "
			UPDATE e_unit_type 
			SET 
			unit_type_name = :unit_type_name,
			unit_type_desc = :unit_type_desc, 
			unit_type_brand = :unit_type_brand
			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':unit_type_name', $unitType->name, PDO::PARAM_STR);
			$query->bindParam(':unit_type_desc', $unitType->desc, PDO::PARAM_STR);
			$query->bindParam(':unit_type_brand', $unitType->brand, PDO::PARAM_STR);

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
			DELETE FROM e_unit_type 
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