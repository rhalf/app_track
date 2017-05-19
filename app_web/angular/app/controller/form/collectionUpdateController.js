/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for collectionUpdateController. 
                            Used for updating collections.
*/
var app = angular.module('app');


app.controller('collectionUpdateController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,
    
    authFactory,
    flagFactory,
    uiFactory,
    fleetFactory,
    validationFactory,

    Company,
    Collection,
    User,
    
    collection,
    parent

    ) {

    $scope.toggle = function () {
        $scope.form.isDisabled = !$scope.form.isDisabled;
    };

    $scope.update = function () {
        $scope.ui.isLoading = true;

        Collection.update(
            { id: $scope.collection.id },
            $scope.collection,

            function (result) {
                //Success
                $scope.fleet.loadCollections();

                parent.load();
                $scope.toggle();

                $scope.ui.isLoading = false;

                var alert = { type: 'success', message: result.message };
                $scope.ui.alert.show(alert);
             
            },
            function (result) {
                //Failed
                $scope.toggle();
                $scope.ui.isLoading = false;

                var alert = { type: 'danger', message: result.data.message };
                $scope.ui.alert.show(alert);
            }
        );
    };

    $scope.init = function () {
        $scope.form = {};
        $scope.form.isDisabled = true;

        $scope.flag = flagFactory;
        $scope.auth = authFactory;
        $scope.valid = validationFactory;
        $scope.ui = uiFactory;
        $scope.fleet = fleetFactory;



        $scope.collection = collection;
        $scope.users = User.getByCompany({ company: $scope.auth.getCompany().id });

    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

