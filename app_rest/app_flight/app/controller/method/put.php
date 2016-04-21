<?php
function method_put(Url $url, $data) {
	switch ($url->Class) {

		case 'company':
		Company::onUpdate($url, $data);

		case 'user':
		User::onUpdate($url, $data);

		case 'vehicle':
		Vehicle::onUpdate($url, $data);
		
		case 'model':
		Model::onUpdate($url, $data);

		case 'address':
		Address::onUpdate($url, $data);

		case 'unit':
		Unit::onUpdate($url, $data);
		
		//20160308
		case 'driver':
		Driver::onUpdate($url, $data);
		
		case 'companyinfo':
		CompanyInfo::onUpdate($url, $data);
		
		case 'unitsim':
		UnitSim::onUpdate($url, $data);

		case 'usersim':
		UserSim::onUpdate($url, $data);
		
		case 'userinfo':
		UserInfo::onUpdate($url, $data);
		
		case 'collection':
		Collection::onUpdate($url, $data);
		
		case 'vehiclecollection':
		VehicleCollection::onUpdate($url, $data);
		
		case 'route':
		Route::onUpdate($url, $data);
		
		case 'poi':
		Poi::onUpdate($url, $data);

		case 'geofence':
		Geofence::onUpdate($url, $data);

		//App 
		case 'appdatabase':
		AppDatabase::onUpdate($url, $data);

		case 'appnote':
		AppNote::onUpdate($url, $data);

		case 'appsetting':
		AppSetting::onUpdate($url, $data);

		case 'appclient':
		AppClient::onUpdate($url, $data);
		
		case 'appinfo':
		AppInfo::onUpdate($url, $data);

		case 'applog':
		AppLog::onUpdate($url, $data);



		//Enumerations
		case 'nation':
		Nation::onUpdate($url, $data);
		
		case 'privilege':
		Privilege::onUpdate($url, $data);

		case 'field':
		Field::onUpdate($url, $data);

		case 'status':
		Status::onUpdate($url, $data);

		case 'unittype':
		UnitType::onUpdate($url, $data);	

		case 'simvendor':
		SimVendor::onUpdate($url, $data);


		default:
		Flight::notFound("Class not found.");
		
	}
}
?>