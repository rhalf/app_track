/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for usersController. 
                            Used for managing users.
*/
var app = angular.module('app');


app.controller('usersController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,


    authFactory,
    flagFactory,
    uiFactory,
    exportFactory,

    Company,
    User

    ) {

    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getUser();
        $scope.authCompany = authFactory.getCompany();
        $scope.ui = uiFactory;
        $scope.load();
    };

    $scope.load = function () {
        $scope.users = User.getByCompany({ company: $scope.authCompany.id });
    };

    $scope.select = function (user) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/user_update.html',
            controller: 'userUpdateController',
            keyboard: true,
            size: 'md',
            resolve: {
                user: user,
                parent : $scope
            }
        });
    };
    $scope.delete = function (user) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/user_delete.html',
            controller: 'userDeleteController',
            keyboard: true,
            size: 'md',
            resolve: {
                user: user,
                parent: $scope
            }
        });
    };

    $scope.add = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/user_insert.html',
            controller: 'userInsertController',
            keyboard: true,
            size: 'md',
            resolve: {
                parent : $scope
            }
        });
    };

    $scope.credential = function (user) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/user_update_credential.html',
            controller: 'userUpdateCredentialController',
            keyboard: true,
            size: 'md',
            resolve: {
                user: user
            }
        });
    };

    $scope.download = function () {
        exportFactory.usersToCsv($scope.users, $scope.authCompany);
    };

    $scope.init();
});

