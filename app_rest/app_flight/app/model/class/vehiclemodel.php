<?php 

class VehicleModel implements IQuery {

	public $Id;
	public $Name;
	public $Brand;
	public $Desc;
	public $Type;
	public $Categ;

	public function __construct() {
	}

	public static function selectAll() {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM vehicle_model;";
			$query = $connection->prepare($sql);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$vehicleModel = new VehicleModel();
				$vehicleModel->Id = (int) $row['id'];
				$vehicleModel->Name = $row['model_name'];
				$vehicleModel->Desc = $row['model_desc'];
				$vehicleModel->Brand = $row['model_brand'];
				$vehicleModel->Type = $row['model_type'];
				$vehicleModel->Categ = (int) $row['model_category'];

				array_push($result, $vehicleModel);
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

			$sql = "SELECT * FROM vehicle_model WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				Flight::notFound("id not found");
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$vehicleModel = new VehicleModel();
			$vehicleModel->Id = (int) $row['id'];
			$vehicleModel->Name = $row['model_name'];
			$vehicleModel->Desc = $row['model_desc'];
			$vehicleModel->Brand = $row['model_brand'];
			$vehicleModel->Type = $row['model_type'];
			$vehicleModel->Categ = (int) $row['model_category'];

			Flight::ok($vehicleModel);

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

			$vehicleModel = json_decode(file_get_contents("php://input"));

			if ($vehicleModel == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO vehicle_model 
			(model_name, model_desc, model_brand, model_type, model_category)
			VALUES
			(:model_name, :model_desc, :model_brand, :model_type, :model_category);";


			$query = $connection->prepare($sql);

			$query->bindParam(':model_name', $vehicleModel->Name, PDO::PARAM_STR);
			$query->bindParam(':model_desc', $vehicleModel->Desc, PDO::PARAM_STR);
			$query->bindParam(':model_brand', $vehicleModel->Brand, PDO::PARAM_STR);
			$query->bindParam(':model_type', $vehicleModel->Type, PDO::PARAM_STR);
			$query->bindParam(':model_category', $vehicleModel->Categ, PDO::PARAM_INT);


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

			$vehicleModel = json_decode(file_get_contents("php://input"));

			if ($vehicleModel == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE vehicle_model 
			SET 
			model_name = :model_name,
			model_desc = :model_desc, 
			model_brand = :model_brand,
			model_type = :model_type, 
			model_category = :model_category
			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':model_name', $vehicleModel->Name, PDO::PARAM_STR);
			$query->bindParam(':model_desc', $vehicleModel->Desc, PDO::PARAM_STR);
			$query->bindParam(':model_brand', $vehicleModel->Brand, PDO::PARAM_STR);
			$query->bindParam(':model_type', $vehicleModel->Type, PDO::PARAM_STR);
			$query->bindParam(':model_category', $vehicleModel->Categ, PDO::PARAM_INT);

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
			DELETE FROM vehicle_model 
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