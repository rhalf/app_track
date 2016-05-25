<?php 

class UserSim implements IQuery {

	public $Id;
	public $Imei;
	public $Number;
	public $Roaming;
	public $AreaCode;
	public $SimVendor;
	public $User;



	public function __construct() {
	}

	public static function selectAll() {

		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM user_sim;";
			$query = $connection->prepare($sql);
			
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$userSim = new UserSim();
				$userSim->Id = (int) $row['id'];
				$userSim->Imei = (int) $row['sim_imei'];
				$userSim->Number = (int) $row['sim_number'];
				$userSim->Roaming = (bool) $row['sim_roaming'];
				$userSim->AreaCode = (int) $row['sim_area_code'];
				$userSim->SimVendor = (int) $row['e_sim_vendor_id'];
				$userSim->User = (int) $row['user_id'];


				array_push($result, $userSim);
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
			
			$sql = "SELECT * FROM user_sim WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				Flight::notFound("id not found");
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$userSim = new UserSim();
			$userSim->Id = (int) $row['id'];
			$userSim->Imei = (int) $row['sim_imei'];
			$userSim->Number = (int) $row['sim_number'];
			$userSim->Roaming = (bool) $row['sim_roaming'];
			$userSim->AreaCode = (int) $row['sim_area_code'];
			$userSim->SimVendor = (int) $row['e_sim_vendor_id'];
			$userSim->User = (int) $row['user_id'];

			Flight::ok($userSim);

		} catch (PDOException $pdoException) {
			Flight::error($pdoException);
		} catch (Exception $exception) {
			Flight::error($exception);
		} finally {
			$connection = null;
		}
	}

	public static function selectByUser($id) {

		$connection = Flight::dbMain();

		try {
			
			$sql = "SELECT * FROM user_sim WHERE user_id = :user_id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':user_id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				Flight::notFound("user_id not found");
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$userSim = new UserSim();
			$userSim->Id = (int) $row['id'];
			$userSim->Imei = (int) $row['sim_imei'];
			$userSim->Number = (int) $row['sim_number'];
			$userSim->Roaming = (bool) $row['sim_roaming'];
			$userSim->AreaCode = (int) $row['sim_area_code'];
			$userSim->SimVendor = (int) $row['e_sim_vendor_id'];
			$userSim->User = (int) $row['user_id'];

			Flight::ok($userSim);

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

			$userSim = json_decode(file_get_contents("php://input"));

			if ($userSim == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO user_sim 
			(sim_imei, sim_number, sim_roaming, sim_area_code, e_sim_vendor_id, user_id)
			VALUES
			(:sim_imei, :sim_number, :sim_roaming, :sim_area_code, :e_sim_vendor_id, :user_id);";


			$query = $connection->prepare($sql);

			$query->bindParam(':sim_imei', $userSim->Imei, PDO::PARAM_INT);
			$query->bindParam(':sim_number', $userSim->Number, PDO::PARAM_INT);
			$query->bindParam(':sim_roaming', $userSim->Roaming, PDO::PARAM_BOOL);
			$query->bindParam(':sim_area_code', $userSim->AreaCode, PDO::PARAM_INT);
			$query->bindParam(':e_sim_vendor_id', $userSim->SimVendor, PDO::PARAM_INT);
			$query->bindParam(':user_id', $userSim->User, PDO::PARAM_INT);


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

			$userSim = json_decode(file_get_contents("php://input"));

			if ($userSim == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE user_sim 
			SET
			sim_imei = :sim_imei,
			sim_number = :sim_number,
			sim_roaming = :sim_roaming,
			sim_area_code = :sim_area_code,
			e_sim_vendor_id = :e_sim_vendor_id,
			user_id = :user_id

			WHERE
			id = :id;";


			$query = $connection->prepare($sql);

			$query->bindParam(':sim_imei', $userSim->Imei, PDO::PARAM_INT);
			$query->bindParam(':sim_number', $userSim->Number, PDO::PARAM_INT);
			$query->bindParam(':sim_roaming', $userSim->Roaming, PDO::PARAM_BOOL);
			$query->bindParam(':sim_area_code', $userSim->AreaCode, PDO::PARAM_INT);
			$query->bindParam(':e_sim_vendor_id', $userSim->SimVendor, PDO::PARAM_INT);
			$query->bindParam(':user_id', $userSim->User, PDO::PARAM_INT);

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
			DELETE FROM user_sim 
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