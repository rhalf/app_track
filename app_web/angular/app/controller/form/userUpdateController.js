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
    Info,
    Sim,

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

        if (validationFactory.isNullOrEmpty($scope.User.Name)) {
            var alert = { type: 'danger', message: 'Username is null or Empty...' };
            $scope.alert.addItem(alert);
            return;
        }

        var q1 = Sim.update(
            { id: $scope.Sim.Id },
            $scope.Sim,
            function (result) {
                //Success
                $scope.User.Sim = result.Id;

            },
            function (result) {
                //Failed
                var alert = { type: 'danger', message: result.data.Message };
                $scope.alert.addItem(alert);
                return;
            });

        var q2 = Info.update(
            { id: $scope.Info.Id },
            $scope.Info,
            function (result) {
                //Success
                $scope.User.Info = result.Id;
            },
            function (result) {
                //Failed
                var alert = { type: 'danger', message: result.data.Message };
                $scope.alert.addItem(alert);
                return;
            });


        var promises = $q.all(
            [
                q1,
                q2
            ]
        );

        promises.then(function () {
            User.update(
            { id: $scope.User.Id },
            $scope.User,
            function (result) {
                var alert = { type: 'success', message: '1 user has been updated.' };
                $scope.alert.addItem(alert);
                $timeout(parent.form.load, 200);
                $scope.form.toggle();

            },
            function (result) {
                var alert = { type: 'danger', message: result.data.Message };
                $scope.alert.addItem(alert);
                return;
            });
        });
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
        console.log(user);
        $scope.User = user;
        $scope.Info = Info.get({ id: user.Info });
        $scope.Sim = Sim.get({ id: user.Sim });

    }

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.form.init();
    $scope.form.load();
});

