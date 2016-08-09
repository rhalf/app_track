var app = angular.module('app');


app.controller('ctCompanyUpdateController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,

    Company,
    CompanyInfo

    ) {

    $scope.toggle = function () {
        $scope.form.isDisabled = !$scope.form.isDisabled;
    }

    $scope.update = function () {
        $scope.ui.isLoading = true;

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
                    $scope.ui.isLoading = false;
                    $scope.toggle();
                },
                function (result) {
                    //Failed
                    var alert = { type: 'danger', message: result.data.Message };
                    $scope.ui.alert.addItem(alert);
                    $scope.ui.isLoading = false;
                });
            },
            function (result) {
                //Failed
                var alert = { type: 'danger', message: result.data.Message };
                $scope.ui.alert.addItem(alert);
                $scope.ui.isLoading = false;
            });
    }

    //Alert
    $scope.closeAlert = function (index) {
        $scope.ui.alert.closeItem(index);
    }

    $scope.init = function () {
        $scope.form = {};
        $scope.form.isDisabled = true;

        $scope.flag = flagFactory;

        $scope.authUser = authFactory.getUser();

        $scope.ui = uiFactory;

        $scope.ui.alert.items = [];

        $scope.company = $scope.authUser.Company;
        $scope.companyInfo = CompanyInfo.getByCompany({ company: $scope.authUser.Company.Id });
        $scope.companies = Company.query();


    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

