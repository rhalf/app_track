/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for unitDeleteController. 
                            Used for deleting unit.
*/
var app = angular.module('app');


app.controller('unitDeleteController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,



    authFactory,
    flagFactory,
    uiFactory,

    Unit,

    unit,
    parent

    ) {

    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.ui = uiFactory;

        $scope.authUser = authFactory.getUser();

        $scope.unit = unit;
    }

    $scope.delete = function () {
        $scope.ui.isLoading = true;

        Unit.delete({ id: $scope.unit.id },
             function (result) {
                 $scope.fleet.loadVehicles(function () {
                     parent.load();
                 });
                 $scope.cancel();
                 $scope.ui.isLoading = false;
                 var alert = { type: 'success', message: result.message };
                 $scope.ui.alert.show(alert);
             },
            function (result) {
                $scope.ui.isLoading = false;
                var alert = { type: 'danger', message: result.data.message };
                $scope.ui.alert.show(alert);
            });
    };


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

