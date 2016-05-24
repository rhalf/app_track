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

    //DateTime
    $scope.dateTimePicker = uiFactory.dateTimePicker;
    $scope.dateTimePicker.isOpen = [
        false, //dateTimePicker1
        false  //dateTimePicker2
    ];
    $scope.dateTimePicker.toggle = function (index) {
        $scope.dateTimePicker.isOpen[index] = !$scope.dateTimePicker.isOpen[index];
    };

    //Form
    $scope.form = {};
    $scope.form.save = function () {
        Company.save($scope.Company,
            //Success
            function (result) {

                console.log(result);

                $scope.CompanyInfo.Company = result.Id;

                CompanyInfo.save($scope.CompanyInfo,
                    //Success
                    function (result) {
                        $timeout(parent.form.load, 500);
                    },
                    //Failed
                    function (result) {
                        var alert = { type: 'danger', message: result.data.Message };
                        $scope.alert.addItem(alert);
                    });
            },
            //Failed
            function (result) {
                var alert = { type: 'danger', message: result.data.Message };
                $scope.alert.addItem(alert);
            }
        );
    };

    //Alert
    $scope.closeAlert = function (index) {
        $scope.alert.closeItem(index);
    }


    $scope.form.init = function () {
        $scope.Flag = flagFactory;
        $scope.AuthUser = authFactory.getAccessToken();

        $scope.Company = new Company();
        $scope.Company.DtCreated = $filter('date')(new Date(),'yyyy-MM-dd');
        $scope.CompanyInfo = new CompanyInfo();


        uiFactory.alert.items = [];
        $scope.alert = uiFactory.alert;
    }


    $scope.form.load = function () {
    }

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.form.init();
    $scope.form.load();
});

