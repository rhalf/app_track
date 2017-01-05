var app = angular.module('app');


app.controller('ctRouteInsertController', function (
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
    Route,

    parent
    ) {

    //Form
    $scope.add = function () {

        $scope.ui.isLoading = true;

        Route.save(
            $scope.route,
            //Success
            function (result) {
                var alert = { type: 'success', message: '1 route has been added successfully.' };
                $scope.ui.alert.addItem(alert);
                leafletFactory.loadRoute();
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

        $scope.route = new Route();
        $scope.companies = Company.query();

    };


    $scope.showMinimap = function () {

        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/map/ct_map_polyline.html',
            controller: 'ctMapPolylineController',
            keyboard: true,
            size: 'lg',
            resolve: {
                coordinates: function () {
                    return $scope.route.Coordinates
                }
            }
        }).result.then(function (result) {
            $scope.route.Coordinates = result;
        });
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

