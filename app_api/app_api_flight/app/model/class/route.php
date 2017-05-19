<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class route and supplies the requests such as select, insert, update & delete.
*/
class Route implements IQuery {

	public $id;
	public $name;
	public $desc;
	public $Coordinates;
	public $speedMinL;
	public $speedMaxL;
	public $speedMinH;
	public $speedMaxH;
	public $isVisible;
	public $company;

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
				$route->id = (int) $row['id'];
				$route->name = $row['route_name'];
				$route->desc = $row['route_description'];
				$route->coordinates = json_decode($row['route_coordinates']);

				$route->speedMinL =  (int) $row['route_speed_min_l'];
				$route->speedMaxL = (int) $row['route_speed_max_l'];
				$route->speedMinH = (int) $row['route_speed_min_h'];
				$route->speedMaxH = (int) $row['route_speed_max_h'];

				$route->isVisible = (bool) $row['route_is_visible'];
				$route->company = Company::select($row['company_id']);

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
			$route->id = (int) $row['id'];
			$route->name = $row['route_name'];
			$route->desc = $row['route_description'];
			$route->coordinates = json_decode($row['route_coordinates']);

			$route->speedMinL =  (int) $row['route_speed_min_l'];
			$route->speedMaxL = (int) $row['route_speed_max_l'];
			$route->speedMinH = (int) $row['route_speed_min_h'];
			$route->speedMaxH = (int) $row['route_speed_max_h'];

			$route->isVisible = (bool) $row['route_is_visible'];
			$route->company = Company::select($row['company_id']);


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
				$route->id = (int) $row['id'];
				$route->name = $row['route_name'];
				$route->desc = $row['route_description'];
				$route->coordinates = json_decode($row['route_coordinates']);

				$route->speedMinL =  (int) $row['route_speed_min_l'];
				$route->speedMaxL = (int) $row['route_speed_max_l'];
				$route->speedMinH = (int) $row['route_speed_min_h'];
				$route->speedMaxH = (int) $row['route_speed_max_h'];

				$route->isVisible = (bool) $row['route_is_visible'];
				$route->company = Company::select($row['company_id']);

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

			$query->bindParam(':route_name', $route->name, PDO::PARAM_STR);
			$query->bindParam(':route_description', $route->desc, PDO::PARAM_STR);

			$json = json_encode($route->coordinates);
			$query->bindParam(':route_coordinates', $json, PDO::PARAM_STR);

			$query->bindParam(':route_speed_min_l', $route->speedMinL, PDO::PARAM_INT);
			$query->bindParam(':route_speed_max_l', $route->speedMaxL, PDO::PARAM_INT);
			$query->bindParam(':route_speed_min_h', $route->speedMinH, PDO::PARAM_INT);
			$query->bindParam(':route_speed_max_h', $route->speedMaxH, PDO::PARAM_INT);

			$query->bindParam(':route_is_visible', $route->isVisible, PDO::PARAM_BOOL);
			$query->bindParam(':company_id', $route->company->id, PDO::PARAM_INT);


			$query->execute();
			
			$result = new Result();
			$result->status = Result::INSERTED;
			$result->id = $connection->lastInsertid();
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

			$query->bindParam(':route_name', $route->name, PDO::PARAM_STR);
			$query->bindParam(':route_description', $route->desc, PDO::PARAM_STR);

			$json = json_encode($route->coordinates);
			$query->bindParam(':route_coordinates', $json, PDO::PARAM_STR);

			$query->bindParam(':route_speed_min_l', $route->speedMinL, PDO::PARAM_INT);
			$query->bindParam(':route_speed_max_l', $route->speedMaxL, PDO::PARAM_INT);
			$query->bindParam(':route_speed_min_h', $route->speedMinH, PDO::PARAM_INT);
			$query->bindParam(':route_speed_max_h', $route->speedMaxH, PDO::PARAM_INT);
			
			$query->bindParam(':route_is_visible', $route->isVisible, PDO::PARAM_BOOL);
			$query->bindParam(':company_id', $route->company->id, PDO::PARAM_INT);
			
			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->status = Result::UPDATED;
			$result->id = $id;
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
			DELETE FROM route 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->status = Result::DELETED;
			$result->message = 'Done';
			$result->id = $id;

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