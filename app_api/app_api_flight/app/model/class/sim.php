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
	public $Company;


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
				$sim->Imei = $row['sim_imei'];
				$sim->Number = $row['sim_number'];
				$sim->Roaming = (bool) $row['sim_roaming'];
				$sim->DtCreated = $row['sim_dt_created'];

				$sim->SimVendor = SimVendor::select($row['e_sim_vendor_id']);
				$sim->Status = Status::select($row['e_status_id']);
				$sim->Company = Company::select($row['company_id']);

				array_push($result, $sim);
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
			
			$sql = "SELECT * FROM sim WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$sim = new Sim();
			$sim->Id =  (int) $row['id'];
			$sim->Imei = $row['sim_imei'];
			$sim->Number =  $row['sim_number'];
			$sim->Roaming = (bool) $row['sim_roaming'];
			$sim->SimVendor = SimVendor::select($row['e_sim_vendor_id']);
			$sim->DtCreated = $row['sim_dt_created'];
			
			$sim->Status = Status::select($row['e_status_id']);
			$sim->Company = Company::select($row['company_id']);

			return $sim;

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

			$sql = "SELECT * FROM sim WHERE company_id = :company;";
			$query = $connection->prepare($sql);
			$query->bindParam(':company',$id, PDO::PARAM_INT);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	

				$sim = new Sim();
				$sim->Id = (int) $row['id'];
				$sim->Imei =  $row['sim_imei'];
				$sim->Number = $row['sim_number'];
				$sim->Roaming = (bool) $row['sim_roaming'];
				$sim->SimVendor = SimVendor::select($row['e_sim_vendor_id']);
				$sim->DtCreated = $row['sim_dt_created'];

				$sim->Status = Status::select($row['e_status_id']);
				$sim->Company = Company::select($row['company_id']);


				array_push($result, $sim);
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
		$dateTime = Flight::dateTime();

		try {

			$sim = json_decode(file_get_contents("php://input"));

			if ($sim == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO sim 
			(sim_imei, sim_number, sim_roaming,  e_sim_vendor_id, e_status_id, sim_dt_created, company_id)
			VALUES
			(:sim_imei, :sim_number, :sim_roaming, :e_sim_vendor_id, :e_status_id, :sim_dt_created, :company_id);";


			$query = $connection->prepare($sql);

			$query->bindParam(':sim_imei', $sim->Imei, PDO::PARAM_STR);
			$query->bindParam(':sim_number', $sim->Number, PDO::PARAM_STR);
			$query->bindParam(':sim_roaming', $sim->Roaming, PDO::PARAM_BOOL);
			$query->bindParam(':e_sim_vendor_id', $sim->SimVendor->Id, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $sim->Status->Id, PDO::PARAM_INT);
			$query->bindParam(':sim_dt_created', $dateTime, PDO::PARAM_STR);
			$query->bindParam(':company_id', $sim->Company->Id, PDO::PARAM_INT);



			$query->execute();
			
			$result = new Result();
			$result->Status = Result::INSERTED;
			$result->Id = (int)$connection->lastInsertId();
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
			e_status_id = :e_status_id,
			company_id = :company_id

			WHERE
			id = :id;";


			$query = $connection->prepare($sql);

			$query->bindParam(':sim_imei', $sim->Imei, PDO::PARAM_STR);
			$query->bindParam(':sim_number', $sim->Number, PDO::PARAM_STR);
			$query->bindParam(':sim_roaming', $sim->Roaming, PDO::PARAM_BOOL);
			$query->bindParam(':e_sim_vendor_id', $sim->SimVendor->Id, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $sim->Status->Id, PDO::PARAM_INT);
			$query->bindParam(':company_id', $sim->Company->Id, PDO::PARAM_INT);


			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::UPDATED;
			$result->Id = (int)$id;
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