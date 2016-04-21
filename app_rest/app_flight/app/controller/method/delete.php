<?php
function method_delete(Url $url, $data) {
	switch ($url->Class) {

		case 'company':
		Company::onDelete($url, $data);

		case 'user':
		User::onDelete($url, $data);
		
		case 'vehicle':
		Vehicle::onDelete($url, $data);

		case 'model':
		Model::onDelete($url, $data);
		
		case 'address':
		Address::onDelete($url, $data);
		
		case 'unit':
		Unit::onDelete($url, $data);

		//20160308
		case 'driver':
		Driver::onDelete($url, $data);
		
		case 'companyinfo':
		CompanyInfo::onDelete($url, $data);
		
		case 'unitsim':
		UnitSim::onDelete($url, $data);

		case 'usersim':
		UserSim::onDelete($url, $data);
		
		case 'userinfo':
		UserInfo::onDelete($url, $data);
		
		case 'collection':
		Collection::onDelete($url, $data);

		case 'vehiclecollection':
		VehicleCollection::onDelete($url, $data);
		
		case 'route':
		Route::onDelete($url, $data);
		
		case 'poi':
		Poi::onDelete($url, $data);

		case 'geofence':
		Geofence::onDelete($url, $data);


		//App 
		case 'appdatabase':
		AppDatabase::onDelete($url, $data);

		case 'appnote':
		AppNote::onDelete($url, $data);

		case 'appsetting':
		AppSetting::onDelete($url, $data);


		case 'appclient':
		AppClient::onDelete($url, $data);

		case 'appinfo':
		AppInfo::onDelete($url, $data);

		case 'applog':
		AppLog::onDelete($url, $data);

		//Enumerations
		case 'nation':
		Nation::onDelete($url, $data);
		
		case 'privilege':
		Privilege::onDelete($url, $data);

		case 'field':
		Field::onDelete($url, $data);

		case 'status':
		Status::onDelete($url, $data);

		case 'unittype':
		UnitType::onDelete($url, $data);	

		case 'simvendor':
		SimVendor::onDelete($url, $data);
		

		default:
		Flight::notFound("Class not found.");
		
	}
}
?>