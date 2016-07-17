var app = angular.module('app');

app.controller('loginController', function (
    $scope,
    $cookies,
    $location,
    $http,
    authFactory,
    uiFactory,
    flagFactory,

    Session,

    Company
    ) {

    $scope.init = function () {
        $scope.ui = uiFactory;
        $scope.ui.isLoading = false;

        $scope.authUser = { Name: "", Password: "" };

        var user = authFactory.getUser();
        var company = authFactory.getCompany();

        if (user && company) {
            $location.path('/form');
        }
    }

    $scope.closeAlert = function (index) {
        $scope.ui.alert.closeItem(index);
    }



    $scope.login = function () {
        if (!$scope.loginForm.userName.$valid) {
            var alert = { type: 'danger', message: 'Username is empty or null.' };
            $scope.ui.alert.addItem(alert);
            return;
        }
        if (!$scope.loginForm.userPassword.$valid) {
            var alert = { type: 'danger', message: 'Password is empty or null.' };
            $scope.ui.alert.addItem(alert);
            return;
        }

        $scope.ui.isLoading = true;

        Session.login({
            Name: $scope.authUser.Name,
            Password: $scope.authUser.Password,
        },
        function (result) {

            var user = result;

            if (user.Privilege > 1) {

                var dateExp = new Date(user.DtExpired);
                var dateNow = new Date();

                if (dateNow.getTime() > dateExp.getTime()) {
                    var alert = { type: 'danger', message: 'Your account is EXPIRED.' };
                    $scope.ui.alert.addItem(alert);
                    $scope.ui.isLoading = false;
                    return;
                }

                switch (user.Status) {
                    case 0:
                        var alert = { type: 'danger', message: 'Your account is DISABLED.' };
                        $scope.ui.alert.addItem(alert);
                        $scope.ui.isLoading = false;
                        return;
                    case 1:
                        //Enabled
                        break;
                    case 2:
                        var alert = { type: 'danger', message: 'Your account is SUSPENDED.' };
                        $scope.ui.alert.addItem(alert);
                        $scope.ui.isLoading = false;
                        return;
                }

            }

            //======

            Company.get(
	            { id: user.Company },

	            function (result) {

	                var company = result;

	                switch (company.Status) {
	                    case 0:
	                        var alert = { type: 'danger', message: 'Your company account is DISABLED.' };
	                        $scope.ui.alert.addItem(alert);
	                        $scope.ui.isLoading = false;
	                        return;
	                    case 1:
	                        //Enabled
	                        authFactory.setUser(user);
	                        authFactory.setCompany(company);
	                        authFactory.save();

	                        $scope.ui.panelAdmin = false;
	                        $scope.ui.isLoading = false;

	                        $location.path('/form');
	                        break;
	                    case 2:
	                        var alert = { type: 'danger', message: 'Your company account is SUSPENDED.' };
	                        $scope.ui.alert.addItem(alert);
	                        $scope.ui.isLoading = false;
	                        return;
	                }
	            },
                function (result) {
                    var alert = { type: 'danger', message: result.Message };
                    $scope.ui.alert.addItem(alert);
                    $scope.ui.isLoading = false;
                    return;
                });
        },
        function (result) {
            var alert = { type: 'danger', message: result.data.Message };
            $scope.ui.alert.addItem(alert);
            $scope.ui.isLoading = false;
        });
    };
    
    $scope.init();
});

