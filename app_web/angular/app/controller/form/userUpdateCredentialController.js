/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for userUpdateCredentialController. 
                            Used for updating user password.
*/
var app = angular.module('app');


app.controller('userUpdateCredentialController', function (
    $q,
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,
    


    authFactory,
    flagFactory,
    uiFactory,
    validationFactory,

    User,
    user

    ) {

    $scope.update = function () {
        if (validationFactory.password.notMatch($scope.user.password, $scope.user.password1)) {
            var alert = { type: 'danger', message: 'Password don\'t match...' };
            $scope.ui.alert.show(alert);
            return;
        }

        if (validationFactory.password.isShort($scope.user.password, $scope.user.password1)) {
            var alert = { type: 'danger', message: 'Password is short...' };
            $scope.ui.alert.show(alert);
            return;
        }

        $scope.ui.isLoading = true;

        User.setCredential(
            { id: $scope.user.id, type: 'credential' },
            $scope.user,
            function (result) {
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

    $scope.init = function () {
        $scope.ui = uiFactory;
        $scope.authUser = authFactory.getUser();
        $scope.flag = flagFactory;


        $scope.form = {};
        $scope.form.isDisabled = true;


        $scope.user = user;
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

