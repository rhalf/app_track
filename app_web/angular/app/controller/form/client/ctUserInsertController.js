var app = angular.module('app');


app.controller('ctUserInsertController', function (
    $q,
    $scope,
    $filter,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,
    validationFactory,


    User,
    UserInfo,
    Company,
    Sim,

    parent

    ) {

    //Form
    $scope.add = function () {

        if (validationFactory.isNullOrEmpty($scope.user.Name)) {
            var alert = { type: 'danger', message: 'Username is null or Empty...' };
            $scope.ui.alert.addItem(alert);
            return;
        }

        if (validationFactory.password.notMatch($scope.user.Password, $scope.user.Password1)) {
            var alert = { type: 'danger', message: 'Password don\'t match...' };
            $scope.ui.alert.addItem(alert);
            return;
        }

        if (validationFactory.password.isShort($scope.user.Password, $scope.user.Password1)) {
            var alert = { type: 'danger', message: 'Password is short...' };
            $scope.ui.alert.addItem(alert);
            return;
        }

        if ($scope.authUser.Privilege.Value > 3 && $scope.user.Privilege.Value < 4) {
            var alert = { type: 'danger', message: 'You dont have privilege to or set this account to SUPER, POWER or TECH account...' };
            $scope.ui.alert.addItem(alert);
            return;
        }

        $scope.ui.isLoading = true;


        User.save(
            $scope.user,
            function (user) {
                //Success
                var alert = { type: 'success', message: '1 user has been added successfully.' };
                $scope.ui.alert.addItem(alert);
                $scope.userInfo.User = user;
                UserInfo.save(
                    $scope.userInfo,
                    function (result) {
                        //Success
                        var alert = { type: 'success', message: '1 userinfo has been added successfully.' };
                        $scope.ui.alert.addItem(alert);
                        parent.load();
                        $scope.ui.isLoading = false;
                    },
                    function (result) {
                        //Failed
                        var alert = { type: 'danger', message: result.data.Message };
                        $scope.ui.alert.addItem(alert);
                        $scope.ui.isLoading = false;
                        return;
                    });
            },
            function (result) {
                //Failed
                var alert = { type: 'danger', message: result.data.Message };
                $scope.ui.alert.addItem(alert);
                $scope.ui.isLoading = false;
            });
    };


    //Alert
    $scope.closeAlert = function (index) {
        $scope.ui.alert.closeItem(index);
    }



    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getUser();
        $scope.ui = uiFactory;

        $scope.ui.dateTimePicker.isOpen = [
           false, //dateTimePicker1
           false  //dateTimePicker2
        ];

        $scope.ui.dateTimePicker.toggle = function (index) {
            $scope.ui.dateTimePicker.isOpen[index] = !$scope.ui.dateTimePicker.isOpen[index];
        };

        $scope.ui.alert.items = [];


        $scope.user = new User();
        $scope.userInfo = new UserInfo();

        $scope.user.DtExpired = $filter('date')(new Date(), 'yyyy-MM-dd');

        $scope.companies = Company.query();
        $scope.sims = Sim.getByCompany({company : $scope.authUser.Company.Id });
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

