var app = angular.module('app');

app.controller('loginController', function ($scope, $cookies) {

   //Alerts
    $scope.alerts = [];
    $scope.addAlert = function (type, message) {
        $scope.alerts.push({ type: type, msg: message });
    };
    $scope.closeAlert = function (index) {
        $scope.alerts.splice(index, 1);
    };

    $scope.user = {};

    $scope.user = $cookies.getObject('user');

    $scope.login = function () {

        //Validation
        if ($scope.user.name == null) {
            $scope.addAlert('danger', "Username is empty or null.");
            $scope.user.name = null;
            return;
        }
        if ($scope.user.password == null) {
            $scope.addAlert('danger', "Password is empty or null.");
            $scope.user.password = null;
            return;
        }
     
        $cookies.putObject('user', $scope.user);

        console.log($cookies.getObject('user'));
    }
   
});

