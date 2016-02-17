<?php
function method_put($class, $put) {
	switch ($class) {
		case 'company':
		$data = Company::onUpdate($put);
		break;
		case 'nation':
		$data = Nation::onUpdate($put);
		break;
		case 'privilege':
		$data = Privilege::onUpdate($put);
		break;
		default:
		Flight::notFound("Class $class not found.");
		break;
	}
	return $data;
}
?>