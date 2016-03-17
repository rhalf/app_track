var app = angular.module('app');

app.directive('sideMenu', function () {
	return {
		templateUrl: '/app/template/directive/sideMenu.html'
	}
});

app.directive('sideContent', function () {
	return {
		templateUrl: '/app/template/directive/sideContent.html'
	}
});

app.directive('accordion', function () {
	return {
		templateUrl: '/app/template/directive/accordion.html'
	}
});

app.directive('dialog', function () {
	return {
		templateUrl: '/app/template/directive/dialog.html'
	}
});
