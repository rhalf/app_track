var app = angular.module('app');


app.controller('ctPoiUpdateController', function (
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
    Poi,

    parent,
    poi

    ) {

    //Form
    $scope.update = function () {

        $scope.ui.isLoading = true;

        Poi.update(
            { id: $scope.poi.Id },
            $scope.poi,
            //Success
            function (result) {
                var alert = { type: 'success', message: '1 poi has been added successfully.' };
                $scope.ui.alert.addItem(alert);
                leafletFactory.loadPoi();
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

        $scope.poi = poi;

        $scope.companies = Company.query();
    };


    $scope.showMinimap = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/map/ct_map_marker.html',
            controller: 'ctMapMarkerController',
            keyboard: true,
            size: 'lg',
            resolve: {
                coordinate: function () {
                    return $scope.poi.Coordinate;
                }
            }
        }).result.then(function (result) {
            $scope.poi.Coordinate = result;
        });
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

