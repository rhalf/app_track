<?php
function method_get($class, $get) {
	$data = null;
	switch ($class) {
		case 'company':
		$data = Company::onSelect($get);
		break;
		case 'user':
		$data = User::onSelect($get);
		break;

		
		case 'nation':
		$data = Nation::onSelect($get);
		break;
		case 'privilege':
		$data = Privilege::onSelect($get);
		break;

		default:
		Flight::notFound("Class $class not found.");
		break;
	}

	return $data;
}
?>