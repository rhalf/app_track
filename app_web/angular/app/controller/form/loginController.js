var app = angular.module('app');

app.controller('loginController', function ($scope, $cookies, $location, $http, authFactory, uiFactory) {


    $scope.init = function () {
        $scope.alert = uiFactory.alert;

        $scope.authUser = { Name: "", Password: "" };

        var object = authFactory.getAccessToken();

        if (!angular.isUndefined(object) && object != null) {
            $location.path('/form');
        }
    }

    $scope.closeAlert = function(index) {
        $scope.alert.closeItem(index);
    }



    $scope.login = function () {
        if (!$scope.loginForm.userName.$valid) {
            var alert = { type: 'danger', message: 'Username is empty or null.' };
            $scope.alert.addItem(alert);
            return;
        }
        if (!$scope.loginForm.userPassword.$valid) {
            var alert = { type: 'danger', message: 'Password is empty or null.' };
            $scope.alert.addItem(alert);
            return;
        }


        $http({
            url: 'http://184.107.179.181/v1/session/login/',
            method: 'POST',
            data: {
                Name: $scope.authUser.Name,
                Password: $scope.authUser.Password
            },
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            }
        })
       .success(function (data, status, headers, config) {
           console.log(data);
           authFactory.setAccessToken(data);
           $location.path('/form');
       })
       .error(function (data, status, header, config) {
           var alert = { type: 'danger', message: data.Message };
           $scope.alert.addItem(alert);
           authFactory.setAccessToken(null);

       });
    }

    $scope.init();
});

