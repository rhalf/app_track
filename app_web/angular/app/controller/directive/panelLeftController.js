var app = angular.module('app');


app.controller('panelLeftController', function (
    $scope,

    authFactory,
    flagFactory,
    uiFactory,
    fleetFactory,
    systemFactory


    ) {

    $scope.init = function () {
        $scope.flag = flagFactory;

        $scope.authUser = authFactory.getUser();
        $scope.authCompany = authFactory.getCompany();

        $scope.ui = uiFactory;
        $scope.system = systemFactory;

        $scope.load();
    };

    $scope.load = function () {
        $scope.accordion = [];
        $scope.max = 20;

        for (var x = 0; x < $scope.max; x++) {
            $scope.accordion[x] = false;
        }

        console.log($scope.accordion);

        $scope.fleet = fleetFactory;
        $scope.fleet.load();
    };

    $scope.logout = function () {
        authFactory.remove();
        $location.path('/')
    };

    $scope.init();
});