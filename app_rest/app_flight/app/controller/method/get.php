<?php
function method_get(Url $url, $data) {
	switch ($url->Class) {

		case 'company':
		Company::onSelect($url, $data);

		case 'user':
		User::onSelect($url, $data);

		case 'vehicle':
		Vehicle::onSelect($url, $data);

		case 'model':
		Model::onSelect($url, $data);

		case 'address':
		Address::onSelect($url, $data);

		case 'unit':
		Unit::onSelect($url, $data);

		//20160308
		case 'driver':
		Driver::onSelect($url, $data);
		
		case 'companyinfo':
		CompanyInfo::onSelect($url, $data);
		
		case 'unitsim':
		UnitSim::onSelect($url, $data);

		case 'usersim':
		UserSim::onSelect($url, $data);
		
		case 'userinfo':
		UserInfo::onSelect($url, $data);
		
		case 'collection':
		Collection::onSelect($url, $data);

		case 'vehiclecollection':
		VehicleCollection::onSelect($url, $data);
		
		case 'route':
		Route::onSelect($url, $data);
		
		case 'poi':
		Poi::onSelect($url, $data);

		case 'geofence':
		Geofence::onSelect($url, $data);

		//App 
		case 'appdatabase':
		AppDatabase::onSelect($url, $data);

		case 'appnote':
		AppNote::onSelect($url, $data);

		case 'appsetting':
		AppSetting::onSelect($url, $data);

		case 'appclient':
		AppClient::onSelect($url, $data);

		case 'appinfo':
		AppInfo::onSelect($url, $data);

		case 'applog':
		AppLog::onSelect($url, $data);



		//Enumerations
		case 'nation':
		Nation::onSelect($url, $data);

		case 'privilege':
		Privilege::onSelect($url, $data);

		case 'field':
		Field::onSelect($url, $data);

		case 'status':
		Status::onSelect($url, $data);

		case 'unittype':
		UnitType::onSelect($url, $data);	

		case 'simvendor':
		SimVendor::onSelect($url, $data);

		
		default:
		Flight::notFound("Class not found.");
		
	}
}
?>