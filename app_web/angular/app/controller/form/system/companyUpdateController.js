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

    company
    ) {

    $scope.toggle = function () {
        $scope.form.isDisabled = !$scope.form.isDisabled;
    };

    $scope.update = function () {
        $scope.toggle();

        CompanyInfo.update(
            { id: $scope.companyInfo.Id },
            $scope.companyInfo,

            function (result) {
                //Success
                Company.update(
                    { id: $scope.company.Id },
                    $scope.company,
                function (result) {
                    //Success
                    var alert = { type: 'success', message: '1 company has been updated successfully.' };
                    $scope.ui.alert.addItem(alert);
                    $scope.flag.load('companies');
                },
                function (result) {
                    //Failed
                });
            },
            function (result) {
                //Failed
            }
        );
    };

    //Alert
    $scope.closeAlert = function (index) {
        $scope.ui.alert.closeItem(index);
    };

    $scope.init = function () {
        $scope.form = {};
        $scope.form.isDisabled = true;

        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getAccessToken();

        $scope.ui = uiFactory;
        $scope.ui.dateTimePicker.isOpen = [
            false, //dateTimePicker1
            false  //dateTimePicker2
        ];
        $scope.ui.dateTimePicker.toggle = function (index) {
            $scope.ui.dateTimePicker.isOpen[index] = !$scope.ui.dateTimePicker.isOpen[index];
        };

        $scope.ui.alert.items = [];

        $scope.company = company;
        $scope.companyInfo = CompanyInfo.getByCompany({
            company: $scope.company.Id
        });
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

