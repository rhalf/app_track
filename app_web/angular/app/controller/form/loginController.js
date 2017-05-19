/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for loginController. 
                            Used for logging in authenticated user.
*/
var app = angular.module('app');

app.controller('loginController', function (
    $scope,
    $cookies,
    $location,
    $http,
    authFactory,
    uiFactory,
    flagFactory,
    validationFactory,

    Session,

    Company
    ) {

    $scope.init = function () {
        $scope.ui = uiFactory;
        $scope.valid = validationFactory;
        $scope.ui.isLoading = false;

        $scope.authUser = { name: "", password: "" };


        if (authFactory.getUser()) {
            $location.path('/form');
        }
    }


    $scope.login = function () {
        if (!$scope.loginForm.userName.$valid) {
            var alert = { type: 'danger', message: 'Username is empty or null.' };
            $scope.ui.alert.show(alert);
            return;
        }
        if (!$scope.loginForm.userPassword.$valid) {
            var alert = { type: 'danger', message: 'Password is empty or null.' };
            $scope.ui.alert.show(alert);
            return;
        }

        $scope.ui.isLoading = true;

        Session.login({
            name: $scope.authUser.name,
            password: $scope.authUser.password,
        },
        function (user) {

            if (user.privilege.value > 1) {

                if ($scope.valid.isExpired(user.dtExpired)) {
                    $scope.ui.isLoading = false;

                    var alert = { type: 'danger', message: 'Your account is EXPIRED.' };
                    $scope.ui.alert.show(alert);
                    return;
                }
            }

            switch (user.status.value) {
                case 0:
                    $scope.ui.isLoading = false;

                    var alert = { type: 'danger', message: 'Your account is DISABLED.' };
                    $scope.ui.alert.show(alert);
                    return;
                case 1:
                    //Enabled
                    break;
                case 2:
                    $scope.ui.isLoading = false;
                    var alert = { type: 'danger', message: 'Your account is SUSPENDED.' };
                    $scope.ui.alert.show(alert);
                    return
            }


            switch (user.company.status.value) {
                case 0:
                    $scope.ui.isLoading = false;

                    var alert = { type: 'danger', message: 'Your company account is DISABLED.' };
                    $scope.ui.alert.show(alert);
                    return;
                case 1:
                    //Enabled
                    authFactory.clear();

                    authFactory.setUser(user);
                    authFactory.setCompany(user.company);

                    $scope.ui.isLoading = false;


                    $location.path('/form');
                    break;
                case 2:
                    $scope.ui.isLoading = false;

                    var alert = { type: 'danger', message: 'Your company account is SUSPENDED.' };
                    $scope.ui.alert.show(alert);
                    return;
            }

        },
        function (result) {
            $scope.ui.isLoading = false;

            var alert = { type: 'danger', message: result.data.message };
            $scope.ui.alert.show(alert);
        });
    };

    $scope.init();
});

