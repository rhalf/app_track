var app = angular.module('app');


app.controller('areaUpdateController', function (
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
    Area,

    parent,
    area

    ) {

    //Form
    $scope.update = function () {

        $scope.ui.isLoading = true;

        Area.update({ id: $scope.area.id }, $scope.area,
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

        $scope.area = area;

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

