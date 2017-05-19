<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class nation and supplies the requests such as select, insert, update & delete.
*/
class Nation implements IQuery {

	public $id;
	public $nameShort;
	public $nameLong;
	public $iso2;
	public $iso3;
	public $number;
	public $uno;
	public $countryCode;
	public $account;
	public $language;
	public $ethnic;
	public $currency;


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
				$nation->id = (int) $row['id'];
				$nation->nameShort = $row['nation_short'];
				$nation->nameLong = $row['nation_long'];
				$nation->iso2 = $row['nation_iso2'];
				$nation->iso3 = $row['nation_iso3'];
				$nation->number = (int) $row['nation_number'];
				$nation->uno = (bool) $row['nation_uno'];
				$nation->countryCode = $row['nation_country_code'];
				$nation->account = $row['nation_account'];
				$nation->language = $row['nation_language'];
				$nation->ethnic = $row['nation_ethnic'];
				$nation->currency = $row['nation_currency'];

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
			$nation->id = (int) $row['id'];
			$nation->nameShort = $row['nation_short'];
			$nation->nameLong = $row['nation_long'];
			$nation->iso2 = $row['nation_iso2'];
			$nation->iso3 = $row['nation_iso3'];
			$nation->number = (int) $row['nation_number'];
			$nation->uno = (bool) $row['nation_uno'];
			$nation->countryCode = $row['nation_country_code'];
			$nation->account = $row['nation_account'];
			$nation->language = $row['nation_language'];
			$nation->ethnic = $row['nation_ethnic'];
			$nation->currency = $row['nation_currency'];

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

			$query->bindParam(':nation_iso2', $nation->iso2, PDO::PARAM_STR);
			$query->bindParam(':nation_iso3', $nation->iso3, PDO::PARAM_STR);
			$query->bindParam(':nation_short', $nation->nameShort, PDO::PARAM_STR);
			$query->bindParam(':nation_long', $nation->nameLong, PDO::PARAM_STR);
			$query->bindParam(':nation_number', $nation->number, PDO::PARAM_INT);
			$query->bindParam(':nation_uno', $nation->uno, PDO::PARAM_BOOL);
			$query->bindParam(':nation_country_code', $nation->countryCode, PDO::PARAM_STR);
			$query->bindParam(':nation_account', $nation->account, PDO::PARAM_STR);
			$query->bindParam(':nation_language', $nation->language, PDO::PARAM_STR);
			$query->bindParam(':nation_ethnic', $nation->ethnic, PDO::PARAM_STR);
			$query->bindParam(':nation_currency', $nation->currency, PDO::PARAM_STR);

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

			$query->bindParam(':nation_iso2', $nation->iso2, PDO::PARAM_STR);
			$query->bindParam(':nation_iso3', $nation->iso3, PDO::PARAM_STR);
			$query->bindParam(':nation_short', $nation->nameShort, PDO::PARAM_STR);
			$query->bindParam(':nation_long', $nation->nameLong, PDO::PARAM_STR);
			$query->bindParam(':nation_number', $nation->number, PDO::PARAM_INT);
			$query->bindParam(':nation_uno', $nation->uno, PDO::PARAM_BOOL);
			$query->bindParam(':nation_country_code', $nation->countryCode, PDO::PARAM_STR);
			$query->bindParam(':nation_account', $nation->account, PDO::PARAM_STR);
			$query->bindParam(':nation_language', $nation->language, PDO::PARAM_STR);
			$query->bindParam(':nation_ethnic', $nation->ethnic, PDO::PARAM_STR);
			$query->bindParam(':nation_currency', $nation->currency, PDO::PARAM_STR);
			
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
			DELETE FROM e_nation 
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