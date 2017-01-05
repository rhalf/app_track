<?php 

class Route implements IQuery {

	public $Id;
	public $Name;
	public $Desc;
	public $Coordinates;
	public $SpeedMinL;
	public $SpeedMaxL;
	public $SpeedMinH;
	public $SpeedMaxH;
	public $IsVisible;
	public $Company;

	public function __construct() {
	}

	public static function selectAll() {

		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM route;";
			$query = $connection->prepare($sql);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$route = new Route();
				$route->Id = (int) $row['id'];
				$route->Name = $row['route_name'];
				$route->Desc = $row['route_description'];
				$route->Coordinates = json_decode($row['route_coordinates']);

				$route->SpeedMinL =  (int) $row['route_speed_min_l'];
				$route->SpeedMaxL = (int) $row['route_speed_max_l'];
				$route->SpeedMinH = (int) $row['route_speed_min_h'];
				$route->SpeedMaxH = (int) $row['route_speed_max_h'];

				$route->IsVisible = (bool) $row['route_is_visible'];
				$route->Company = Company::select($row['company_id']);

				array_push($result, $route);
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

			$sql = "SELECT * FROM route WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$route = new Route();
			$route->Id = (int) $row['id'];
			$route->Name = $row['route_name'];
			$route->Desc = $row['route_description'];
			$route->Coordinates = json_decode($row['route_coordinates']);

			$route->SpeedMinL =  (int) $row['route_speed_min_l'];
			$route->SpeedMaxL = (int) $row['route_speed_max_l'];
			$route->SpeedMinH = (int) $row['route_speed_min_h'];
			$route->SpeedMaxH = (int) $row['route_speed_max_h'];

			$route->IsVisible = (bool) $row['route_is_visible'];
			$route->Company = Company::select($row['company_id']);


			return $route;

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

			$sql = "SELECT * FROM route WHERE company_id = :company_id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':company_id',$id, PDO::PARAM_INT);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$route = new Route();
				$route->Id = (int) $row['id'];
				$route->Name = $row['route_name'];
				$route->Desc = $row['route_description'];
				$route->Coordinates = json_decode($row['route_coordinates']);

				$route->SpeedMinL =  (int) $row['route_speed_min_l'];
				$route->SpeedMaxL = (int) $row['route_speed_max_l'];
				$route->SpeedMinH = (int) $row['route_speed_min_h'];
				$route->SpeedMaxH = (int) $row['route_speed_max_h'];

				$route->IsVisible = (bool) $row['route_is_visible'];
				$route->Company = Company::select($row['company_id']);

				array_push($result, $route);
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

		try {

			$route = json_decode(file_get_contents("php://input"));

			if ($route == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO route 
			(route_name, route_description,route_coordinates,route_is_visible,company_id, route_speed_min_l, route_speed_max_l, route_speed_min_h, route_speed_max_h)
			VALUES
			(:route_name, :route_description, :route_coordinates, :route_is_visible, :company_id, :route_speed_min_l, :route_speed_max_l, :route_speed_min_h, :route_speed_max_h);";


			$query = $connection->prepare($sql);

			$query->bindParam(':route_name', $route->Name, PDO::PARAM_STR);
			$query->bindParam(':route_description', $route->Desc, PDO::PARAM_STR);

			$json = json_encode($route->Coordinates);
			$query->bindParam(':route_coordinates', $json, PDO::PARAM_STR);

			$query->bindParam(':route_speed_min_l', $route->SpeedMinL, PDO::PARAM_INT);
			$query->bindParam(':route_speed_max_l', $route->SpeedMaxL, PDO::PARAM_INT);
			$query->bindParam(':route_speed_min_h', $route->SpeedMinH, PDO::PARAM_INT);
			$query->bindParam(':route_speed_max_h', $route->SpeedMaxH, PDO::PARAM_INT);

			$query->bindParam(':route_is_visible', $route->IsVisible, PDO::PARAM_BOOL);
			$query->bindParam(':company_id', $route->Company->Id, PDO::PARAM_INT);


			$query->execute();
			
			$result = new Result();
			$result->Status = Result::INSERTED;
			$result->Id = $connection->lastInsertId();
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

			$route = json_decode(file_get_contents("php://input"));

			if ($route == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			UPDATE route 
			SET 
			route_name = :route_name,
			route_description = :route_description,
			route_coordinates = :route_coordinates,
			route_is_visible = :route_is_visible,
			route_speed_min_l = :route_speed_min_l,
			route_speed_max_l = :route_speed_max_l,
			route_speed_min_h = :route_speed_min_h,
			route_speed_max_h = :route_speed_max_h,
			company_id = :company_id
			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':route_name', $route->Name, PDO::PARAM_STR);
			$query->bindParam(':route_description', $route->Desc, PDO::PARAM_STR);

			$json = json_encode($route->Coordinates);
			$query->bindParam(':route_coordinates', $json, PDO::PARAM_STR);

			$query->bindParam(':route_speed_min_l', $route->SpeedMinL, PDO::PARAM_INT);
			$query->bindParam(':route_speed_max_l', $route->SpeedMaxL, PDO::PARAM_INT);
			$query->bindParam(':route_speed_min_h', $route->SpeedMinH, PDO::PARAM_INT);
			$query->bindParam(':route_speed_max_h', $route->SpeedMaxH, PDO::PARAM_INT);
			
			$query->bindParam(':route_is_visible', $route->IsVisible, PDO::PARAM_BOOL);
			$query->bindParam(':company_id', $route->Company->Id, PDO::PARAM_INT);
			
			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::UPDATED;
			$result->Id = $id;
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
			DELETE FROM route 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::DELETED;
			$result->Message = 'Done';
			$result->Id = $id;

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