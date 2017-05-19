<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class sim and supplies the requests such as select, insert, update & delete.
*/
class Sim implements IQuery {

	public $id;
	public $imei;
	public $number;
	public $roaming;
	public $countryCode;
	public $simVendor;
	public $status;
	public $dtCreated;
	public $company;


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
				$sim->id = (int) $row['id'];
				$sim->imei = $row['sim_imei'];
				$sim->number = $row['sim_number'];
				$sim->roaming = (bool) $row['sim_roaming'];
				$sim->dtCreated = $row['sim_dt_created'];

				$sim->simVendor = SimVendor::select($row['e_sim_vendor_id']);
				$sim->status = Status::select($row['e_status_id']);
				$sim->company = Company::select($row['company_id']);

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
			$sim->id =  (int) $row['id'];
			$sim->imei = $row['sim_imei'];
			$sim->number =  $row['sim_number'];
			$sim->roaming = (bool) $row['sim_roaming'];
			$sim->simVendor = SimVendor::select($row['e_sim_vendor_id']);
			$sim->dtCreated = $row['sim_dt_created'];
			
			$sim->status = Status::select($row['e_status_id']);
			$sim->company = Company::select($row['company_id']);

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
				$sim->id = (int) $row['id'];
				$sim->imei =  $row['sim_imei'];
				$sim->number = $row['sim_number'];
				$sim->roaming = (bool) $row['sim_roaming'];
				$sim->simVendor = SimVendor::select($row['e_sim_vendor_id']);
				$sim->dtCreated = $row['sim_dt_created'];

				$sim->status = Status::select($row['e_status_id']);
				$sim->company = Company::select($row['company_id']);


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

			$query->bindParam(':sim_imei', $sim->imei, PDO::PARAM_STR);
			$query->bindParam(':sim_number', $sim->number, PDO::PARAM_STR);
			$query->bindParam(':sim_roaming', $sim->roaming, PDO::PARAM_BOOL);
			$query->bindParam(':e_sim_vendor_id', $sim->simVendor->id, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $sim->status->id, PDO::PARAM_INT);
			$query->bindParam(':sim_dt_created', $dateTime, PDO::PARAM_STR);
			$query->bindParam(':company_id', $sim->company->id, PDO::PARAM_INT);



			$query->execute();
			
			$result = new Result();
			$result->status = Result::INSERTED;
			$result->id = (int)$connection->lastInsertid();
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

			$query->bindParam(':sim_imei', $sim->imei, PDO::PARAM_STR);
			$query->bindParam(':sim_number', $sim->number, PDO::PARAM_STR);
			$query->bindParam(':sim_roaming', $sim->roaming, PDO::PARAM_BOOL);
			$query->bindParam(':e_sim_vendor_id', $sim->simVendor->id, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $sim->status->id, PDO::PARAM_INT);
			$query->bindParam(':company_id', $sim->company->id, PDO::PARAM_INT);


			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->status = Result::UPDATED;
			$result->id = (int)$id;
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
			DELETE FROM sim 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->status = Result::DELETED;
			$result->message = 'Done';
			$result->id = (int)$id;

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