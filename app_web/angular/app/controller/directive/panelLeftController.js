/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for panelLeftController.
*/
var app = angular.module('app');


app.controller('panelLeftController', function (
    $scope,
    $interval,
    $timeout,
    $uibModal,

    authFactory,
    flagFactory,
    uiFactory,
    fleetFactory,
    validationFactory,
    systemFactory,
    leafletFactory,

    Unit
    ) {



    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.auth = authFactory;
        $scope.ui = uiFactory;
        $scope.valid = validationFactory;
        $scope.system = systemFactory;

        $scope.load();
    };

    $scope.load = function () {

        $scope.selectedProperty = "Name";
        $scope.checkBox = {};
        $scope.checkBox.tracked = false;

        $scope.fleet = fleetFactory;
        $scope.fleet.load();
        $scope.update();
    };



    $scope.showReports = function (vehicle) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/report/option.html',
            controller: 'optionController',
            keyboard: true,
            size: 'md',
            resolve: {
                vehicle: vehicle
            }
        });
    };


    $scope.setFocus = function (vehicle) {

        if (!vehicle) return;
        if (!vehicle.unit) return;
        if (!vehicle.unit.unitData) return;

        angular.forEach($scope.fleet.vehicles, function (fleetVehicle, index) {
            if (fleetVehicle.id == vehicle.id) {
                fleetVehicle.selected = true;
            } else {
                fleetVehicle.selected = false;
            }
        });

        leafletFactory.findVehicle(vehicle);
        leafletFactory.refresh();
    };

    $scope.checkByCollection = function (collection) {
        angular.forEach(collection.vehiclesIds, function (item, index) {
            angular.forEach(fleetFactory.vehicles, function (vehicle, index) {
                if (item.vehicleId == vehicle.id)
                    if (vehicle.unit) {
                        if (!$scope.valid.isExpired(vehicle.unit.dtExpired))
                            vehicle.tracked = $scope.checkBox.tracked;
                    }
            });
        });
        if (!$scope.checkBox.tracked)
            leafletFactory.removeVehicles();
    };

    $scope.update = function () {

        //Adding/Updating vehicles from array to the map
        //Removing vehicles from array to the map
        $interval(function () {
            angular.forEach($scope.fleet.vehicles,
                function (vehicle, index) {
                    if (vehicle.unit) {
                        if (vehicle.tracked) {
                            leafletFactory.setVehicle(vehicle);
                            leafletFactory.setGeofence(vehicle.unit.unitData);
                            leafletFactory.setArea(vehicle.unit.unitData);
                        } else {
                            leafletFactory.removeVehicle(vehicle);
                        }
                    }
                });
        }, 1500);

        //Updating vehicle.unit.unitData
        $interval(function () {
            angular.forEach($scope.fleet.vehicles,
                function (vehicle, index) {
                    if (vehicle.tracked) {
                        Unit.get(
                            { id: vehicle.unit.id },
                            function (result) {
                                vehicle.unit = result;
                            });
                    }
                });
        }, 30000);
    };

    $scope.getProperty = function (vehicle) {
        switch ($scope.selectedProperty) {
            case 'Name':
                return vehicle.name;
            case 'Plate':
                return vehicle.plate;
            case 'UnitImei':
                if (vehicle.unit)
                    return vehicle.unit.imei;
                else
                    return '';
            case 'SimNumber':
                if (vehicle.unit.sim)
                    return vehicle.unit.sim.number;
                else
                    return '';
            case 'DriverName':
                if (vehicle.driver)
                    return vehicle.driver.name;
                else
                    return '';
        }
    };

    $scope.hide = function (collection) {

        if (!$scope.auth.getUser()) return true;
        if (!$scope.auth.getUser().privilege) return true;
        if (!$scope.auth.getUser().privilege.value) return true;

        if ($scope.auth.getUser().privilege.value < 4) {
            return false;
        }

        if ($scope.auth.getUser().privilege.value > collection.user.privilege.value)
            return true;

        if ($scope.auth.getUser().privilege.value == collection.user.privilege.value) {
            if ($scope.auth.getUser().id == collection.user.id) {
                return false;
            }
            return true;

        }
    };

    //$scope.sleep = function (milliseconds) {
    //    var start = new Date().getTime();
    //    for (var i = 0; i < 1e7; i++) {
    //        if ((new Date().getTime() - start) > milliseconds) {
    //            break;
    //        }
    //    }
    //};

    $scope.init();
});