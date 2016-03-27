var app = angular.module('app');

app.controller('appController', function ($scope) {

});

//Config
app.config(function ($routeProvider, $locationProvider) {

    $routeProvider
        .when('/', {
            templateUrl: 'app/template/form/form.html'
        })
        .when('/login', {
            templateUrl: 'app/template/form/login.html'
        })
        .otherwise({
            redirectTo: '/login'
        });

    $locationProvider.html5Mode(true);

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
