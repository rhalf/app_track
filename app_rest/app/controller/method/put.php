<?php
function method_put(Url $url, $put) {
	switch ($url->Class) {
		case 'company':
		return Company::onUpdate($url, $put);
		break;

		case 'user':
		return User::onUpdate($url, $put);
		break;
		
		case 'model':
		return Model::onUpdate($url, $put);
		break;


		

		//Enumerations
		case 'nation':
		return Nation::onUpdate($url, $put);
		break;

		case 'privilege':
		return Privilege::onUpdate($url, $put);
		break;

		default:
		Flight::notFound("Class $class not found.");
		break;
	}
	return $data;
}
?>