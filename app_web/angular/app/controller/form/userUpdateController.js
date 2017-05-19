/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for userUpdateController. 
                            Used for updating user.
*/
var app = angular.module('app');


app.controller('userUpdateController', function (
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

    Company,
    Sim,
    User,
    UserInfo,

    user,
    parent
    ) {



    $scope.toggle = function () {
        $scope.form.isDisabled = !$scope.form.isDisabled;
    };

    $scope.update = function () {
        $scope.toggle();

        if ($scope.valid.isNullOrEmpty($scope.user.name)) {
            var alert = { type: 'danger', message: 'Username is null or Empty...' };
            $scope.ui.alert.show(alert);
            return;
        }

        if ($scope.auth.getUser().privilege.value > $scope.user.privilege.value) {
            var alert = { type: 'danger', message: 'Cant create user with privilege higher than your privilege.' };
            $scope.ui.alert.show(alert);
            return;
        }

        $scope.ui.isLoading = true;

        UserInfo.update({ id: $scope.userInfo.id }, $scope.userInfo,
            function (result) {
                //Success
                parent.load();
                $scope.ui.isLoading = false;
                var alert = { type: 'success', message: result.message };
                $scope.ui.alert.show(alert);
            },
            function (result) {
                //Failed
                $scope.ui.isLoading = false;
                var alert = { type: 'danger', message: result.data.message };
                $scope.ui.alert.show(alert);
            });

        User.update({ id: $scope.user.id }, $scope.user,
            function (result) {
                //Success
                parent.load();
                $scope.ui.isLoading = false;
                var alert = { type: 'success', message: result.message };
                $scope.ui.alert.show(alert);
            },
            function (result) {
                //Failed
                $scope.ui.isLoading = false;
                var alert = { type: 'danger', message: result.data.message };
                $scope.ui.alert.show(alert);
            });
    };

    $scope.init = function () {
        $scope.form = {};
        $scope.form.isDisabled = true;

        $scope.flag = flagFactory;
        $scope.ui = uiFactory;
        $scope.valid = validationFactory;
        $scope.auth = authFactory;

        $scope.ui.dateTimePicker.isOpen = [
        false, //dateTimePicker1
        false  //dateTimePicker2
        ];

        $scope.ui.dateTimePicker.toggle = function (index) {
            $scope.ui.dateTimePicker.isOpen[index] = !$scope.ui.dateTimePicker.isOpen[index];
        };

        $scope.user = user;
        $scope.userInfo = UserInfo.get({ user: user.id });
        $scope.sims = Sim.getByCompany({ company: $scope.auth.getCompany().id });

    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };


    $scope.init();
});

