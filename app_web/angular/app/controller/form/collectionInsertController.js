/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for collectionInsertController. 
                            Used for inserting collection.
*/
var app = angular.module('app');


app.controller('collectionInsertController', function (
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
    validationFactory,

    Collection,
    Company,
    User,

    parent

    ) {

    //Form
    $scope.add = function () {
        $scope.ui.isLoading = true;

        Collection.save($scope.collection,
            //Success
            function (result) {
                $scope.fleet.loadCollections(function () {
                    parent.load();
                });

                $scope.ui.isLoading = false;

                var alert = { type: 'success', message: result.message };
                $scope.ui.alert.show(alert);
            },
            //Failed
            function (result) {
                $scope.ui.isLoading = false;

                var alert = { type: 'danger', message: result.data.message };
                $scope.ui.alert.show(alert);
            }
        );
    };

    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.valid = validationFactory;
        $scope.auth = authFactory;
        $scope.ui = uiFactory;
        $scope.fleet = fleetFactory;


        $scope.collection = new Collection();
        $scope.collection.company = $scope.auth.getCompany();
        $scope.users = User.getByCompany({ company: $scope.auth.getCompany().id });
    };
    
    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

