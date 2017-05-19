<?php
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Main entry point of each crud requests.
*/
require_once 'app/controller/system/include.php';


Flight::route('OPTIONS /*', function() {
	Flight::preFlight();
}, true);

//=============================================================================
//AppClient
//=============================================================================
Flight::route('GET /v1/main/appclient', function() {
	try {
		$array = AppClient::selectAll();
		Flight::ok($array);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/appclient/@id', function($id) {
	try {
		$object = AppClient::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/appclient', function() {
	try {
		$object = AppClient::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/appclient/@id', function($id) {
	try {
		$object = AppClient::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/appclient/@id', function($id) {
	try {
		$object = AppClient::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=============================================================================
//AppDatabase
//=============================================================================
Flight::route('GET /v1/main/appdatabase', function() {
	try {
		$array = AppDatabase::selectAll();
		Flight::ok($array);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/appdatabase/@id', function($id) {
	try {
		$object = AppDatabase::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/appdatabase', function() {
	try {
		$object = AppDatabase::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/appdatabase/@id', function($id) {
	try {
		$object = AppDatabase::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/appdatabase/@id', function($id) {
	try {
		$object = AppDatabase::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=============================================================================
//AppInfo
//=============================================================================
Flight::route('GET /v1/main/appinfo', function() {
	try {
		$array = AppInfo::selectAll();
		Flight::ok($array);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/appinfo/@id', function($id) {
	try {
		$object = AppInfo::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/appinfo', function() {
	try {
		$object = AppInfo::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/appinfo/@id', function($id) {
	try {
		$object = AppInfo::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/appinfo/@id', function($id) {
	try {
		$object = AppInfo::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=============================================================================
//AppLog
//=============================================================================
Flight::route('GET /v1/main/applog', function() {
	try {
		$array = AppLog::selectAll();
		Flight::ok($array);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/applog/@id', function($id) {
	try {
		$object = AppLog::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/applog', function() {
	try {
		$object = AppLog::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/applog/@id', function($id) {
	try {
		$object = AppLog::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/applog/@id', function($id) {
	try {
		$object = AppLog::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=============================================================================
//AppNote
//=============================================================================
Flight::route('GET /v1/main/appnote', function() {
	try {
		$array = AppNote::selectAll();
		Flight::ok($array);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/appnote/@id', function($id) {
	try {
		$object = AppNote::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/appnote', function() {
	try {
		$object = AppNote::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/appnote/@id', function($id) {
	try {
		$object = AppNote::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/appnote/@id', function($id) {
	try {
		$object = AppNote::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=============================================================================
//Address
//=============================================================================
Flight::route('GET /v1/main/address', function() {
	try {
		$array = Address::selectAll();
		Flight::ok($array);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/address/@id', function($id) {
	try {
		$object = Address::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/address', function() {
	try {
		$object = Address::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/address/@id', function($id) {
	try {
		$object = Address::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/address/@id', function($id) {
	try {
		$object = Address::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=============================================================================
//Collection
//=============================================================================
Flight::route('GET /v1/main/collection', function() {
	$company = Flight::request()->query->company;

	try {
		if ($company) {
			$array = Collection::selectByCompany($company);
		} else {
			$array = Collection::selectAll();
		}
		Flight::ok($array);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/collection/@id', function($id) {
	try {
		$object = Collection::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/collection', function() {
	try {
		$object = Collection::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/collection/@id', function($id) {
	try {
		$object = Collection::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/collection/@id', function($id) {
	try {
		$object = Collection::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=============================================================================
//Company
//=============================================================================
Flight::route('GET /v1/main/company', function() {
	try {
		$array = Company::selectAll();
		Flight::ok($array);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/company/@id', function($id) {
	try {
		$object = Company::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/company', function() {
	try {
		$object = Company::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/company/@id', function($id) {
	try {
		$object = Company::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/company/@id', function($id) {
	try {
		$object = Company::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

//=============================================================================
//CompanyInfo
//=============================================================================
Flight::route('GET /v1/main/companyinfo', function() {
	$company = Flight::request()->query->company;
	try {
		if ($company) {
			$object = CompanyInfo::selectByCompany($company);
		} else {
			$object = CompanyInfo::selectAll();
		}
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/companyinfo/@id', function($id) {
	try {
		$object = CompanyInfo::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/companyinfo', function() {
	try {
		$object = CompanyInfo::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/companyinfo/@id', function($id) {
	try {
		$object = CompanyInfo::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/companyinfo/@id', function($id) {
	try {
		$object = CompanyInfo::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=============================================================================
//Driver
//=============================================================================
Flight::route('GET /v1/main/driver', function() {
	$company = Flight::request()->query->company;
	try {
		if ($company) {
			$array = Driver::selectByCompany($company);
		} else {
			$array = Driver::selectAll();
		}
		Flight::ok($array);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/driver/@id', function($id) {
	try {
		$object = Driver::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/driver', function() {
	try {
		$object = Driver::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/driver/@id', function($id) {
	try {
		$object = Driver::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/driver/@id', function($id) {
	try {
		$object = Driver::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=============================================================================
//Field
//=============================================================================
Flight::route('GET /v1/main/field', function() {
	try {
		$array = Field::selectAll();
		Flight::ok($array);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/field/@id', function($id) {
	try {
		$object = Field::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/field', function() {
	try {
		$object = Field::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/field/@id', function($id) {
	try {
		$object = Field::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/field/@id', function($id) {
	try {
		$object = Field::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=============================================================================
//Geofence
//=============================================================================
Flight::route('GET /v1/main/geofence', function() {

	$company = Flight::request()->query->company;

	try {
		if ($company) {
			$object = Geofence::selectByCompany($company);
		}else {
			$object = Geofence::selectAll();
		}
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/geofence/@id', function($id) {
	try {
		$object = Geofence::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/geofence', function() {
	try {

		$param = json_decode(file_get_contents("php://input"));

		// if ($param) {
		// 	$object = Geofence::selectByCoordinate($param);
		// }else {
			$object = Geofence::insert();
		//}

		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/geofence/@id', function($id) {
	try {
		$object = Geofence::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/geofence/@id', function($id) {
	try {
		$object = Geofence::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=============================================================================
//Area
//=============================================================================
Flight::route('GET /v1/main/area', function() {

	$nation = Flight::request()->query->nation;

	try {
		if ($nation) {
			$object = Area::selectByNation($nation);
		}else {
			$object = Area::selectAll();
		}
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/area/@id', function($id) {
	try {
		$object = Area::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/area', function() {
	try {
		$object = Area::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/area/@id', function($id) {
	try {
		$object = Area::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/area/@id', function($id) {
	try {
		$object = Area::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=============================================================================
//Nation
//=============================================================================
Flight::route('GET /v1/main/nation', function() {
	try {
		$array = Nation::selectAll();
		Flight::ok($array);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/nation/@id', function($id) {
	try {
		$object = Nation::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/nation', function() {
	try {
		$object = Nation::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/nation/@id', function($id) {
	try {
		$object = Nation::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/nation/@id', function($id) {
	try {
		$object = Nation::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=============================================================================
//Poi
//=============================================================================
Flight::route('GET /v1/main/poi', function() {
	$company = Flight::request()->query->company;

	try {
		if ($company) {
			$object = Poi::selectByCompany($company);
		}else {
			$object = Poi::selectAll();
		}
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/poi/@id', function($id) {
	try {
		$object = Poi::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/poi', function() {
	try {
		$object = Poi::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/poi/@id', function($id) {
	try {
		$object = Poi::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
Flight::route('DELETE /v1/main/poi/@id', function($id) {
	try {
		$object = Poi::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=============================================================================
//Privilege
//=============================================================================
Flight::route('GET /v1/main/privilege', function() {
	try {
		$array = Privilege::selectAll();
		Flight::ok($array);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/privilege/@id', function($id) {
	try {
		$object = Privilege::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/privilege', function() {
	try {
		$object = Privilege::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/privilege/@id', function($id) {
	try {
		$object = Privilege::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/privilege/@id', function($id) {
	try {
		$object = Privilege::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=============================================================================
//Route
//=============================================================================
Flight::route('GET /v1/main/route', function() {
	$company = Flight::request()->query->company;
	try {
		if ($company) {
			$array = Route::selectByCompany($company);
		} else {
			$array = Route::selectAll();
		}
		Flight::ok($array);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/route/@id', function($id) {
	try {
		$object = Route::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/route', function() {
	try {
		$object = Route::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/route/@id', function($id) {
	try {
		$object = Route::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/route/@id', function($id) {
	try {
		$object = Route::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=============================================================================
//Sim
//=============================================================================
Flight::route('GET /v1/main/sim', function() {
	$company = Flight::request()->query->company;
	try {
		if ($company) {
			$array = Sim::selectByCompany($company);
		} else {
			$array = Sim::selectAll();
		}
		Flight::ok($array);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/sim/@id', function($id) {
	try {
		$object = Sim::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/sim', function() {
	try {
		$object = Sim::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/sim/@id', function($id) {
	try {
		$object = Sim::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});


Flight::route('DELETE /v1/main/sim/@id', function($id) {
	try {
		$object = Sim::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=============================================================================
//SimVendor
//=============================================================================
Flight::route('GET /v1/main/simvendor', function() {
	try {
		$array = SimVendor::selectAll();
		Flight::ok($array);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/simvendor/@id', function($id) {
	try {
		$object = SimVendor::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/simvendor', function() {
	try {
		$object = SimVendor::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/simvendor/@id', function($id) {
	try {
		$object = SimVendor::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});


Flight::route('DELETE /v1/main/simvendor/@id', function($id) {
	try {
		$object = SimVendor::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=============================================================================
//Status
//=============================================================================
Flight::route('GET /v1/main/status', function() {
	try {
		$array = Status::selectAll();
		Flight::ok($array);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/status/@id', function($id) {
	try {
		$object = Status::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/status', function() {
	try {
		$object = Status::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/status/@id', function($id) {
	try {
		$object = Status::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/status/@id', function($id) {
	try {
		$object = Status::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=============================================================================
//Unit
//=============================================================================
Flight::route('GET /v1/main/unit', function() {

	$company = Flight::request()->query->company;
	
	try {
		if ($company) {
			$array = Unit::selectByCompany($company);
		}else {
			$array = Unit::selectAll();
		}
		Flight::ok($array);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/unit/@id', function($id) {
	try {
		$object = Unit::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/unit', function() {
	try {
		$object = Unit::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/unit/@id', function($id) {
	try {
		$object = Unit::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/unit/@id', function($id) {
	try {
		$object = Unit::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=============================================================================
//UnitType
//=============================================================================
Flight::route('GET /v1/main/unittype', function() {
	try {
		$array = UnitType::selectAll();
		Flight::ok($array);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/unittype/@id', function($id) {
	try {
		$object = UnitType::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/unittype', function() {
	try {
		$object = UnitType::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/unittype/@id', function($id) {
	try {
		$object = UnitType::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/unittype/@id', function($id) {
	try {
		$object = UnitType::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=============================================================================
//UnitStatus
//=============================================================================
Flight::route('GET /v1/main/unitstatus', function() {
	try {
		$array = UnitStatus::selectAll();
		Flight::ok($array);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/unitstatus/@id', function($id) {
	try {
		$object = UnitStatus::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});


Flight::route('POST /v1/main/unitstatus', function() {
	try {
		$object = UnitStatus::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});


Flight::route('PUT /v1/main/unitstatus/@id', function($id) {
	try {
		$object = UnitStatus::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/unitstatus/@id', function($id) {
	try {
		$object = UnitStatus::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=============================================================================
//Type
//=============================================================================
Flight::route('GET /v1/main/type', function() {
	try {
		$array = Type::selectAll();
		Flight::ok($array);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/type/@id', function($id) {
	try {
		$object = Type::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/type',function() {
	try {
		$object = Type::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/type/@id', function($id) {
	try {
		$object = Type::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/type/@id', function($id) {
	try {
		$object = Type::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=============================================================================
//User
//=============================================================================
Flight::route('GET /v1/main/user',function() {
	$company = Flight::request()->query->company;
	try {
		if ($company) {
			$array = User::selectByCompany($company);
		} else {
			$array = User::selectAll();
		}
		Flight::ok($array);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/user/@id', function($id) {
	try {
		$object = User::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/user', function() {
	try {
		$object = User::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/user/@id', function($id) {
	try {
		$object = User::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/user/@id/credential', function($id) {
	try {
		$object = User::updateCredential($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/user/@id', function($id) {
	try {
		$object = User::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=============================================================================
//UserInfo
//=============================================================================
Flight::route('GET /v1/main/userinfo', function() {
	$user = Flight::request()->query->user;
	try {
		if ($user) {
			$object = UserInfo::selectByUser($user);
		} else {
			$object = UserInfo::selectAll();
		}
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
Flight::route('GET /v1/main/userinfo/@id', function($id) {
	try {
		$object = UserInfo::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/userinfo', function() {
	try {
		$object = UserInfo::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/userinfo/@id', function($id) {
	try {
		$object = UserInfo::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/userinfo/@id', function($id) {
	try {
		$object = UserInfo::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

//=============================================================================
//UserOnline
//=============================================================================
Flight::route('GET /v1/main/useronline', function() {
	try {
		$time = Flight::request()->query->time;
		if ($time) {
			$array = UserOnline::selectByTime($time);
		} else {
			$array = UserOnline::selectAll();
		}
		Flight::ok($array);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

// Flight::route('GET /v1/main/useronline/@id', function($id) {
// 	try {
// 		$object = UserOnline::select($id);
// 		Flight::ok($object);
// 	} catch (Exception $exception) {
// 		Flight::error($exception);
// 	}
// });


Flight::route('POST /v1/main/useronline', function() {
	try {

		$jsonObject = json_decode(file_get_contents("php://input"));

		$userOnline = UserOnline::selectByUser($jsonObject->user->id);

		if ($userOnline) {
			$object =UserOnline::update($userOnline->id);
		} else {
			$object = UserOnline::insert();
		}

		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

// Flight::route('PUT /v1/main/useronline/@id', function($id) {
// 	try {
// 		$object = UserOnline::update($id);
// 		Flight::ok($object);
// 	} catch (Exception $exception) {
// 		Flight::error($exception);
// 	}
// });

// Flight::route('DELETE /v1/main/useronline/@id', function($id) {
// 	try {
// 		$object = UserOnline::delete($id);
// 		Flight::ok($object);
// 	} catch (Exception $exception) {
// 		Flight::error($exception);
// 	}
// });

//=============================================================================
//Vehicle
//=============================================================================
Flight::route('GET /v1/main/vehicle', function() {
	$company = Flight::request()->query->company;
	try {
		if ($company) {
			$array = Vehicle::selectByCompany($company);
		} else {
			$array = Vehicle::selectAll();
		}
		Flight::ok($array);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/vehicle/@id', function($id) {
	try {
		$object = Vehicle::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/vehicle', function() {
	try {
		$object = Vehicle::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/vehicle/@id', function($id) {
	try {
		$object = Vehicle::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/vehicle/@id', function($id) {
	try {
		$object = Vehicle::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=============================================================================
//VehicleCollection
//=============================================================================
Flight::route('GET /v1/main/vehiclecollection', function() {
	$collection = Flight::request()->query->collection;
	try {
		if ($collection) {
			$array = VehicleCollection::selectByCollection($collection);
		} else {
			$array = VehicleCollection::selectAll();
		}
		Flight::ok($array);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/vehiclecollection/@id', function($id) {
	try {
		$object = VehicleCollection::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/vehiclecollection', function() {
	try {
		$object = VehicleCollection::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});


Flight::route('PUT /v1/main/vehiclecollection/@id', function($id) {
	try {
		$object = VehicleCollection::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/vehiclecollection/@id', function($id) {
	try {
		$object = VehicleCollection::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/vehiclecollection', function() {
	$collection = Flight::request()->query->collection;
	try {
		if ($collection) {
			$object = VehicleCollection::deleteByCollection($collection);
		}else {
			Flight::error(new Exception("Collection is not set."));
		}
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=============================================================================
//Session
//=============================================================================
Flight::route('POST /v1/session/login', function() {
	try {
		$object = Session::login();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/session/logout',function() {
	try {
		$object = Session::logout();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});


//=============================================================================
//UnitData
//=============================================================================
// Flight::route('GET /v1/data/unitdata/@id', function($id) {
// 	try {
// 		$object = UnitData::select($id);
// 		Flight::ok($object);
// 	} catch (Exception $exception) {
// 		Flight::error($exception);
// 	}
// });
//=============================================================================
//Poi
//=============================================================================
Flight::route('GET /v1/main/poi', function() {
	$company = Flight::request()->query->company;
	try {
		if ($company) {
			$array = Poi::selectByCompany($company);
		} else {
			$array = Poi::selectAll();
		}
		Flight::ok($array);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('GET /v1/main/poi/@id', function($id) {
	try {
		$object = Poi::select($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('POST /v1/main/poi', function() {
	try {
		$object = Poi::insert();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('PUT /v1/main/poi/@id', function($id) {
	try {
		$object = Poi::update($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});

Flight::route('DELETE /v1/main/poi/@id', function($id) {
	try {
		$object = Poi::delete($id);
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=========================================================================

//Report
Flight::route('POST /v1/data/report', function() {
	try {

		$param = json_decode(file_get_contents("php://input"));

		$object = null;

		switch ($param->type) {
			case 'historical':
			$object = Report::getHistorical($param);
			break;
			case 'running':
			$object = Report::getRunning($param);
			break;
			case 'idling':
			$object = Report::getIdling($param);
			break;
			case 'geofencing':
			$object = Report::getGeofencing($param);
			break;	
			case 'areaing':
			$object = Report::getAreaing($param);
			break;
			case 'ignition':
			$object = Report::getIgnition($param);
			break;
			case 'speeding':
			$object = Report::getSpeeding($param);
			break;
			case 'powercutting':
			$object = Report::getPowercutting($param);
			break;
		}
		

		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});


//Command
Flight::route('POST /v1/main/command', function() {
	try {
		$object = Command::prepare();
		Flight::ok($object);
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});
//=========================================================================
Flight::set('flight.log_errors', true);
Flight::set('flight.handle_errors', true);

Flight::start();

?>