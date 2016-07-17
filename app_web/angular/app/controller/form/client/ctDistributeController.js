var app = angular.module('app');


app.controller('ctDistributeController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,

    authFactory,
    flagFactory,
    uiFactory,

    Company,
    Vehicle,
    Collection,
    VehicleCollection,
    Driver,
    Unit,
    Sim
    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getUser();
        $scope.authCompany = authFactory.getCompany();
        $scope.ui = uiFactory;
        $scope.load();
    };

    $scope.load = function () {
        //$scope.vehicles = Vehicle.query();
        $scope.companies = Company.query();
        $scope.collections = Collection.getByCompany({ Id: $scope.authCompany.Id });
    };

    $scope.getVehicles = function () {
        $scope.vehicles = [];
        VehicleCollection.getByCollection(
            { collection: $scope.selectedCollection },
            function (result) {
                angular.forEach(result, function (object, index) {
                    Vehicle.get(
                        { id: object.Vehicle },
                        function (vehicle) {
                            vehicle.Driver = Driver.get({ id: vehicle.Driver });
                            Unit.get(
                                 { id: vehicle.Unit },
                                 function (unit) {
                                     vehicle.Unit = unit;
                                     vehicle.Unit.Sim = Sim.get({ id: unit.Sim });
                                 });
                            $scope.vehicles.push(vehicle);
                        });
                });
            }
        );
    };

    $scope.getVehiclesForSet2 = function () {

    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

