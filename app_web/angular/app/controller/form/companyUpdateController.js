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

    $scope.dateTimePicker = uiFactory.dateTimePicker;
    $scope.dateTimePicker.isOpen = [
        false, //dateTimePicker1
        false  //dateTimePicker2
    ];
    $scope.dateTimePicker.toggle = function (index) {
        $scope.dateTimePicker.isOpen[index] = !$scope.dateTimePicker.isOpen[index];
    };

    $scope.form = {};
    $scope.form.toggle = function () {
        $scope.form.isDisabled = !$scope.form.isDisabled;
    }

    $scope.form.update = function () {
        $scope.form.isDisabled = !$scope.form.isDisabled;

        CompanyInfo.update(
            { id: $scope.CompanyInfo.Id },
            $scope.CompanyInfo,

            function (result) {
                //Success
                Company.update(
                    { id: $scope.Company.Id },
                    $scope.Company,
                function (result) {
                    //Success
                    $timeout(parent.form.load, 250);
                    $scope.cancel();
                },
                function (result) {
                    //Failed
                });
            },
            function (result) {
                //Failed
            }
        );
    }

    //Alert
    $scope.closeAlert = function (index) {
        $scope.alert.closeItem(index);
    }

    $scope.form.init = function () {
        $scope.form.isDisabled = true;
        $scope.Flag = flagFactory;
        $scope.AuthUser = authFactory.getAccessToken();

        uiFactory.alert.items = [];
        $scope.alert = uiFactory.alert;
    }


    $scope.form.load = function () {
        $scope.Company = company;
        $scope.CompanyInfo = CompanyInfo.getByCompany({
            company: $scope.Company.Id
        });
    }


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.form.init();
    $scope.form.load();
});

