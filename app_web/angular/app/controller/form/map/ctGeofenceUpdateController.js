var app = angular.module('app');


app.controller('ctGeofenceUpdateController', function (
    $scope,
    $filter,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,

    authFactory,
    flagFactory,
    uiFactory,
    fleetFactory,
    leafletFactory,

    Collection,
    Company,
    User,
    Geofence,

    parent,
    geofence

    ) {

    //Form
    $scope.update = function () {

        $scope.ui.isLoading = true;

        Geofence.update(
            { id: $scope.geofence.Id },
            $scope.geofence,
            //Success
            function (result) {
                var alert = { type: 'success', message: '1 geofence has been added successfully.' };
                $scope.ui.alert.addItem(alert);
                leafletFactory.loadGeofence();
                parent.load();
                $scope.ui.isLoading = false;

            },
            //Failed
            function (result) {
                var alert = { type: 'danger', message: result.data.Message };
                $scope.ui.alert.addItem(alert);
                $scope.ui.isLoading = false;

            }
        );
    };

    //Alert
    $scope.closeAlert = function (index) {
        $scope.ui.alert.closeItem(index);
    };

    $scope.init = function () {
        $scope.flag = flagFactory;

        $scope.authUser = authFactory.getUser();

        $scope.ui = uiFactory;

        $scope.fleet = fleetFactory;

        $scope.ui.alert.items = [];

        $scope.geofence = geofence;

        $scope.companies = Company.query();
    };


    $scope.showMinimap = function () {

        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/map/ct_map_polygon.html',
            controller: 'ctMapPolygonController',
            keyboard: true,
            size: 'lg',
            resolve: {
                coordinates: function () {
                    return $scope.geofence.Coordinates
                }
            }
        }).result.then(function(result) {
            $scope.geofence.Coordinates = result;
        });
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

