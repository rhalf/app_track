/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for companiesController. 
                            Used for managing companies.
*/
var app = angular.module('app');


app.controller('companiesController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,



    authFactory,
    flagFactory,
    uiFactory,
    exportFactory,

    fleetFactory,
    leafletFactory,


    Company

    ) {

    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.auth = authFactory;
        $scope.ui = uiFactory;
        $scope.load();
    };

    $scope.load = function () {
        $scope.companies = Company.query();
    };

    $scope.select = function (company) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/company_update.html',
            controller: 'companyUpdateController',
            keyboard: true,
            size: 'md',
            resolve: {
                company: company,
                parent : $scope
            }
        });
    }

    $scope.add = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/company_insert.html',
            controller: 'companyInsertController',
            keyboard: true,
            size: 'md',
            resolve: {
                parent: $scope
            }
        });
    }

    $scope.delete = function (company) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/company_delete.html',
            controller: 'companyDeleteController',
            keyboard: true,
            size: 'md',
            resolve: {
                company: company,
                parent: $scope
            }
        });
    };

    $scope.set = function (company) {
        authFactory.setCompany(company);

        $scope.ui.isLoading = true;

        fleetFactory.load(function () {
            leafletFactory.load(function () {
                $scope.ui.isLoading = false;
            });
        });
    };

    $scope.download = function () {
        exportFactory.companiesToCsv($scope.companies);
    };

    $scope.init();
});

