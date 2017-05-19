var app = angular.module('app');


app.controller('geofencesController', function (
    $scope,
    $timeout,
    $location,
     $uibModal,

    authFactory,
    flagFactory,
    uiFactory,

   Geofence

    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getUser();
        $scope.authCompany = authFactory.getCompany();
        $scope.ui = uiFactory;
  
        $scope.load();
    };

    $scope.load = function () {
        $scope.geofences = Geofence.getByCompany({ company: $scope.authCompany.id })
    };

    $scope.select = function (geofence) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/map/geofence_update.html',
            controller: 'geofenceUpdateController',
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
            templateUrl: 'app/view/map/geofence_delete.html',
            controller: 'geofenceDeleteController',
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
            templateUrl: 'app/view/map/geofence_insert.html',
            controller: 'geofenceInsertController',
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

