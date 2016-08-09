<?php 

class Nation implements IQuery {

	public $Id;
	public $NameShort;
	public $NameLong;
	public $Iso2;
	public $Iso3;
	public $Number;
	public $Uno;
	public $CountryCode;
	public $Account;
	public $Language;
	public $Ethnic;
	public $Currency;


	public function __construct() {
	}

	public static function selectAll() {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM e_nation;";
			$query = $connection->prepare($sql);
			
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$nation = new Nation();
				$nation->Id = (int) $row['id'];
				$nation->NameShort = $row['nation_short'];
				$nation->NameLong = $row['nation_long'];
				$nation->Iso2 = $row['nation_iso2'];
				$nation->Iso3 = $row['nation_iso3'];
				$nation->Number = (int) $row['nation_number'];
				$nation->Uno = (bool) $row['nation_uno'];
				$nation->CountryCode = $row['nation_country_code'];
				$nation->Account = $row['nation_account'];
				$nation->Language = $row['nation_language'];
				$nation->Ethnic = $row['nation_ethnic'];
				$nation->Currency = $row['nation_currency'];

				array_push($result, $nation);
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

			$sql = "SELECT * FROM e_nation WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$nation = new Nation();
			$nation->Id = (int) $row['id'];
			$nation->NameShort = $row['nation_short'];
			$nation->NameLong = $row['nation_long'];
			$nation->Iso2 = $row['nation_iso2'];
			$nation->Iso3 = $row['nation_iso3'];
			$nation->Number = (int) $row['nation_number'];
			$nation->Uno = (bool) $row['nation_uno'];
			$nation->CountryCode = $row['nation_country_code'];
			$nation->Account = $row['nation_account'];
			$nation->Language = $row['nation_language'];
			$nation->Ethnic = $row['nation_ethnic'];
			$nation->Currency = $row['nation_currency'];

			return $nation;

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

			$nation = json_decode(file_get_contents("php://input"));

			if ($nation == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			INSERT INTO e_nation 
			(nation_iso2, nation_iso3, nation_short, nation_long, nation_number, nation_uno, nation_country_code, nation_account, nation_language, nation_ethnic, nation_currency)
			VALUES
			(:nation_iso2, :nation_iso3, :nation_short, :nation_long, :nation_number, :nation_uno, :nation_country_code, :nation_account, :nation_language, :nation_ethnic, :nation_currency);";


			$query = $connection->prepare($sql);

			$query->bindParam(':nation_iso2', $nation->Iso2, PDO::PARAM_STR);
			$query->bindParam(':nation_iso3', $nation->Iso3, PDO::PARAM_STR);
			$query->bindParam(':nation_short', $nation->NameShort, PDO::PARAM_STR);
			$query->bindParam(':nation_long', $nation->NameLong, PDO::PARAM_STR);
			$query->bindParam(':nation_number', $nation->Number, PDO::PARAM_INT);
			$query->bindParam(':nation_uno', $nation->Uno, PDO::PARAM_BOOL);
			$query->bindParam(':nation_country_code', $nation->CountryCode, PDO::PARAM_STR);
			$query->bindParam(':nation_account', $nation->Account, PDO::PARAM_STR);
			$query->bindParam(':nation_language', $nation->Language, PDO::PARAM_STR);
			$query->bindParam(':nation_ethnic', $nation->Ethnic, PDO::PARAM_STR);
			$query->bindParam(':nation_currency', $nation->Currency, PDO::PARAM_STR);

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

			$nation = json_decode(file_get_contents("php://input"));

			if ($nation == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE e_nation 
			SET 
			nation_iso2 = :nation_iso2,
			nation_iso3 = :nation_iso3, 
			nation_short = :nation_short,
			nation_long = :nation_long,
			nation_number = :nation_number, 
			nation_uno = :nation_uno, 
			nation_country_code = :nation_country_code, 
			nation_account = :nation_account,
			nation_language = :nation_language, 
			nation_ethnic = :nation_ethnic, 
			nation_currency = :nation_currency
			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':nation_iso2', $nation->Iso2, PDO::PARAM_STR);
			$query->bindParam(':nation_iso3', $nation->Iso3, PDO::PARAM_STR);
			$query->bindParam(':nation_short', $nation->NameShort, PDO::PARAM_STR);
			$query->bindParam(':nation_long', $nation->NameLong, PDO::PARAM_STR);
			$query->bindParam(':nation_number', $nation->Number, PDO::PARAM_INT);
			$query->bindParam(':nation_uno', $nation->Uno, PDO::PARAM_BOOL);
			$query->bindParam(':nation_country_code', $nation->CountryCode, PDO::PARAM_STR);
			$query->bindParam(':nation_account', $nation->Account, PDO::PARAM_STR);
			$query->bindParam(':nation_language', $nation->Language, PDO::PARAM_STR);
			$query->bindParam(':nation_ethnic', $nation->Ethnic, PDO::PARAM_STR);
			$query->bindParam(':nation_currency', $nation->Currency, PDO::PARAM_STR);
			
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
			DELETE FROM e_nation 
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