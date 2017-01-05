var app = angular.module('app');


app.controller('ctGeofenceDeleteController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    leafletFactory,

    Geofence,

    geofence,
    parent

    ) {
    

    $scope.init = function () {
        $scope.flag = flagFactory;

        $scope.authUser = authFactory.getUser();

        $scope.geofence = geofence;
    }

    $scope.delete = function () {
        Geofence.delete({ id: $scope.geofence.Id }, function (result) {
            leafletFactory.loadGeofence();
            parent.load();
            $scope.cancel();
        });
    };


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

