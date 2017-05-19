/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for companyInsertController. 
                            Used for inserting company.
*/
var app = angular.module('app');


app.controller('companyInsertController', function (
    $scope,
    $filter,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,


    Company,
    CompanyInfo,

    parent
    ) {



    //Form
    $scope.form = {};
    $scope.add = function () {
        $scope.ui.isLoading = true;

        Company.save($scope.company,
            //Success
            function (result) {
                $scope.companyInfo.company = { 'id': result.id };

                CompanyInfo.save($scope.companyInfo,
                    //Success
                    function (result) {
                        $scope.ui.isLoading = false;

                        var alert = { type: 'success', message: result.message };
                        $scope.ui.alert.show(alert);
                        parent.load();
                    },
                    //Failed
                    function (result) {
                        $scope.ui.isLoading = false;

                        var alert = { type: 'danger', message: result.data.message };
                        $scope.ui.alert.show(alert);
                    });
            },
            //Failed
            function (result) {
                $scope.ui.isLoading = false;

                var alert = { type: 'danger', message: result.data.message };
                $scope.ui.alert.show(alert);
            }
        );
    };


    $scope.init = function () {
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


        $scope.company = new Company();
        $scope.company.dtCreated = $filter('date')(new Date(), 'yyyy-MM-dd');
        $scope.companyInfo = new CompanyInfo();
    }

    $scope.cancel = function () {
        $uibModalInstance.close();
    };


    $scope.init();
});

