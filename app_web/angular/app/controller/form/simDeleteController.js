/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for simDeleteController. 
                            Used for deleting sims.
*/
var app = angular.module('app');


app.controller('simDeleteController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,
    
    authFactory,
    flagFactory,
    uiFactory,

    Sim,

    sim,
    parent

    ) {

    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.ui = uiFactory;
        $scope.authUser = authFactory.getUser();
        $scope.sim = sim;
    };

    $scope.delete = function () {
        $scope.ui.isLoading = true;

        Sim.delete({ id: $scope.sim.id },
             function (result) {
                 parent.load();
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

