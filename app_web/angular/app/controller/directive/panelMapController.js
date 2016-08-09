var app = angular.module('app');


app.controller('panelMapController', function (
    $timeout,
    $scope,

    leafletFactory) {

    $scope.init = function () {
        leafletFactory.init();
    }

    $scope.init();
});