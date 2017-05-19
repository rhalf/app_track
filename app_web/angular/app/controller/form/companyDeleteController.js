/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for companyDeleteController. 
                            Used for deleting company.
*/
var app = angular.module('app');


app.controller('companyDeleteController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,

    Company,
    CompanyInfo,

    company,
    parent

    ) {



    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.ui = uiFactory;
        $scope.auth = authFactory;

        $scope.company = company;
    }

    $scope.delete = function () {
        $scope.ui.isLoading = true;

        Company.delete({ id: $scope.company.id },
            function (result) {
                parent.load();
                $scope.cancel();
                $scope.ui.isLoading = false;
                var alert = { type: 'success', message: result.message };
                $scope.ui.alert.show(alert);
            },
            function (result) {
                $scope.ui.isLoading = false;
                var alert = { type: 'danger', message: result.data.message };
                $scope.ui.alert.show(alert);
            });
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

