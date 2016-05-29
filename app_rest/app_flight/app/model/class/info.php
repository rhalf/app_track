<?php 

class Info implements IQuery {

	public $Id;
	public $Email;
	public $Website;
	public $Telephone;


	
	public function __construct() {
	}

	public static function selectAll() {

		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM info;";
			$query = $connection->prepare($sql);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$userInfo = new Info();
				$userInfo->Id = (int) $row['id'];
				$userInfo->Email = $row['info_email'];
				$userInfo->Website = $row['info_website'];
				$userInfo->Telephone = $row['info_telephone'];


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
			
			$sql = "SELECT * FROM info WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				Flight::notFound("id not found");
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);


			$userInfo = new Info();
			$userInfo->Id = (int) $row['id'];
			$userInfo->Email = $row['info_email'];
			$userInfo->Website = $row['info_website'];
			$userInfo->Telephone = $row['info_telephone'];
			
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
			INSERT INTO info 
			(info_email, info_website, info_telephone)
			VALUES
			(:info_email, :info_website, :info_telephone);";


			$query = $connection->prepare($sql);

			$query->bindParam(':info_email', $userInfo->Email, PDO::PARAM_STR);
			$query->bindParam(':info_website', $userInfo->Website, PDO::PARAM_STR);
			$query->bindParam(':info_telephone', $userInfo->Telephone, PDO::PARAM_STR);



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

			$userInfo = json_decode(file_get_contents("php://input"));

			if ($userInfo == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE info 
			SET 
			info_email = :info_email,
			info_website = :info_website,
			info_telephone = :info_telephone

			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':info_email', $userInfo->Email, PDO::PARAM_STR);
			$query->bindParam(':info_website', $userInfo->Website, PDO::PARAM_STR);
			$query->bindParam(':info_telephone', $userInfo->Telephone, PDO::PARAM_STR);

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
			DELETE FROM info 
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