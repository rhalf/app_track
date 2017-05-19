/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for userInsertController. 
                            Used for inserting user.
*/
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
    Company,
    Sim,

    parent

    ) {

    //Form
    $scope.add = function () {

        if ($scope.valid.isNullOrEmpty($scope.user.name)) {
            var alert = { type: 'danger', message: 'Username is null or Empty...' };
            $scope.ui.alert.show(alert);
            return;
        }

        if ($scope.valid.password.notMatch($scope.user.password, $scope.user.password1)) {
            var alert = { type: 'danger', message: 'Password don\'t match...' };
            $scope.ui.alert.show(alert);
            return;
        }

        if ($scope.valid.password.isShort($scope.user.password, $scope.user.password1)) {
            var alert = { type: 'danger', message: 'Password is short...' };
            $scope.ui.alert.show(alert);
            return;
        }


        if ($scope.auth.getUser().privilege.value > $scope.user.privilege.value) {
            var alert = { type: 'danger', message: 'Cant create user with privilege higher than your privilege.' };
            $scope.ui.alert.show(alert);
            return;
        }

        $scope.ui.isLoading = true;


        User.save(
            $scope.user,
            function (result) {
                //Success
                var alert = { type: 'success', message: result.message };
                $scope.ui.alert.show(alert);
                $scope.userInfo.user = { 'id': result.id };
                UserInfo.save(
                    $scope.userInfo,
                    function (result) {
                        //Success
                        parent.load();
                        $scope.ui.isLoading = false;
                        var alert = { type: 'success', message: result.message };
                        $scope.ui.alert.show(alert);

                    },
                    function (result) {
                        //Failed
                        $scope.ui.isLoading = false;
                        var alert = { type: 'danger', message: result.data.message };
                        $scope.ui.alert.show(alert);
                        return;
                    });
            },
            function (result) {
                //Failed
                $scope.ui.isLoading = false;
                var alert = { type: 'danger', message: result.data.message };
                $scope.ui.alert.show(alert);
            });
    };

    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.auth = authFactory;
        $scope.valid = validationFactory;
        $scope.ui = uiFactory;

        $scope.ui.dateTimePicker.isOpen = [
           false, //dateTimePicker1
           false  //dateTimePicker2
        ];

        $scope.ui.dateTimePicker.toggle = function (index) {
            $scope.ui.dateTimePicker.isOpen[index] = !$scope.ui.dateTimePicker.isOpen[index];
        };


        $scope.user = new User();
        $scope.user.company = $scope.auth.getCompany();
        $scope.userInfo = new UserInfo();
        $scope.sims = Sim.getByCompany({ company: $scope.auth.getCompany().id });


        $scope.user.dtExpired = $filter('date')(new Date(), 'yyyy-MM-dd');

    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

