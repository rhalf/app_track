var app = angular.module('app');

app.factory('globalFactory', function() {

	var globalFactory = {};

	globalFactory.sideMenu = false;

	return globalFactory;
});