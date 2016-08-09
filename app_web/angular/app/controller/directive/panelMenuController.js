var app = angular.module('app');


app.controller('panelMenuController', function (
    $scope,
    $location,
    $uibModal,

    uiFactory,
    authFactory,
    flagFactory,
    systemFactory,

    sessionService,

    Company
    ) {

    $scope.setToggle = function () {
        uiFactory.panelLeft = !uiFactory.panelLeft;
    };

    $scope.logout = function () {
        authFactory.remove();
        $location.path('/')
    };


    //System
    $scope.showCompanies = function () {
        $scope.ui.panelSystemTemplate = 'app/view/form/system/companies.html';
    };

    $scope.showUsers = function () {
        $scope.ui.panelSystemTemplate = 'app/view/form/system/users.html';
    };


    $scope.showSims = function () {
        $scope.ui.panelSystemTemplate = 'app/view/form/system/sims.html';
    };

    $scope.showUnits = function () {
        $scope.ui.panelSystemTemplate = 'app/view/form/system/units.html';
    };

    $scope.showDrivers = function () {
        $scope.ui.panelSystemTemplate = 'app/view/form/system/drivers.html';
    };

    $scope.showVehicles = function () {
        $scope.ui.panelSystemTemplate = 'app/view/form/system/vehicles.html';
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
    
    //Map
    $scope.showClientPois = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/map/ct_pois.html',
            controller: 'ctPoisController',
            keyboard: true,
            size: 'lg'
        });
    };

    //About
    $scope.showAbout = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/about.html',
            controller: 'aboutController',
            keyboard: true,
            size: 'md'
        });
    };

    $scope.init = function () {
        $scope.authUser = authFactory.getUser();
        $scope.session = sessionService;
        $scope.flag = flagFactory;
        $scope.ui = uiFactory;
        $scope.system = systemFactory;
    };



    $scope.switchToSystem = function () {
        $scope.ui.panelSystem = !$scope.ui.panelSystem;
    };
   
    $scope.init();
});

