<?php 

class Route implements IQuery {

	public $Id;
	public $Name;
	public $Desc;
	public $Coordinates;
	public $IsVisible;
	public $IsGlobal;
	public $ComapnyId;

	public function __construct() {
	}

	public static function onSelect(Url $url, $data) {
		
		$connection = Flight::dbMain();

		try {

			if (!empty($url->Id)) {
				$sql = "SELECT * FROM route WHERE id = :id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':id',$url->Id, PDO::PARAM_INT);
			} else if (isset($data['name'])) {
				$sql = "SELECT * FROM route WHERE route_name LIKE :name;";
				$query = $connection->prepare($sql);
				$query->bindParam(':name',$data['name'], PDO::PARAM_STR);
			} else {
				$sql = "SELECT * FROM route;";
				$query = $connection->prepare($sql);
			}

			$query->execute();

			$result = new Result();
			$result->Item = $query->rowCount();
			$result->Object = array();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			foreach ($rows as $row) {	
				$route = new Route();
				$route->Id = (int) $row['id'];
				$route->Name = $row['route_name'];
				$route->Desc = $row['route_description'];
				$route->Coordinates = $row['route_coordinates'];
				$route->IsVisible = (bool) $row['route_is_visible'];
				$route->IsGlobal = (bool) $row['route_is_global'];
				$route->ComapnyId = (int) $row['company_id'];
				
				array_push($result->Object, $route);
			}

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
	public static function onInsert(Url $url, $data) {

		$connection = Flight::dbMain();

		try {

			if (!isset($data['Object'])) {
				throw new Exception("Input object is not set.");
			}

			$route = json_decode($data['Object']);
			if ($route == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO route 
			(route_name, route_description,route_coordinates,route_is_visible,route_is_global,company_id)
			VALUES
			(:route_name, :route_description, :route_coordinates, :route_is_visible, :route_is_global, :company_id);";


			$query = $connection->prepare($sql);

			$query->bindParam(':route_name', $route->Name, PDO::PARAM_STR);
			$query->bindParam(':route_description', $route->Desc, PDO::PARAM_STR);
			$query->bindParam(':route_coordinates', $route->Coordinates, PDO::PARAM_STR);
			$query->bindParam(':route_is_visible', $route->IsVisible, PDO::PARAM_BOOL);
			$query->bindParam(':route_is_global', $route->IsGlobal, PDO::PARAM_BOOL);
			$query->bindParam(':company_id', $route->ComapnyId, PDO::PARAM_INT);


			$query->execute();

			$result = new Result();
			$result->Status = Result::SUCCESS;
			$result->Item = $query->rowCount();
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
	public static function onUpdate(Url $url, $data) {
		
		$connection = Flight::dbMain();

		try {
			if (empty($url->Id)) {
				throw new Exception("Input id is empty.");
			}

			if (!isset($data['Object'])) {
				throw new Exception("Input object is not set.");
			}

			$route = json_decode($data['Object']);
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
			route_is_global = :route_is_global,
			company_id = :company_id
			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':route_name', $route->Name, PDO::PARAM_STR);
			$query->bindParam(':route_description', $route->Desc, PDO::PARAM_STR);
			$query->bindParam(':route_coordinates', $route->Coordinates, PDO::PARAM_STR);
			$query->bindParam(':route_is_visible', $route->IsVisible, PDO::PARAM_BOOL);
			$query->bindParam(':route_is_global', $route->IsGlobal, PDO::PARAM_BOOL);
			$query->bindParam(':company_id', $route->ComapnyId, PDO::PARAM_INT);
			$query->bindParam(':id', $url->Id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::SUCCESS;
			$result->Item = $query->rowCount();
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
	public static function onDelete(Url $url, $data) {
		
		$connection = Flight::dbMain();

		try {
			
			if (empty($url->Id)) {
				throw new Exception("Input id is empty");
			}

			$sql = "
			DELETE FROM route 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);

			$query->bindParam(':id', $url->Id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::SUCCESS;
			$result->Item = $query->rowCount();
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