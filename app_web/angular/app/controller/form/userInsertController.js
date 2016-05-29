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
    Info,
    Sim,

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

        if (validationFactory.isNullOrEmpty($scope.User.Name)) {
            var alert = { type: 'danger', message: 'Username is null or Empty...' };
            $scope.alert.addItem(alert);
            return;
        }

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



        var q1 = Sim.save(
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

        var q2 = Info.save(
                      $scope.Info,
                      function (result) {
                          //Success
                          //console.log(result);
                          $scope.User.Info = result.Id;
                      },
                      function (result) {
                          //Failed
                          var alert = { type: 'danger', message: result.data.Message };
                          $scope.alert.addItem(alert);
                          return;
                      });


        var promises = $q.all([q1,q2]);

        promises.then(function () {

            console.log($scope.User);

            User.save(
            $scope.User,
            function (result) {
                var alert = { type: 'success', message: '1 user has been added.' };
                $scope.alert.addItem(alert);
                $timeout(parent.form.load, 200);
            },
            function (result) {
                var alert = { type: 'danger', message: result.data.Message };
                $scope.alert.addItem(alert);
                return;
            });
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
        $scope.Info = new Info();
        $scope.Sim = new Sim();


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

