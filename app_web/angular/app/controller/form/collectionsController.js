/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for collectionsController. 
                            Used for managing collections.
*/
var app = angular.module('app');


app.controller('collectionsController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,

    authFactory,
    flagFactory,
    uiFactory,
    exportFactory,

    Collection,
    Company,
    User

    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.auth = authFactory;
        $scope.ui = uiFactory;
        $scope.load();
    };

    $scope.load = function () {
        $scope.collections = Collection.getByCompany({ company: $scope.auth.getCompany().id });
    };

    $scope.select = function (collection) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/collection_update.html',
            controller: 'collectionUpdateController',
            keyboard: true,
            backdropClick: true,
            size: 'md',
            resolve: {
                collection: collection,
                parent: $scope
            }
        });
    };

    $scope.delete = function (collection) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/collection_delete.html',
            controller: 'collectionDeleteController',
            keyboard: true,
            backdropClick: true,
            size: 'md',
            resolve: {
                collection: collection,
                parent: $scope
            }
        });
    };

    $scope.add = function (collection) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/collection_insert.html',
            controller: 'collectionInsertController',
            backdropClick: true,
            keyboard: true,
            size: 'md',
            resolve: {
                parent: $scope
            }
        });
    };
    
    $scope.distribute = function (collection) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/distribute.html',
            controller: 'distributeController',
            backdropClick: true,
            keyboard: true,
            size: 'lg',
            resolve: {
                collection: collection,
                parent: $scope
            }
        });
    };

    $scope.download = function () {
        exportFactory.collectionsToCsv($scope.collections, $scope.auth.getCompany());
    };

    $scope.init();
});

