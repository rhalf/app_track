var app = angular.module('app');


app.controller('poiInsertController', function (
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


    parent,

    Collection,
    Company,
    User,
    Poi,

    parent
    ) {

    //Form
    $scope.add = function () {

        $scope.ui.isLoading = true;

        Poi.save($scope.poi,
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

    $scope.init = function () {
        $scope.flag = flagFactory;

        $scope.authUser = authFactory.getUser();

        $scope.ui = uiFactory;

        $scope.fleet = fleetFactory;

        $scope.object = parent;


        $scope.ui.alert.items = [];

        $scope.poi = new Poi();

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


    $scope.init();
});

