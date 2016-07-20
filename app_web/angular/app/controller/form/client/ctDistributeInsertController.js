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
            var alert = { type: 'success', message: '1 collection has been updated successfully.' };
            $scope.ui.alert.addItem(alert);
            $scope.fleet.load(function () {
                $scope.ui.isLoading = false;
            });
        });
    };

    //Alert
    $scope.closeAlert = function (index) {
        $scope.ui.alert.closeItem(index);
    };

    $scope.clearUser = function () {
        $scope.collection.User = null;
    };

    $scope.init = function () {
        $scope.flag = flagFactory;

        $scope.authUser = authFactory.getUser();
        $scope.authCompany = authFactory.getCompany();

        $scope.ui = uiFactory;

        $scope.ui.alert.items = [];

        $scope.fleet = fleetFactory;

        $scope.collection = collection;
    };

    $scope.load = function () {
        angular.forEach($scope.fleet.vehicles, function (vehicle, index1) {
            $scope.fleet.getVehicleCollections(collection, function (vehicleCollection) {
                angular.forEach(vehicleCollection, function (object, index2) {
                    if (vehicle.Id == object.Vehicle) {
                        vehicle.Checked = true;
                    }
                });
            });
        });
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

