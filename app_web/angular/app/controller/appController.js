var app = angular.module('app');

app.controller('appController', function ($scope) {

});

//Config
app.config(function ($routeProvider, $locationProvider) {

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

    //$locationProvider.html5Mode(true);

});



//Directive
//app.directive('panelRight', function () {
//    return {
//        templateUrl: '/app/template/directive/panelRight.html'
//    }
//});

app.directive('panelLeft', function () {
    return {
        templateUrl: '/app/template/directive/panelLeft.html'
    }
});

app.directive('panelCenter', function () {
    return {
        templateUrl: '/app/template/directive/panelCenter.html'
    }
});

app.directive('panelMap', function () {
    return {
        templateUrl: '/app/template/directive/panelMap.html'
    }
});

app.directive('panelMenu', function () {
    return {
        templateUrl: '/app/template/directive/panelMenu.html'
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