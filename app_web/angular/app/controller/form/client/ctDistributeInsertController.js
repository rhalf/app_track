var app = angular.module('app');


app.controller('ctDistributeInsertController', function (
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

    collection
    ) {

    //Form
    $scope.save = function () {
        //console.log(collection);
        $scope.ui.isLoading = true;
        $scope.fleet.update(collection, function (result) {
            $scope.fleet.load(function () {
                $scope.load();
                $scope.ui.isLoading = false;
            });
        }, function (result) {
            var alert = { type: 'danger', message: result.Message };
            $scope.ui.alert.addItem(alert);
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

        $scope.ui.alert.items = [];

        $scope.fleet = fleetFactory;

        $scope.collection = collection;

        $scope.load();
    };

    $scope.load = function () {
        angular.forEach($scope.fleet.vehicles, function (vehicle1, index1) {
            vehicle1.Checked = false;
        });

        angular.forEach($scope.fleet.vehicles, function (vehicle1, index1) {
            angular.forEach($scope.collection.Vehicles, function (vehicle2, index2) {
                if (vehicle1.Id == vehicle2.Id) {
                    vehicle1.Checked = true;
                }
            });
        });
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

