var app = angular.module('app');

app.controller('appController', function ($scope) {

});

//Config
app.config(function ($routeProvider, $locationProvider, $httpProvider) {


    //$httpProvider.defaults.useXDomain = true;
    //$httpProvider.defaults.withCredentials = true;
    //delete $httpProvider.defaults.headers.common["X-Requested-With"];
    //$httpProvider.defaults.headers.common["Accept"] = "application/json";
    //$httpProvider.defaults.headers.common["Content-Type"] = "application/json";


    $routeProvider
        .when('/form', {
            templateUrl: 'app/template/form/form.html',
            controller: 'formController',
            authenticated: true
        })
        .when('/', {
            templateUrl: 'app/template/form/login.html',
            controller: 'loginController'

        })
        .otherwise({
            redirectTo: '/'
        });



});



//Directive
app.directive('panelMenu', function () {
    return {
        templateUrl: '/app/template/directive/panelMenu.html',
        controller: 'panelMenuController'
    }
});

app.directive('panelLeft', function () {
    return {
        templateUrl: '/app/template/directive/panelLeft.html',
        controller: 'panelLeftController'
    }
});

app.directive('panelCenter', function () {
    return {
        templateUrl: '/app/template/directive/panelCenter.html',
        controller: 'panelCenterController'
    }
});

app.directive('panelMap', function () {
    return {
        templateUrl: '/app/template/directive/panelMap.html',
        controller: 'panelMapController'
    }
});





////
//app.directive('alertDirective', function ($timeout) {
//    return {
//        replace: true,
//        scope: {
//            ngModel: '='
//        },
//        template:'<div class="alert fade" bs-alert="ngModel"></div>',
//        link: function (scope, element, attrs) {
//            //$timeout(function () {
//            //    element.hide();
//            //}, 3000);
//        }
//    }
//});


app.run(["$rootScope", "$location", "authFactory", function ($rootScope, $location, authFactory) {

    $rootScope.$on("$routeChangeStart", function (event, next, current) {

        //console.log(event);
        //console.log(next);
        //console.log(current);

        //If route is authenticated, then the user should have access
        if (next.$$route.authenticated) {

            var user = authFactory.getAccessToken();

            if (!user) {
                $location.path('/');
            }
        }
    });

}]);