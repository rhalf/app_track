var app = angular.module('app');


app.controller('geofenceDeleteController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,



    authFactory,
    flagFactory,
    uiFactory,
    leafletFactory,

    Geofence,

    geofence,
    parent

    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.ui = uiFactory;
        $scope.authUser = authFactory.getUser();

        $scope.geofence = geofence;
    }

    $scope.delete = function () {
        Geofence.delete({ id: $scope.geofence.id },
        //Success
        function (result) {
            leafletFactory.loadGeofence();
            parent.load();
            $scope.ui.isLoading = false;

            var alert = { type: 'success', message: result.message };
            $scope.ui.alert.show(alert);
            $scope.cancel();
        },
        //Failed
        function (result) {
            $scope.ui.isLoading = false;

            var alert = { type: 'danger', message: result.data.message };
            $scope.ui.alert.show(alert);
        });
    };


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

