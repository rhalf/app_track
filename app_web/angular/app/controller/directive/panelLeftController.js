var app = angular.module('app');


app.controller('panelLeftController', function (
    $scope,
    $interval,
    $timeout,

    authFactory,
    flagFactory,
    uiFactory,
    fleetFactory,
    systemFactory,
    leafletFactory,

    UnitData
    ) {

    $scope.vehicles = [];


    $scope.init = function () {
        $scope.flag = flagFactory;

        $scope.authUser = authFactory.getUser();

        $scope.ui = uiFactory;
        $scope.system = systemFactory;

        $scope.load();
    };

    $scope.load = function () {
        $scope.accordion = [];
        $scope.max = 20;

        for (var x = 0; x < $scope.max; x++) {
            $scope.accordion[x] = false;
        }

        console.log($scope.accordion);

        $scope.fleet = fleetFactory;
        $scope.fleet.load();
        $scope.update();
    };

    //$scope.check = function (newVehicle) {
    //    if (newVehicle.Tracked) {
    //        $scope.vehicles.push(newVehicle);
    //        console.log(newVehicle);

    //    } else {
    //        angular.forEach($scope.vehicles, function (vehicle, index) {
    //            if (newVehicle.Id == vehicle.Id) {
    //                $scope.vehicles.splice(index, 1);
    //            }
    //        });

    //    }
    //};

    $scope.update = function () {

        //Adding/Updating vehicles from array to the map
        $interval(function () {
            angular.forEach($scope.fleet.collections, function (collection, index) {
                angular.forEach(collection.Vehicles, function (vehicle, index) {
                    if (vehicle.Tracked) {
                        $timeout(function () {
                            leafletFactory.setVehicle(vehicle);
                        }, 100);
                    } 
                    //$scope.sleep(500);
                });
                //$scope.sleep(500);
            });
        }, 1000);

        //Removing vehicles from array to the map
        $interval(function () {
            angular.forEach($scope.fleet.collections, function (collection, index) {
                angular.forEach(collection.Vehicles, function (vehicle, index) {
                    if (!vehicle.Tracked) {
                        $timeout(function () {
                            leafletFactory.removeVehicle(vehicle);
                        }, 100);
                    }
                    //$scope.sleep(500);
                });
                //$scope.sleep(500);
            });
        }, 1000);

        //Updating vehicle.unit.UnitData
        $interval(function () {
            angular.forEach($scope.fleet.collections, function (collection, index) {
                angular.forEach(collection.Vehicles, function (vehicle, index) {
                    if (vehicle.Tracked) {
                        $timeout(function () {
                            UnitData.get(
                                { imei: vehicle.Unit.Imei },
                                function (result) {
                                    vehicle.Unit.UnitData = result;
                                });
                        }, 1000);
                    }
                    $scope.sleep(500);
                });
                $scope.sleep(500);
            });
        }, 20000);
    };


    $scope.sleep = function (milliseconds) {
        var start = new Date().getTime();
        for (var i = 0; i < 1e7; i++) {
            if ((new Date().getTime() - start) > milliseconds) {
                break;
            }
        }
    };

    $scope.init();
});