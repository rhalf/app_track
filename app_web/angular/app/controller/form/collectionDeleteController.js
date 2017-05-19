/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for collectionDeleteController. 
                            Used for deleting collection.
*/
var app = angular.module('app');


app.controller('collectionDeleteController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,



    authFactory,
    flagFactory,
    uiFactory,
    fleetFactory,

    Collection,

    collection,
    parent

    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.ui = uiFactory;
        $scope.auth = authFactory;
        $scope.fleet = fleetFactory;
        $scope.collection = collection;
    }

    $scope.delete = function () {
        $scope.ui.isLoading = true;
        Collection.delete({ id: $scope.collection.id },
            function (result) {
                $scope.fleet.loadCollections(function () {
                    parent.load();
                });

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

