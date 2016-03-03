<?php
function method_delete(Url $url, $delete) {

	switch ($url->Class) {
		case 'company':
		$data = Company::onDelete($url, $delete);
		break;
		case 'user':
		$data = User::onDelete($url, $delete);
		break;
		case 'model':
		$data = Model::onDelete($url, $delete);
		break;



		case 'nation':
		$data = Nation::onDelete($url, $delete);
		break;
		case 'privilege':
		$data = Privilege::onDelete($url, $delete);
		break;
		default:
		Flight::notFound("Class $class not found.");
		break;
	}

	return $data;
}
?>