var app = angular.module('app');


app.controller('panelBottomController', function (
    $scope,
    $interval,
    $timeout,

    authFactory,
    flagFactory,
    uiFactory,
    fleetFactory,
    systemFactory,
    leafletFactory,

    UnitData
    ) {

    $scope.fleetFactory = null;


    $scope.init = function () {
        $scope.fleetFactory = fleetFactory
    };

    $scope.load = function () {

    };

    $scope.init();
});