<?php 

class Poi implements IQuery {

	public $Id;
	public $Company;
	public $Name;
	public $Desc;
	public $Latitude;
	public $Logitude;
	public $IsVisible;
	public $IsGlobal;
	public $Image;

	public function __construct() {
	}

	
	public static function selectAll() {

		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM poi;";
			$query = $connection->prepare($sql);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();


			foreach ($rows as $row) {	
				$poi = new Poi();
				$poi->Id = (int) $row['id'];
				$poi->Company = (int) $row['company_id'];
				$poi->Name = $row['poi_name'];
				$poi->Desc = $row['poi_desc'];
				$poi->Latitude = (double) $row['poi_latitude'];
				$poi->Logitude = (double) $row['poi_longitude'];
				$poi->IsVisible = (bool) $row['poi_is_visible'];
				$poi->IsGlobal = (bool) $row['poi_is_global'];
				$poi->Image = $row['poi_image'];
				
				array_push($result, $poi);
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

			$sql = "SELECT * FROM poi WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				Flight::notFound("id not found");
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$poi = new Poi();
			$poi->Id = (int) $row['id'];
			$poi->Company = (int) $row['company_id'];
			$poi->Name = $row['poi_name'];
			$poi->Desc = $row['poi_desc'];
			$poi->Latitude = (double) $row['poi_latitude'];
			$poi->Logitude = (double) $row['poi_longitude'];
			$poi->IsVisible = (bool) $row['poi_is_visible'];
			$poi->IsGlobal = (bool) $row['poi_is_global'];
			$poi->Image = $row['poi_image'];

			Flight::ok($poi);

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

			$poi = json_decode(file_get_contents("php://input"));

			if ($poi == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO poi 
			(company_id, poi_name,poi_desc,poi_latitude,poi_longitude,poi_is_visible,poi_is_global,poi_image)
			VALUES
			(:company_id, :poi_name, :poi_desc, :poi_latitude, :poi_longitude, :poi_is_visible, :poi_is_global, :poi_image);";


			$query = $connection->prepare($sql);

			$query->bindParam(':company_id', $poi->Company, PDO::PARAM_INT);
			$query->bindParam(':poi_name', $poi->Name, PDO::PARAM_STR);
			$query->bindParam(':poi_desc', $poi->Desc, PDO::PARAM_STR);
			$query->bindParam(':poi_latitude', $poi->Latitude, PDO::PARAM_INT);
			$query->bindParam(':poi_longitude', $poi->Logitude, PDO::PARAM_INT);
			$query->bindParam(':poi_is_visible', $poi->IsVisible, PDO::PARAM_BOOL);
			$query->bindParam(':poi_is_global', $poi->IsGlobal, PDO::PARAM_BOOL);
			$query->bindParam(':poi_image', $poi->Image, PDO::PARAM_STR);


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

			$poi = json_decode(file_get_contents("php://input"));

			if ($poi == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE poi 
			SET 
			company_id = :company_id,
			poi_name = :poi_name,
			poi_desc = :poi_desc,
			poi_latitude = :poi_latitude,
			poi_longitude = :poi_longitude,
			poi_is_visible = :poi_is_visible,
			poi_is_global = :poi_is_global,
			poi_image = :poi_image

			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':company_id', $poi->Company, PDO::PARAM_INT);
			$query->bindParam(':poi_name', $poi->Name, PDO::PARAM_STR);
			$query->bindParam(':poi_desc', $poi->Desc, PDO::PARAM_STR);
			$query->bindParam(':poi_latitude', $poi->Latitude, PDO::PARAM_INT);
			$query->bindParam(':poi_longitude', $poi->Logitude, PDO::PARAM_INT);
			$query->bindParam(':poi_is_visible', $poi->IsVisible, PDO::PARAM_BOOL);
			$query->bindParam(':poi_is_global', $poi->IsGlobal, PDO::PARAM_BOOL);
			$query->bindParam(':poi_image', $poi->Image, PDO::PARAM_STR);


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
			DELETE FROM poi 
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