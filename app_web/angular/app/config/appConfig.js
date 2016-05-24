var app = angular.module('app');

app.config(function ($routeProvider, $locationProvider, $httpProvider, $logProvider) {
    $routeProvider
        .when('/form', {
            templateUrl: 'app/view/directive/panelContainer.html',
            controller: 'panelContainerController',
            authenticated: true
        })
        .when('/', {
            templateUrl: 'app/view/form/login.html',
            controller: 'loginController'
        })
        .otherwise({
            redirectTo: '/'
        });


    $logProvider.debugEnabled(false);
});
