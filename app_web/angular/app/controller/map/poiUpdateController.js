var app = angular.module('app');


app.controller('poiUpdateController', function (
    $scope,
    $filter,
    $timeout,
    $location,
     $uibModal,$uibModalInstance,
    $uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,
    fleetFactory,
    leafletFactory,



    Collection,
    Company,
    User,
    Poi,

    parent,
    poi

    ) {

    //Form
    $scope.update = function () {

        $scope.ui.isLoading = true;

        Poi.update({ id: $scope.poi.id }, $scope.poi,
        //Success
        function (result) {
            leafletFactory.loadPoi();
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

        $scope.poi = poi;

        $scope.companies = Company.query();
    };


    $scope.showMinimap = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/map/map_marker.html',
            controller: 'mapMarkerController',
            keyboard: true,
            size: 'lg',
            resolve: {
                coordinate: function () {
                    return $scope.poi.coordinate;
                }
            }
        }).result.then(function (result) {
            $scope.poi.coordinate = result;
        });
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

