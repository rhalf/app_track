var app = angular.module('app');


app.controller('areaInsertController', function (
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
    Area,

    parent
    ) {

    //Form
    $scope.add = function () {

        $scope.ui.isLoading = true;

        Area.save($scope.area,
        //Success
        function (result) {
            leafletFactory.loadArea();
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

        $scope.ui.alert.items = [];

        $scope.area = new Area();
        $scope.companies = Company.query();

    };


    $scope.showMinimap = function () {

        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/map/map_polygon.html',
            controller: 'mapPolygonController',
            keyboard: true,
            size: 'lg',
            resolve: {
                coordinates: function () {
                    return $scope.area.coordinates
                }
            }
        }).result.then(function (result) {
            $scope.area.coordinates = result;
        });
    };


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

