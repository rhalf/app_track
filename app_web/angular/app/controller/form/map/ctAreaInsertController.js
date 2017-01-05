var app = angular.module('app');


app.controller('ctAreaInsertController', function (
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

        Area.save(
            $scope.area,
            //Success
            function (result) {
                var alert = { type: 'success', message: '1 area has been added successfully.' };
                $scope.ui.alert.addItem(alert);
                leafletFactory.loadArea();
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

        $scope.area = new Area();
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
                    return $scope.area.Coordinates
                }
            }
        }).result.then(function (result) {
            $scope.area.Coordinates = result;
        });
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

