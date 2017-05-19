<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class session and supplies the requests such as select, insert, update & delete.
*/
class Session implements IQuery {


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

			$password = hash('sha256', $session->password);

			$query->bindParam(':name', $session->name, PDO::PARAM_STR);
			$query->bindParam(':password', $password , PDO::PARAM_STR);

			$query->execute();

			$row = $query->fetch(PDO::FETCH_ASSOC);

			if ($query->rowCount() < 1) {
				throw new Exception("Username or password does not exist");
			}

			$user = new User();
			$user->id = (int) $row['id'];
			$user->name = $row['user_name'];
			$user->dtCreated = $row['user_dt_created'];
			$user->dtExpired = $row['user_dt_expired'];
			// $user->Privilege = (int) $row['e_privilege_id'];
			// $user->Status = (int) $row['e_status_id'];
			// $user->Company = (int) $row['company_id'];
			// $user->Sim = $row['sim_id'] == null ? null : (int) $row['sim_id'];
			$user->privilege = Privilege::select($row['e_privilege_id']);
			$user->status = Status::select($row['e_status_id']);
			$user->company = Company::select($row['company_id']);
			$user->sim = Sim::select($row['sim_id']);


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
			$result->status = Result::SUCCESS;
			$result->message = 'Done';
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