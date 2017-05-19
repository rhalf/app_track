/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for companyUpdateController. 
                            Used for updating company.
*/
var app = angular.module('app');


app.controller('companyUpdateController', function (
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

    $scope.toggle = function () {
        $scope.form.isDisabled = !$scope.form.isDisabled;
    };

    $scope.update = function () {

        $scope.ui.isLoading = true;

        CompanyInfo.update(
            { id: $scope.companyInfo.id },
            $scope.companyInfo,

            function (result) {
                //Success
                Company.update(
                    { id: $scope.company.id },
                    $scope.company,
                function (result) {
                    //Success
                    parent.load();
                    $scope.toggle();

                    $scope.ui.isLoading = false;

                    var alert = { type: 'danger', message: result.message };
                    $scope.ui.alert.show(alert);

                },
                function (result) {
                    //Failed
                    $scope.ui.isLoading = false;

                    var alert = { type: 'danger', message: result.data.message };
                    $scope.ui.alert.show(alert);
                });
            },
            function (result) {
                //Failed
                $scope.ui.isLoading = false;

                var alert = { type: 'danger', message: result.data.message };
                $scope.ui.alert.show(alert);

            }
        );
    };

    $scope.init = function () {
        $scope.form = {};
        $scope.form.isDisabled = true;

        $scope.flag = flagFactory;

        $scope.auth = authFactory;

        $scope.ui = uiFactory;
        $scope.ui.dateTimePicker.isOpen = [
            false, //dateTimePicker1
            false  //dateTimePicker2
        ];
        $scope.ui.dateTimePicker.toggle = function (index) {
            $scope.ui.dateTimePicker.isOpen[index] = !$scope.ui.dateTimePicker.isOpen[index];
        };

        $scope.company = company;
        $scope.companyInfo = CompanyInfo.getByCompany({
            company: $scope.company.id
        });
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

