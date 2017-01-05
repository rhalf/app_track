var app = angular.module('app');

app.controller('panelContainerController', function (
    $scope,
    $interval,
    uiFactory,
    flagFactory,
    authFactory,
    UserOnline
    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.ui = uiFactory;

        $scope.authUser = authFactory.getUser();

        var userOnline = new UserOnline();
        userOnline.User = $scope.authUser;



        UserOnline.save(userOnline);
        $interval(function () {
            UserOnline.save(userOnline);
        }, 300000);//300000);
    };

    $scope.init();
});