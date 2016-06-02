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
    CompanyInfo
    ) {

  

    //Form
    $scope.form = {};
    $scope.add = function () {
        Company.save($scope.company,
            //Success
            function (result) {
                $scope.companyInfo.Company = result.Id;

                CompanyInfo.save($scope.companyInfo,
                    //Success
                    function (result) {
                        var alert = { type: 'success', message: '1 company has been added successfully.' };
                        $scope.ui.alert.addItem(alert);
                        $scope.flag.load('companies');
                    },
                    //Failed
                    function (result) {
                        var alert = { type: 'danger', message: result.data.Message };
                        $scope.ui.alert.addItem(alert);
                    });
            },
            //Failed
            function (result) {
                var alert = { type: 'danger', message: result.data.Message };
                $scope.ui.alert.addItem(alert);
            }
        );
    };

    //Alert
    $scope.closeAlert = function (index) {
        $scope.ui.alert.closeItem(index);
    }


    $scope.init = function () {
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


        $scope.company = new Company();
        $scope.company.DtCreated = $filter('date')(new Date(), 'yyyy-MM-dd');
        $scope.companyInfo = new CompanyInfo();
    }

    $scope.cancel = function () {
        $uibModalInstance.close();
    };


    $scope.init();
});

