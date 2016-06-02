var app = angular.module('app');

app.config(function ($routeProvider, $locationProvider, $httpProvider, $logProvider) {
    $routeProvider
        .when('/form', {
            templateUrl: 'app/view/directive/panelContainer.html',
            controller: 'panelContainerController',
            authenticated: true,
            resolve: {
                flags: function ($timeout, flagFactory, uiFactory) {
                    flagFactory.init(function () {
                        //$timeout(function () {
                            uiFactory.isLoading = false;
                            return true;
                        //}, 3000);
                    });
                }
            }

        })
        .when('/', {
            templateUrl: 'app/view/form/login.html',
            controller: 'loginController',
        })
        .otherwise({
            redirectTo: '/'
        });


    $logProvider.debugEnabled(false);
});
