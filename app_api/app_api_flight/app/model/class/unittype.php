<?php 

class UnitType implements IQuery {

	public $Id;
	public $Name;
	public $Desc;
	public $Brand;
	
	
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
				$unitType->Id = (int) $row['id'];
				$unitType->Name = $row['unit_type_name'];
				$unitType->Desc = $row['unit_type_desc'];
				$unitType->Brand = $row['unit_type_brand'];
				
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
			$unitType->Id = (int) $row['id'];
			$unitType->Name = $row['unit_type_name'];
			$unitType->Desc = $row['unit_type_desc'];
			$unitType->Brand = $row['unit_type_brand'];

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

			$query->bindParam(':unit_type_name', $unitType->Name, PDO::PARAM_STR);
			$query->bindParam(':unit_type_desc', $unitType->Desc, PDO::PARAM_STR);
			$query->bindParam(':unit_type_brand',$unitType->Brand, PDO::PARAM_STR);
			
			
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

			$query->bindParam(':unit_type_name', $unitType->Name, PDO::PARAM_STR);
			$query->bindParam(':unit_type_desc', $unitType->Desc, PDO::PARAM_STR);
			$query->bindParam(':unit_type_brand', $unitType->Brand, PDO::PARAM_STR);

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
			DELETE FROM e_unit_type 
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