var app = angular.module('app');

app.controller('appController', function ($scope) {

});

//Config
app.config(function ($routeProvider, $locationProvider) {
    $routeProvider
    .when('/', {
        templateUrl: 'app/template/form/form.html',
        controller: 'formController'
    })
            //.when('/', {
            //    templateUrl: 'app/template/form/login.html',
            //    controller: 'formController'
            //})
    .otherwise({
        redirectTo: '/'
    });
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
