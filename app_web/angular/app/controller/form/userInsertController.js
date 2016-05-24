var app = angular.module('app');


app.controller('userInsertController', function (
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
    UserSim,

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

        if (validationFactory.password.notMatch($scope.User.Password, $scope.User.Password1)) {
            var alert = { type: 'danger', message: 'Password don\'t match...' };
            $scope.alert.addItem(alert);
            return;
        }

        if (validationFactory.password.isShort($scope.User.Password, $scope.User.Password1)) {
            var alert = { type: 'danger', message: 'Password is short...' };
            $scope.alert.addItem(alert);
            return;
        }

        User.save(
            $scope.User,
            function (result) {
                //Success
                $scope.UserInfo.User = result.Id;
                $scope.UserSim.User = result.Id;

                var q1 = UserSim.save(
                    $scope.UserSim,
                    function (result) {
                        //Success
                    },
                    function (result) {
                        //Failed
                        var alert = { type: 'danger', message: result.data.Message };
                        $scope.alert.addItem(alert);
                    });
                  
                  
               var q2 = UserInfo.save(
                    $scope.UserInfo,
                    function (result) {
                        //Success
                    },
                    function (result) {
                        //Failed
                        var alert = { type: 'danger', message: result.data.Message };
                        $scope.alert.addItem(alert);
                    });
                   
               
               var promises = $q.all(
                   [
                       q1,
                       q2
                   ]
                );

               promises.then(function () {
                   var alert = { type: 'success', message: '1 user has been added.' };
                   $scope.alert.addItem(alert);
                   $timeout(parent.form.load,200);
               });

            },
            function (result) {
                //Failed
                var alert = { type: 'danger', message: result.data.Message };
                $scope.alert.addItem(alert);
            });
    };

    //Alert
    $scope.closeAlert = function (index) {
        $scope.alert.closeItem(index);
    }



    $scope.form.init = function () {
        $scope.Flag = flagFactory;
        $scope.AuthUser = authFactory.getAccessToken();

        $scope.User = new User();
        $scope.UserInfo = new UserInfo();
        $scope.UserSim = new UserSim();


        $scope.User.DtCreated = $filter('date')(new Date(), 'yyyy-MM-dd');
        $scope.User.DtExpired = $filter('date')(new Date(), 'yyyy-MM-dd');

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

