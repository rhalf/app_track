<?php
function method_post(Url $url, $data) {
	switch ($url->Class) {

		case 'company':
		return Company::onInsert($url, $data);

		case 'user':
		return User::onInsert($url, $data);

		case 'vehicle':
		return Vehicle::onInsert($url, $data);

		case 'model':
		return Model::onInsert($url, $data);

		case 'address':
		return Address::onInsert($url, $data);

		case 'unit':
		return Unit::onInsert($url, $data);

		//20160308
		case 'driver':
		return Driver::onInsert($url, $data);
		
		case 'companyinfo':
		return CompanyInfo::onInsert($url, $data);

		case 'unitsim':
		return UnitSim::onInsert($url, $data);

		case 'usersim':
		return UserSim::onInsert($url, $data);
		
		case 'userinfo':
		return UserInfo::onInsert($url, $data);
		
		case 'collection':
		return Collection::onInsert($url, $data);
		
		case 'vehiclecollection':
		return VehicleCollection::onInsert($url, $data);
		
		case 'route':
		return Route::onInsert($url, $data);
		
		case 'poi':
		return Poi::onInsert($url, $data);

		case 'geofence':
		return Geofence::onInsert($url, $data);


		//App 
		case 'appdatabase':
		return AppDatabase::onInsert($url, $data);

		case 'appnote':
		return AppNote::onInsert($url, $data);

		case 'appsetting':
		return AppSetting::onInsert($url, $data);

		case 'appclient':
		return AppClient::onInsert($url, $data);

		case 'appinfo':
		return AppInfo::onInsert($url, $data);

		case 'applog':
		return AppLog::onInsert($url, $data);


		//Session
		case 'login':
		return Session::login($url, $data);
		
		case 'logout':
		return Session::logout($url, $data);
		
		
		//Enumerations
		case 'nation':
		return Nation::onInsert($url, $data);

		case 'privilege':
		return Privilege::onInsert($url, $data);

		case 'field':
		return Field::onInsert($url, $data);

		case 'status':
		return Status::onInsert($url, $data);

		case 'unittype':
		return UnitType::onInsert($url, $data);	

		case 'simvendor':
		return SimVendor::onInsert($url, $data);
		

		default:
		Flight::notFound("Class not found.");
		
	}
}
?>
