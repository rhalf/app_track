<?php 

class Session {


	public function __construct() {
	}

	public static function login() {

		$connection = Flight::dbMain();

		try {

			$session = json_decode(file_get_contents("php://input"));

			if ($session == null) {
				throw new Exception(json_get_error());
			}

			

			$sql = "SELECT * FROM user WHERE user.user_name = :name and user.user_password = :password;";
			$query = $connection->prepare($sql);

			$password = hash('sha256', $session->Password);

			$query->bindParam(':name', $session->Name, PDO::PARAM_STR);
			$query->bindParam(':password', $password , PDO::PARAM_STR);

			$query->execute();

			$row = $query->fetch(PDO::FETCH_ASSOC);

			if ($query->rowCount() < 1) {
				throw new Exception("Username or Password is not exist");
			}

			$user = new User();
			$user->Id = (int) $row['id'];
			$user->Name = $row['user_name'];
			$user->DtCreated = $row['user_dt_created'];
			$user->DtExpired = $row['user_dt_expired'];
			$user->Privilege = (int) $row['e_privilege_value'];
			$user->Status = (int) $row['e_status_value'];
			$user->Company = (int) $row['company_id'];
			$user->Sim = (int) $row['sim_id'];


			Flight::ok($user);

		} catch (PDOException $pdoException) {
			Flight::error($pdoException);
		} catch (Exception $exception) {
			Flight::error($exception);
		} finally {
			$connection = null;
		}
	}

	public static function logout() {

		$connection = Flight::dbMain();

		try {

			// $sql = "
			// DELETE FROM user 
			// WHERE
			// id = :id";

			// $query = $connection->prepare($sql);

			// $query->bindParam(':id', $id, PDO::PARAM_INT);

			// $query->execute();

			$result = new Result();
			$result->Status = Result::SUCCESS;
			$result->Message = 'Done';
			//$result->Id = $id;

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