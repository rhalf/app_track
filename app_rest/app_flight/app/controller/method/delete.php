<?php
function method_delete(Url $url, $data) {
	switch ($url->Class) {

		case 'company':
		return Company::onDelete($url, $data);

		case 'user':
		return User::onDelete($url, $data);
		
		case 'vehicle':
		return Vehicle::onDelete($url, $data);

		case 'model':
		return Model::onDelete($url, $data);
		
		case 'address':
		return Address::onDelete($url, $data);
		
		case 'unit':
		return Unit::onDelete($url, $data);

		//20160308
		case 'driver':
		return Driver::onDelete($url, $data);
		
		case 'companyinfo':
		return CompanyInfo::onDelete($url, $data);
		
		case 'unitsim':
		return UnitSim::onDelete($url, $data);

		case 'usersim':
		return UserSim::onDelete($url, $data);
		
		case 'userinfo':
		return UserInfo::onDelete($url, $data);
		
		case 'collection':
		return Collection::onDelete($url, $data);

		case 'vehiclecollection':
		return VehicleCollection::onDelete($url, $data);
		
		case 'route':
		return Route::onDelete($url, $data);
		
		case 'poi':
		return Poi::onDelete($url, $data);

		case 'geofence':
		return Geofence::onDelete($url, $data);


		//App 
		case 'appdatabase':
		return AppDatabase::onDelete($url, $data);

		case 'appnote':
		return AppNote::onDelete($url, $data);

		case 'appsetting':
		return AppSetting::onDelete($url, $data);


		case 'appclient':
		return AppClient::onDelete($url, $data);

		case 'appinfo':
		return AppInfo::onDelete($url, $data);

		case 'applog':
		return AppLog::onDelete($url, $data);

		//Enumerations
		case 'nation':
		return Nation::onDelete($url, $data);
		
		case 'privilege':
		return Privilege::onDelete($url, $data);

		case 'field':
		return Field::onDelete($url, $data);

		case 'status':
		return Status::onDelete($url, $data);

		case 'unittype':
		return UnitType::onDelete($url, $data);	

		case 'simvendor':
		return SimVendor::onDelete($url, $data);
		

		default:
		Flight::notFound("Class not found.");
		
	}
}
?>