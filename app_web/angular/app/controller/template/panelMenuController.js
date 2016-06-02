var app = angular.module('app');


app.controller('panelMenuController', function ($scope, $location, $uibModal, uiFactory, authFactory, flagFactory) {
    $scope.setToggle = function () {
        console.log(uiFactory.panelLeft);
        uiFactory.panelLeft = !uiFactory.panelLeft;
    };

    $scope.logout = function () {
        authFactory.setAccessToken(null);
        $location.path('/')
    };


    //System
    $scope.showCompanies = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/companies.html',
            controller: 'companiesController',
            keyboard: true,
            size: 'lg',

        });
    };

    $scope.showUsers = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/users.html',
            controller: 'usersController',
            keyboard: true,
            size: 'lg',
        });
    };


    $scope.showSims = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/sims.html',
            controller: 'simsController',
            keyboard: true,
            size: 'lg',
        });
    };

    $scope.showUnits = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/units.html',
            controller: 'unitsController',
            keyboard: true,
            size: 'lg',
        });
    };
    
    $scope.showDrivers = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/drivers.html',
            controller: 'driversController',
            keyboard: true,
            size: 'lg'
        });
    };

    $scope.init = function () {
        $scope.authUser = authFactory.getAccessToken();

        if ($scope.authUser.Privilege > 2 || $scope.authUser.Privilege == 0) {
            $scope.isAllowed = false;
        } else {
            $scope.isAllowed = true;
        }

    };

    

    $scope.init();
});

