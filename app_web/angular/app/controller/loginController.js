var app = angular.module('app');

app.controller('loginController', function ($scope, $cookies, $location, $http, authFactory) {

    //Alerts
    $scope.alerts = [];
    $scope.addAlert = function (type, message) {
        $scope.alerts.push({ type: type, msg: message });
    };
    $scope.closeAlert = function (index) {
        $scope.alerts.splice(index, 1);
    };


    //User
    $scope.user = { name: '', password: '' };

    var object = authFactory.getAccessToken();
    
    if (!angular.isUndefined(object) && object != null) {
        $location.path('/form');
    }


    $scope.login = function () {

        
        if (!$scope.loginForm.userName.$valid) {
            $scope.addAlert('danger', "Username is empty or null.");
            return;
        }
        if (!$scope.loginForm.userPassword.$valid) {
            $scope.addAlert('danger', "Password is empty or null.");
            return;
        }

    


        $http({
            url: 'http://184.107.179.181/v1/session/login/',
            method: 'POST',
            data: {
                name: $scope.user.name,
                password: $scope.user.password
            },
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            }
        })
       .success(function (data, status, headers, config) {
           console.log(data);
           if (!data.Status) {
               authFactory.setAccessToken(data.Object[0]);
               $location.path('/form');
           } else {
               $scope.addAlert('danger', data.Message)
               authFactory.setAccessToken(null);
           }
       })
       .error(function (data, status, header, config) {
           console.log(status);
           authFactory = {};
       });
    } 
});

