<?php 

class SimVendor implements IQuery {

	public $Id;
	public $Name;
	public $Desc;
	public $Nation;
	
	
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
				$simVendor->Id = (int) $row['id'];
				$simVendor->Name = $row['sim_vendor_name'];
				$simVendor->Desc = $row['sim_vendor_desc'];
				$simVendor->Nation = (int) $row['e_nation_id'];
				

				array_push($result, $simVendor);
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

			$sql = "SELECT * FROM e_sim_vendor WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				Flight::notFound("id not found");
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$simVendor = new SimVendor();
			$simVendor->Id = (int) $row['id'];
			$simVendor->Name = $row['sim_vendor_name'];
			$simVendor->Desc = $row['sim_vendor_desc'];
			$simVendor->Nation = (int) $row['e_nation_id'];

			Flight::ok($simVendor);

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

			$query->bindParam(':sim_vendor_name', $simVendor->Name, PDO::PARAM_STR);
			$query->bindParam(':sim_vendor_desc', $simVendor->Desc, PDO::PARAM_STR);
			$query->bindParam(':e_nation_id', $simVendor->Nation, PDO::PARAM_INT);
			
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

			$query->bindParam(':sim_vendor_name', $simVendor->Name, PDO::PARAM_STR);
			$query->bindParam(':sim_vendor_desc', $simVendor->Desc, PDO::PARAM_STR);
			$query->bindParam(':e_nation_id', $simVendor->Nation, PDO::PARAM_INT);
			
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
			DELETE FROM  e_sim_vendor 
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