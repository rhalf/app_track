var app = angular.module('app');


app.controller('panelMenuController', function (
    $scope,
    $location,
    $uibModal,

    uiFactory,
    authFactory,
    flagFactory,

    sessionService,

    Company
    ) {

    $scope.setToggle = function () {
        console.log(uiFactory.panelLeft);
        uiFactory.panelLeft = !uiFactory.panelLeft;
    };

    $scope.logout = function () {
        authFactory.remove();
        $location.path('/')
    };


    //System
    $scope.showCompanies = function () {
        $scope.ui.panelAdminTemplate = 'app/view/form/system/companies.html';
    };

    $scope.showUsers = function () {
        $scope.ui.panelAdminTemplate = 'app/view/form/system/users.html';
    };


    $scope.showSims = function () {
        $scope.ui.panelAdminTemplate = 'app/view/form/system/sims.html';
    };

    $scope.showUnits = function () {
        $scope.ui.panelAdminTemplate = 'app/view/form/system/units.html';
    };

    $scope.showDrivers = function () {
        $scope.ui.panelAdminTemplate = 'app/view/form/system/drivers.html';
    };

    $scope.showVehicles = function () {
        $scope.ui.panelAdminTemplate = 'app/view/form/system/vehicles.html';
    };


    //client
    $scope.showClientCompany = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/client/ct_company_update.html',
            controller: 'ctCompanyUpdateController',
            keyboard: true,
            size: 'md',
            resolve: {
                company: $scope.authCompany
            }
        });
    };

    $scope.showClientUnits= function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/client/ct_units.html',
            controller: 'ctUnitsController',
            keyboard: true,
            size: 'lg'
        });
    };

    $scope.showClientUsers = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/client/ct_users.html',
            controller: 'ctUsersController',
            keyboard: true,
            size: 'lg'
        });
    };

    $scope.showClientSims = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/client/ct_sims.html',
            controller: 'ctSimsController',
            keyboard: true,
            size: 'lg'
        });
    };

    $scope.showClientDrivers = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/client/ct_drivers.html',
            controller: 'ctDriversController',
            keyboard: true,
            size: 'lg'
        });
    };

    $scope.showClientVehicles = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/client/ct_vehicles.html',
            controller: 'ctVehiclesController',
            keyboard: true,
            size: 'lg'
        });
    };


    $scope.showClientCollections = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/client/ct_collections.html',
            controller: 'ctCollectionsController',
            keyboard: true,
            size: 'lg'
        });
    };


    $scope.showClientDistribute = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/client/ct_distribute.html',
            controller: 'ctDistributeController',
            keyboard: true,
            size: 'lg'
        });
    };

    $scope.init = function () {
        $scope.authUser = authFactory.getUser();
        $scope.authCompany = authFactory.getCompany();
        $scope.session = sessionService;
        $scope.flag = flagFactory;
        $scope.ui = uiFactory;
    };



    $scope.switchToAdmin = function () {
        $scope.ui.panelAdmin = true;
    };
    $scope.switchToUser = function () {
        $scope.ui.panelAdmin = false;
    };
    $scope.init();
});

