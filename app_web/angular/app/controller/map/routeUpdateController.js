var app = angular.module('app');


app.controller('routeUpdateController', function (
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
    Route,

    parent,
    route

    ) {

    //Form
    $scope.update = function () {

        $scope.ui.isLoading = true;

        Route.update({ id: $scope.route.id }, $scope.route,
        //Success
        function (result) {
            leafletFactory.loadRoute();
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

        $scope.route = route;

        $scope.companies = Company.query();
    };


    $scope.showMinimap = function () {

        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/map/map_polyline.html',
            controller: 'mapPolylineController',
            keyboard: true,
            size: 'lg',
            resolve: {
                coordinates: function () {
                    return $scope.route.coordinates
                }
            }
        }).result.then(function (result) {
            $scope.route.coordinates = result;
        });
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

