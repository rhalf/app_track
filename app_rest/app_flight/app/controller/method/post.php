<?php
function method_post(Url $url, $data) {
	switch ($url->Class) {

		case 'company':
		Company::onInsert($url, $data);

		case 'user':
		User::onInsert($url, $data);

		case 'vehicle':
		Vehicle::onInsert($url, $data);

		case 'model':
		Model::onInsert($url, $data);

		case 'address':
		Address::onInsert($url, $data);

		case 'unit':
		Unit::onInsert($url, $data);

		//20160308
		case 'driver':
		Driver::onInsert($url, $data);
		
		case 'companyinfo':
		CompanyInfo::onInsert($url, $data);

		case 'unitsim':
		UnitSim::onInsert($url, $data);

		case 'usersim':
		UserSim::onInsert($url, $data);
		
		case 'userinfo':
		UserInfo::onInsert($url, $data);
		
		case 'collection':
		Collection::onInsert($url, $data);
		
		case 'vehiclecollection':
		VehicleCollection::onInsert($url, $data);
		
		case 'route':
		Route::onInsert($url, $data);
		
		case 'poi':
		Poi::onInsert($url, $data);

		case 'geofence':
		Geofence::onInsert($url, $data);


		//App 
		case 'appdatabase':
		AppDatabase::onInsert($url, $data);

		case 'appnote':
		AppNote::onInsert($url, $data);

		case 'appsetting':
		AppSetting::onInsert($url, $data);

		case 'appclient':
		AppClient::onInsert($url, $data);

		case 'appinfo':
		AppInfo::onInsert($url, $data);

		case 'applog':
		AppLog::onInsert($url, $data);


		//Session
		case 'login':
		Session::login($url, $data);
		
		case 'logout':
		Session::logout($url, $data);
		
		
		//Enumerations
		case 'nation':
		Nation::onInsert($url, $data);

		case 'privilege':
		Privilege::onInsert($url, $data);

		case 'field':
		Field::onInsert($url, $data);

		case 'status':
		Status::onInsert($url, $data);

		case 'unittype':
		UnitType::onInsert($url, $data);	

		case 'simvendor':
		SimVendor::onInsert($url, $data);
		

		default:
		Flight::notFound("Class not found.");
		
	}
}
?>
