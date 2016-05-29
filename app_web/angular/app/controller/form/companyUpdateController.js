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

 
    $scope.toggle = function () {
        $scope.form.isDisabled = !$scope.form.isDisabled;
    }

    $scope.update = function () {
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
                    var alert = { type: 'success', message: '1 company has been updated successfully.' };
                    $scope.alert.addItem(alert);
                    parent.load();
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

    $scope.init = function () {
        $scope.form = {};
        $scope.form.isDisabled = true;

        $scope.Flag = flagFactory;
        $scope.AuthUser = authFactory.getAccessToken();

        uiFactory.alert.items = [];
        $scope.alert = uiFactory.alert;
    }


    $scope.load = function () {

        $scope.Company = company;
        $scope.CompanyInfo = CompanyInfo.getByCompany({
            company: $scope.Company.Id
        });
    }


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
    $scope.load();
});

