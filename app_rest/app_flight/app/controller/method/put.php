<?php
function method_put(Url $url, $data) {
	switch ($url->Class) {

		case 'company':
		return Company::onUpdate($url, $data);

		case 'user':
		return User::onUpdate($url, $data);

		case 'vehicle':
		return Vehicle::onUpdate($url, $data);
		
		case 'model':
		return Model::onUpdate($url, $data);

		case 'address':
		return Address::onUpdate($url, $data);

		case 'unit':
		return Unit::onUpdate($url, $data);
		
		//20160308
		case 'driver':
		return Driver::onUpdate($url, $data);
		
		case 'companyinfo':
		return CompanyInfo::onUpdate($url, $data);
		
		case 'unitsim':
		return UnitSim::onUpdate($url, $data);

		case 'usersim':
		return UserSim::onUpdate($url, $data);
		
		case 'userinfo':
		return UserInfo::onUpdate($url, $data);
		
		case 'collection':
		return Collection::onUpdate($url, $data);
		
		case 'vehiclecollection':
		return VehicleCollection::onUpdate($url, $data);
		
		case 'route':
		return Route::onUpdate($url, $data);
		
		case 'poi':
		return Poi::onUpdate($url, $data);

		case 'geofence':
		return Geofence::onUpdate($url, $data);

		//App 
		case 'appdatabase':
		return AppDatabase::onUpdate($url, $data);

		case 'appnote':
		return AppNote::onUpdate($url, $data);

		case 'appsetting':
		return AppSetting::onUpdate($url, $data);

		case 'appclient':
		return AppClient::onUpdate($url, $data);
		
		case 'appinfo':
		return AppInfo::onUpdate($url, $data);

		case 'applog':
		return AppLog::onUpdate($url, $data);



		//Enumerations
		case 'nation':
		return Nation::onUpdate($url, $data);
		
		case 'privilege':
		return Privilege::onUpdate($url, $data);

		case 'field':
		return Field::onUpdate($url, $data);

		case 'status':
		return Status::onUpdate($url, $data);

		case 'unittype':
		return UnitType::onUpdate($url, $data);	

		case 'simvendor':
		return SimVendor::onUpdate($url, $data);


		default:
		Flight::notFound("Class not found.");
		
	}
}
?>