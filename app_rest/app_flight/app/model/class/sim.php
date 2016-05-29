<?php 

class Sim implements IQuery {

	public $Id;
	public $Imei;
	public $Number;
	public $Roaming;
	public $CountryCode;
	public $SimVendor;
	public $Status;
	public $DtCreated;


	public function __construct() {
	}

	public static function selectAll() {

		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM sim;";
			$query = $connection->prepare($sql);
			
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$sim = new Sim();
				$sim->Id = (int) $row['id'];
				$sim->Imei = (int) $row['sim_imei'];
				$sim->Number = (int) $row['sim_number'];
				$sim->Roaming = (bool) $row['sim_roaming'];
				$sim->SimVendor = (int) $row['e_sim_vendor_id'];
				$sim->Status = (int) $row['e_status_id'];
				$sim->DtCreated = $row['sim_dt_created'];

				array_push($result, $sim);
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
			
			$sql = "SELECT * FROM sim WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				Flight::notFound("id not found");
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$sim = new Sim();
			$sim->Id = (int) $row['id'];
			$sim->Imei = (int) $row['sim_imei'];
			$sim->Number = (int) $row['sim_number'];
			$sim->Roaming = (bool) $row['sim_roaming'];
			$sim->SimVendor = (int) $row['e_sim_vendor_id'];
			$sim->Status = (int) $row['e_status_id'];
			$sim->DtCreated = $row['sim_dt_created'];
			

			Flight::ok($sim);

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
		$dateTime = Flight::dateTime();

		try {

			$sim = json_decode(file_get_contents("php://input"));

			if ($sim == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO sim 
			(sim_imei, sim_number, sim_roaming,  e_sim_vendor_id, e_status_id, sim_dt_created)
			VALUES
			(:sim_imei, :sim_number, :sim_roaming, :e_sim_vendor_id, :e_status_id, :sim_dt_created);";


			$query = $connection->prepare($sql);

			$query->bindParam(':sim_imei', $sim->Imei, PDO::PARAM_INT);
			$query->bindParam(':sim_number', $sim->Number, PDO::PARAM_INT);
			$query->bindParam(':sim_roaming', $sim->Roaming, PDO::PARAM_BOOL);
			$query->bindParam(':e_sim_vendor_id', $sim->SimVendor, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $sim->Status, PDO::PARAM_INT);
			$query->bindParam(':sim_dt_created', $dateTime, PDO::PARAM_STR);


			$query->execute();
			
			$result = new Result();
			$result->Status = Result::INSERTED;
			$result->Id = (int)$connection->lastInsertId();
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

			$sim = json_decode(file_get_contents("php://input"));

			if ($sim == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE sim 
			SET
			sim_imei = :sim_imei,
			sim_number = :sim_number,
			sim_roaming = :sim_roaming,
			e_sim_vendor_id = :e_sim_vendor_id,
			e_status_id = :e_status_id

			WHERE
			id = :id;";


			$query = $connection->prepare($sql);

			$query->bindParam(':sim_imei', $sim->Imei, PDO::PARAM_INT);
			$query->bindParam(':sim_number', $sim->Number, PDO::PARAM_INT);
			$query->bindParam(':sim_roaming', $sim->Roaming, PDO::PARAM_BOOL);
			$query->bindParam(':e_sim_vendor_id', $sim->SimVendor, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $sim->Status, PDO::PARAM_INT);


			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::UPDATED;
			$result->Id = (int)$id;
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
			DELETE FROM sim 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::DELETED;
			$result->Message = 'Done';
			$result->Id = (int)$id;

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