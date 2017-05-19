/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for distributeController. 
                            Used for distributing vehicles.
*/
var app = angular.module('app');


app.controller('distributeController', function (
    $scope,
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


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getUser();
        $scope.ui = uiFactory;
        $scope.fleet = fleetFactory;

        $scope.collectionId = collection.id;
        $scope.load();
    };

    $scope.load = function () {

        angular.forEach($scope.fleet.collections, function (item, index) {
            if ($scope.collectionId == item.id) {
                $scope.collection = item;
            }
        });

        angular.forEach($scope.fleet.vehicles, function (fleetVehicle, index) {
            fleetVehicle.checked = false;
            angular.forEach($scope.collection.vehiclesIds, function (vc, index) {
                if (fleetVehicle.id == vc.vehicleId) {
                    fleetVehicle.checked = true;
                }
            });
        });
    };

    $scope.save = function () {

        $scope.ui.isLoading = true;

        $scope.fleet.update($scope.collection,

            function (result) {
                $scope.fleet.loadCollections(function () {
                    $scope.load();
                });

                $scope.ui.isLoading = false;
                var alert = { type: 'success', message: result.message };
                $scope.ui.alert.show(alert);
            }, function (result) {
                $scope.ui.isLoading = false;
                var alert = { type: 'danger', message: result.data.message };
                $scope.ui.alert.show(alert);
            });
    };

    $scope.checkAll = function (value) {
        angular.forEach($scope.fleet.vehicles, function (fleetVehicle, index) {
            fleetVehicle.checked = value;
        });
    };


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

