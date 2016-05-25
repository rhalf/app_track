var app = angular.module('app');


app.controller('userUpdateController', function (
    $q,
    $scope,
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

    user,
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
    };

    $scope.form.update = function () {

        var q1 = User.update(
                { id: $scope.User.Id },
                $scope.User,
                function (result) {
                    $timeout(parent.form.load, 500);
                });

        var q2 = UserSim.update(
                { id: $scope.UserSim.Id },
                $scope.UserSim,
                function (result) {
                    //Success
                },
                function (result) {
                    //Failed
                    var alert = { type: 'danger', message: result.data.Message };
                    $scope.alert.addItem(alert);
                });

        var q3 = UserInfo.update(
                { id: $scope.UserInfo.Id },
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
                q2,
                q3
            ]
         );

        promises.then(function () {
            var alert = { type: 'success', message: 'This user has been updated.' };
            $scope.alert.addItem(alert);
            $timeout(parent.form.load, 200);
        });
        $scope.form.toggle();
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
        $scope.User = user;
        $scope.UserInfo = UserInfo.getByUser({ user: user.Id });
        $scope.UserSim = UserSim.getByUser({ user: user.Id });

    }

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.form.init();
    $scope.form.load();
});

