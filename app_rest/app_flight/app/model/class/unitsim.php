<?php 

class UnitSim implements IQuery {

	public $Id;
	public $Imei;
	public $Number;
	public $Roaming;
	public $AreaCode;
	public $SimVendor;


	public function __construct() {
	}

	public static function selectAll() {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM unit_sim;";
			$query = $connection->prepare($sql);

			
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$unitSim = new UnitSim();
				$unitSim->Id = (int) $row['id'];
				$unitSim->Imei = (int) $row['sim_imei'];
				$unitSim->Number = (int) $row['sim_number'];
				$unitSim->Roaming = (bool) $row['sim_roaming'];
				$unitSim->AreaCode = (int) $row['sim_area_code'];
				$unitSim->SimVendor = (int) $row['e_sim_vendor_id'];

				array_push($result, $unitSim);
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

	public static  function select($id) {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM unit_sim WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				Flight::notFound("id not found");
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$unitSim = new UnitSim();
			$unitSim->Id = (int) $row['id'];
			$unitSim->Imei = (int) $row['sim_imei'];
			$unitSim->Number = (int) $row['sim_number'];
			$unitSim->Roaming = (bool) $row['sim_roaming'];
			$unitSim->AreaCode = (int) $row['sim_area_code'];
			$unitSim->SimVendor = (int) $row['e_sim_vendor_id'];


			Flight::ok($unitSim);

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

			$unitSim = json_decode(file_get_contents("php://input"));

			if ($unitSim == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO unit_sim 
			(sim_imei, sim_number, sim_roaming, sim_area_code, e_sim_vendor_id)
			VALUES
			(:sim_imei, :sim_number, :sim_roaming, :sim_area_code, :e_sim_vendor_id);";


			$query = $connection->prepare($sql);

			$query->bindParam(':sim_imei', $unitSim->Imei, PDO::PARAM_INT);
			$query->bindParam(':sim_number', $unitSim->Number, PDO::PARAM_INT);
			$query->bindParam(':sim_roaming', $unitSim->Roaming, PDO::PARAM_BOOL);
			$query->bindParam(':sim_area_code', $unitSim->AreaCode, PDO::PARAM_INT);
			$query->bindParam(':e_sim_vendor_id', $unitSim->SimVendor, PDO::PARAM_INT);

			
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

			$unitSim = json_decode(file_get_contents("php://input"));

			if ($unitSim == null) {
				throw new Exception(json_get_error());
			}


			$sql = "

			UPDATE unit_sim 
			SET
			sim_imei = :sim_imei,
			sim_number = :sim_number,
			sim_roaming = :sim_roaming,
			sim_area_code = :sim_area_code,
			e_sim_vendor_id = :e_sim_vendor_id

			WHERE
			id = :id;";


			$query = $connection->prepare($sql);

			$query->bindParam(':sim_imei', $unitSim->Imei, PDO::PARAM_INT);
			$query->bindParam(':sim_number', $unitSim->Number, PDO::PARAM_INT);
			$query->bindParam(':sim_roaming', $unitSim->Roaming, PDO::PARAM_BOOL);
			$query->bindParam(':sim_area_code', $unitSim->AreaCode, PDO::PARAM_INT);
			$query->bindParam(':e_sim_vendor_id', $unitSim->SimVendor, PDO::PARAM_INT);

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
			DELETE FROM unit_sim 
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