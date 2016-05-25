var app = angular.module('app');


app.controller('panelMenuController', function ($scope, $location, $uibModal, uiFactory, authFactory) {




    $scope.setToggle = function () {
        uiFactory.panelLeft = !uiFactory.panelLeft;
    };

    $scope.logout = function () {
        authFactory.setAccessToken(null);
        $location.path('/')
    };


    $scope.showCompanies = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/companies.html',
            controller: 'companiesController',
            keyboard: true,
            size: 'lg',

        });
    };

    $scope.showUsers = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/users.html',
            controller: 'usersController',
            keyboard: true,
            size: 'lg',
        });
    };

    $scope.showUnits = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/units.html',
            controller: 'unitsController',
            keyboard: true,
            size: 'lg',
        });
    };

    $scope.init = function () {
        $scope.AuthUser = authFactory.getAccessToken();

        if ($scope.AuthUser.Privilege > 2 || $scope.AuthUser.Privilege == 0) {
            $scope.isAllowed = false;
        } else {
            $scope.isAllowed = true;
        }
      
    }
    

    $scope.init();
});

