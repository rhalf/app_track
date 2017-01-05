var app = angular.module('app');


app.controller('ctGeofencesController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,

    authFactory,
    flagFactory,
    uiFactory,

   Geofence

    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getUser();
        $scope.ui = uiFactory;
  
        $scope.load();
    };

    $scope.load = function () {
        $scope.geofences = Geofence.getByCompany({company : $scope.authUser.Company.Id })
    };

    $scope.select = function (geofence) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/map/ct_geofence_update.html',
            controller: 'ctGeofenceUpdateController',
            keyboard: true,
            size: 'md',
            resolve: {
                geofence: geofence,
                parent: $scope
            }
        });
    };

    $scope.delete = function (geofence) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/map/ct_geofence_delete.html',
            controller: 'ctGeofenceDeleteController',
            keyboard: true,
            size: 'md',
            resolve: {
                geofence: geofence,
                parent: $scope
            }
        });
    };

    $scope.add = function (collection) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/map/ct_geofence_insert.html',
            controller: 'ctGeofenceInsertController',
            keyboard: true,
            size: 'md',
            resolve: {
                parent: $scope
            }
        });
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

