<?php 

class User implements IQuery {

	public $Id;
	public $Name;
	public $Password;
	public $Hash;
	public $DtCreated;
	public $DtExpired;
	public $Privilege;
	public $Status;
	public $Company;
	public $Sim;



	
	public function __construct() {
	}

	public static function selectAll() {

		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM user;";
			$query = $connection->prepare($sql);
			
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$user = new User();
				$user->Id = (int) $row['id'];
				$user->Name = $row['user_name'];
				$user->DtCreated = $row['user_dt_created'];
				$user->DtExpired = $row['user_dt_expired'];
				// $user->Privilege = (int) $row['e_privilege_id'];
				// $user->Status = (int) $row['e_status_id'];
				// $user->Company = (int) $row['company_id'];
				// $user->Sim = $row['sim_id'] == null ? null : (int) $row['sim_id'];
				$user->Privilege = Privilege::select($row['e_privilege_id']);
				$user->Status = Status::select($row['e_status_id']);
				$user->Company = Company::select($row['company_id']);
				$user->Sim = Sim::select($row['sim_id']);


				array_push($result, $user);
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
			
			$sql = "SELECT * FROM user WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$user = new User();
			$user->Id = (int) $row['id'];
			$user->Name = $row['user_name'];
			$user->DtCreated = $row['user_dt_created'];
			$user->DtExpired = $row['user_dt_expired'];
			// $user->Privilege = (int) $row['e_privilege_id'];
			// $user->Status = (int) $row['e_status_id'];
			// $user->Company = (int) $row['company_id'];
			// $user->Sim = $row['sim_id'] == null ? null : (int) $row['sim_id'];
			$user->Privilege = Privilege::select($row['e_privilege_id']);
			$user->Status = Status::select($row['e_status_id']);
			$user->Company = Company::select($row['company_id']);
			$user->Sim = Sim::select($row['sim_id']);

			return $user;

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

			$sql = "SELECT * FROM user WHERE company_id = :company;";
			$query = $connection->prepare($sql);
			$query->bindParam(':company',$id, PDO::PARAM_INT);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$user = new User();
				$user->Id = (int) $row['id'];
				$user->Name = $row['user_name'];
				$user->DtCreated = $row['user_dt_created'];
				$user->DtExpired = $row['user_dt_expired'];
				// $user->Privilege = (int) $row['e_privilege_id'];
				// $user->Status = (int) $row['e_status_id'];
				// $user->Company = (int) $row['company_id'];
				// $user->Sim = $row['sim_id'] == null ? null : (int) $row['sim_id'];
				$user->Privilege = Privilege::select($row['e_privilege_id']);
				$user->Status = Status::select($row['e_status_id']);
				$user->Company = Company::select($row['company_id']);
				$user->Sim = Sim::select($row['sim_id']);

				array_push($result, $user);
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

			$user = json_decode(file_get_contents("php://input"));

			if ($user == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO user 
			(user_name, user_password, user_dt_created, user_dt_expired, e_privilege_id, e_status_id, company_id, sim_id)
			VALUES
			(:user_name, :user_password, :user_dt_created, :user_dt_expired, :e_privilege_id, :e_status_id, :company_id, :sim_id);";


			$query = $connection->prepare($sql);

			$query->bindParam(':user_name', $user->Name, PDO::PARAM_STR);

			$password = hash('sha256', $user->Password);
			$query->bindParam(':user_password', $password, PDO::PARAM_STR);

			$query->bindParam(':user_dt_created', $dateTime, PDO::PARAM_STR);
			$query->bindParam(':user_dt_expired', $user->DtExpired, PDO::PARAM_STR);
			// $query->bindParam(':e_privilege_id', $user->Privilege, PDO::PARAM_INT);
			// $query->bindParam(':e_status_id', $user->Status, PDO::PARAM_INT);
			// $query->bindParam(':company_id', $user->Company, PDO::PARAM_INT);
			// $query->bindParam(':sim_id', $user->Sim, PDO::PARAM_INT);
			$query->bindParam(':e_privilege_id', $user->Privilege->Id, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $user->Status->Id, PDO::PARAM_INT);
			$query->bindParam(':company_id', $user->Company->Id, PDO::PARAM_INT);
			$query->bindParam(':sim_id', $user->Sim->Id, PDO::PARAM_INT);

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

			$user = json_decode(file_get_contents("php://input"));

			if ($user == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			UPDATE user 
			SET 
			user_name = :user_name,
			user_dt_expired = :user_dt_expired,
			e_privilege_id = :e_privilege_id,
			e_status_id = :e_status_id,
			company_id = :company_id,
			sim_id = :sim_id

			WHERE
			id = :id;";


			$query = $connection->prepare($sql);

			$query->bindParam(':user_name', $user->Name, PDO::PARAM_STR);
			$query->bindParam(':user_dt_expired', $user->DtExpired, PDO::PARAM_STR);
			// $query->bindParam(':e_privilege_id', $user->Privilege, PDO::PARAM_INT);
			// $query->bindParam(':e_status_id', $user->Status, PDO::PARAM_INT);
			// $query->bindParam(':company_id', $user->Company, PDO::PARAM_INT);
			// $query->bindParam(':sim_id', $user->Sim, PDO::PARAM_INT);
			$query->bindParam(':e_privilege_id', $user->Privilege->Id, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $user->Status->Id, PDO::PARAM_INT);
			$query->bindParam(':company_id', $user->Company->Id, PDO::PARAM_INT);
			$query->bindParam(':sim_id', $user->Sim->Id, PDO::PARAM_INT);

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
	
	public static function updateCredential($id) {

		$connection = Flight::dbMain();

		try {

			$user = json_decode(file_get_contents("php://input"));

			if ($user == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			UPDATE user 
			SET 

			user_password = :user_password

			WHERE
			id = :id;";


			$query = $connection->prepare($sql);

			$password = hash('sha256', $user->Password);
			$query->bindParam(':user_password', $password, PDO::PARAM_STR);

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
			DELETE FROM user 
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