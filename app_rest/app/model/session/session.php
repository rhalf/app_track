<?php 

class Session {

	public function __construct() {
	}

	public static function login(Url $url, $data) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {
			if (isset($data['name']) && isset($data['password'])) {

				$sql = "SELECT * FROM user WHERE user.user_name = :name and user.user_password = :password;";
				$query = $connection->prepare($sql);
				$query->bindParam(':name',$data['name'], PDO::PARAM_STR);

				$password = sha1($data['password']);

				$query->bindParam(':password',$password, PDO::PARAM_STR);
			} else {
				throw new Exception("Username or Password is not set");
			}

			$query->execute();

			$result = new Result();
			$result->Item = $query->rowCount();
			$result->Object = array();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);


			if ($query->rowCount() > 0) {

				$user = new User();
				$user->Id = (int) $rows[0]['id'];
				$user->Name = $rows[0]['user_name'];
				$user->Password = $rows[0]['user_password'];
				$user->Hash = $rows[0]['user_hash'];
				$user->DtCreated = $rows[0]['user_dt_created'];
				$user->DtExpired = $rows[0]['user_dt_expired'];
				$user->DtLogin = $rows[0]['user_dt_login'];
				$user->DtActive = $rows[0]['user_dt_active'];
				$user->Privilege = (int) $rows[0]['e_privilege_id'];
				$user->Status = (int) $rows[0]['e_status_id'];
				$user->Company = (int) $rows[0]['company_id'];
				$user->Info = (int) $rows[0]['user_info_id'];

				$result->Status = Result::SUCCESS;
				$result->Message = 'Done.';

				array_push($result->Object, $user);

				//Session
				session_start();
				$_SESSION['user'] = $user;

			} else {
				//Session
				if (isset($_SESSION)){
					session_destroy();
				}
				throw new Exception("Unknown AppUser Name and Password");
			}

		} catch (PDOException $pdoException) {

			//Session
			if (isset($_SESSION)){
				session_destroy();
			}

			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $pdoException->getMessage();
		} catch (Exception $exception) {
			//Session
			if (isset($_SESSION)){
				session_destroy();
			}
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $exception->getMessage();
		}

		$connection = null;

		return $result;
	}

	public static function logout(Url $url, $data) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {

			session_destroy();

			$result = new Result();
			$result->Status = Result::SUCCESS;
			$result->Message = 'Done.';


		} catch (PDOException $pdoException) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $pdoException->getMessage();
		} catch (Exception $exception) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $exception->getMessage();
		}

		$connection = null;

		return $result;
	}

}

?>