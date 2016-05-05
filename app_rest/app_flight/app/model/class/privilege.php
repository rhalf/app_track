<?php 

class Privilege implements IQuery {

	public $Id;
	public $Name;
	public $Desc;
	public $Value;
	
	public function __construct() {
	}

	public static function selectAll() {

		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM e_privilege;";
			$query = $connection->prepare($sql);
			

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$privilege = new Privilege();
				$privilege->Id = (int) $row['id'];
				$privilege->Name = $row['privilege_name'];
				$privilege->Desc = $row['privilege_desc'];
				$privilege->Value = (int) $row['privilege_value'];
				
				array_push($result, $privilege);
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

			$sql = "SELECT * FROM e_privilege WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				Flight::notFound("id not found");
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$privilege = new Privilege();
			$privilege->Id = (int) $row['id'];
			$privilege->Name = $row['privilege_name'];
			$privilege->Desc = $row['privilege_desc'];
			$privilege->Value = (int) $row['privilege_value'];
			
			Flight::ok($privilege);

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

			$privilege = json_decode(file_get_contents("php://input"));

			if ($privilege == null) {
				throw new Exception(json_get_error());
			}

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

			$privilege = json_decode(file_get_contents("php://input"));

			if ($privilege == null) {
				throw new Exception(json_get_error());
			}

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
			DELETE FROM e_privilege 
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