<?php 

class UserInfo implements IQuery {

	public $Id;
	public $DtCreated;
	public $Email;
	public $Website;
	public $Telephone;
	public $UserSim;
	public $Address;


	
	public function __construct() {
	}

	public static function selectAll() {

		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM user_info;";
			$query = $connection->prepare($sql);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$userInfo = new UserInfo();
				$userInfo->Id = (int) $row['id'];
				$userInfo->DtCreated = $row['info_dt_created'];
				$userInfo->Email = $row['info_email'];
				$userInfo->Website = $row['info_website'];
				$userInfo->Telephone = $row['info_telephone'];
				$userInfo->UserSim = (int)$row['sim_id'];
				$userInfo->Address = (int)$row['address_id'];

				array_push($result, $userInfo);
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
			
			$sql = "SELECT * FROM user_info WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				Flight::notFound("id not found");
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);


			$userInfo = new UserInfo();
			$userInfo->Id = (int) $row['id'];
			$userInfo->DtCreated = $row['info_dt_created'];
			$userInfo->Email = $row['info_email'];
			$userInfo->Website = $row['info_website'];
			$userInfo->Telephone = $row['info_telephone'];
			$userInfo->UserSim = (int)$row['sim_id'];
			$userInfo->Address = (int)$row['address_id'];

			Flight::ok($userInfo);

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

			$userInfo = json_decode(file_get_contents("php://input"));

			if ($userInfo == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			INSERT INTO user_info 
			(info_dt_created, info_email, info_website, info_telephone, sim_id, address_id)
			VALUES
			(:info_dt_created, :info_email, :info_website, :info_telephone, :sim_id, :address_id);";


			$query = $connection->prepare($sql);

			$query->bindParam(':info_dt_created', $userInfo->DtCreated, PDO::PARAM_STR);
			$query->bindParam(':info_email', $userInfo->Email, PDO::PARAM_STR);
			$query->bindParam(':info_website', $userInfo->Website, PDO::PARAM_STR);
			$query->bindParam(':info_telephone', $userInfo->Telephone, PDO::PARAM_STR);
			$query->bindParam(':sim_id', $userInfo->UserSim, PDO::PARAM_INT);
			$query->bindParam(':address_id', $userInfo->Address, PDO::PARAM_INT);


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

			$userInfo = json_decode(file_get_contents("php://input"));

			if ($userInfo == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			UPDATE user_info 
			SET 
			info_dt_created = :info_dt_created,
			info_email = :info_email,
			info_website = :info_website,
			info_telephone = :info_telephone,
			sim_id = :sim_id,
			address_id = :address_id

			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':info_dt_created', $userInfo->DtCreated, PDO::PARAM_STR);
			$query->bindParam(':info_email', $userInfo->Email, PDO::PARAM_STR);
			$query->bindParam(':info_website', $userInfo->Website, PDO::PARAM_STR);
			$query->bindParam(':info_telephone', $userInfo->Telephone, PDO::PARAM_STR);
			$query->bindParam(':sim_id', $userInfo->UserSim, PDO::PARAM_INT);
			$query->bindParam(':address_id', $userInfo->Address, PDO::PARAM_INT);

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
			DELETE FROM user_info 
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