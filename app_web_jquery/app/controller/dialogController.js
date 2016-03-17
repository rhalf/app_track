var app = angular.module('app');


app.controller('dialogController', function ($scope) {

	$scope.open = function() {
		alert("asd");
		$scope.showModal = true;
	};

	$scope.ok = function() {
		$scope.showModal = false;
	};

	$scope.cancel = function() {
		$scope.showModal = false;
	};
});
