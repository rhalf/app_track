/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for userDeleteController. 
                            Used for deleting user.
*/
var app = angular.module('app');


app.controller('userDeleteController', function (
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
    user,
    parent

    ) {

    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.ui = uiFactory;
        $scope.auth = authFactory;
        $scope.valid = validationFactory;
        $scope.user = user;
    }

    $scope.delete = function () {

        if ($scope.auth.getUser().privilege.value > $scope.user.privilege.value) {
            var alert = { type: 'danger', message: 'Cant delete user with privilege higher than your privilege.' };
            $scope.ui.alert.show(alert);
            return;
        }

        $scope.ui.isLoading = true;

        User.delete({ id: $scope.user.id },
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

