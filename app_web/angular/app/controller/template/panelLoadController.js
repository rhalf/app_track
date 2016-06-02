var app = angular.module('app');


app.controller('panelLoadController', function ($scope, $location, $timeout, uiFactory, authFactory, flagFactory) {

    $scope.redirect = function () {
        $location.path('/form');
    };
    $scope.init();
});

