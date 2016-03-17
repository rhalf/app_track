var app = angular.module('app');

app.controller('sideMenuController', function ($scope, appFactory, appService) {

	appFactory.getApp().success(function(data){
		$scope.app = data;
	}).error(function(error) {
		console.log(error);
	}); 

	appFactory.getSideMenu().success(function(data){
		$scope.sideMenu = data;
	}).error(function(error) {
		console.log(error);
	}); 


	$scope.load = function(data) {
		alert(data);
	};

	$scope.loadAppInfo = function() {
		// $dialog.dialog({}).open('asdasd'); 
	};
});
