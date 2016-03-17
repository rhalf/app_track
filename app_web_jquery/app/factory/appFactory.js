var app = angular.module('app');

app.factory('appFactory', function($http) {
	var appFactory = {};

	appFactory.getApp = function() {
		return $http.get('app/data/app.json');
	}
	appFactory.getSideMenu = function() {
		return $http.get('app/data/sideMenu.json');
	}
	return appFactory;
});