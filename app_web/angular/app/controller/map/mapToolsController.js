var app = angular.module('app');


app.controller('mapToolsController', function (
    $scope,
    $timeout,
    $location,
     $uibModal,
     $uibModalInstance,



    authFactory,
    flagFactory,
    uiFactory,


    Company

    ) {

    $scope.init = function () {
        $scope.flag = flagFactory;

        $scope.authUser = authFactory.getUser();
        $scope.authCompany = authFactory.getCompany();

        $scope.ui = uiFactory;
        $scope.load();
    };

    $scope.load = function () {
        $scope.path = "app/view/map/areas.html";
    };
    $scope.showAreas = function () {
        $scope.path = "app/view/map/areas.html";
    };
    $scope.showGeofences = function () {
        $scope.path = "app/view/map/geofences.html";
    };
    $scope.showPois = function () {
        $scope.path = "app/view/map/pois.html";
    };
    $scope.showRoutes = function () {
        $scope.path = "app/view/map/routes.html";
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };
    
    $scope.init();
});

