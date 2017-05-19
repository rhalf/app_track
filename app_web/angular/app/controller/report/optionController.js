var app = angular.module('app');


app.controller('optionController', function (
    $scope,
    $timeout,
    $location,
    $filter,
    $uibModal,
    $uibModalInstance,


    $window,

    authFactory,
    flagFactory,
    uiFactory,

    Command,

    vehicle



    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getUser();
        $scope.ui = uiFactory;

        $scope.ui.dateTimePicker.isOpen = [
            false, //dateTimePicker1
            false //dateTimePicker2
        ];

        $scope.ui.dateTimePicker.toggle = function (index) {
            $scope.ui.dateTimePicker.isOpen[index] = true;
        };
        //report
        $scope.vehicle = vehicle;
        $scope.report = {};
        $scope.report.vehicle = vehicle;
        $scope.report.type = "running";
        $scope.report.range = "24";
        $scope.report.dateFrom = null;
        $scope.report.dateTo = null;

        $scope.dtReport = {};
        $scope.dtReport.from = new Date();
        $scope.dtReport.from.setHours(0, 0, 0, 0);
        $scope.dtReport.to = new Date($scope.dtReport.from.getTime() + 3600 * 1000 * 24);
        $scope.dtReport.to.setHours(0, 0, 0, 0);
        //replay
        $scope.replay = {};
        $scope.replay.vehicle = vehicle;
        $scope.replay.type = "historical";
        $scope.replay.dateFrom = null;
        $scope.replay.dateTo = null;
        $scope.dtReplay = {};
        $scope.dtReplay.from = new Date();
        $scope.dtReplay.from.setHours(0, 0, 0, 0);
        $scope.dtReplay.to = new Date($scope.dtReplay.from.getTime() + 3600 * 1000 * 24);
        $scope.dtReplay.to.setHours(0, 0, 0, 0);
        //command
        $scope.command = {};
        $scope.command.type = "vehicle_locate";
        $scope.command.param = "";

    };

    $scope.showReport = function () {

        if ($scope.dtReport.to.getYear() - $scope.dtReport.from.getYear() >= 0) {
            if ($scope.dtReport.to.getMonth() - $scope.dtReport.from.getMonth() > 1) {
                var alert = { type: 'danger', message: "Maximum range is 1 month." };
                $scope.ui.alert.show(alert);
                return;
            } else if ($scope.dtReport.to.getMonth() - $scope.dtReport.from.getMonth() < 0) {
                var alert = { type: 'danger', message: "DateTimeFrom is greater than DatetimeTo." };
                $scope.ui.alert.show(alert);
                return;
            }
        } else {
            var alert = { type: 'danger', message: "DateTimeFrom is greater than DatetimeTo." };
            $scope.ui.alert.show(alert);
            return;
        }
        $scope.report.dateFrom = $filter('date')($scope.dtReport.from, 'yyyy-MM-dd HH:mm:ss', 'UTC');
        $scope.report.dateTo = $filter('date')($scope.dtReport.to, 'yyyy-MM-dd HH:mm:ss', 'UTC');

        switch ($scope.report.type) {
            case 'running':
                $uibModal.open({
                    animation: true,
                    templateUrl: 'app/view/report/running.html',
                    controller: 'runningController',
                    keyboard: true,
                    size: 'xl',
                    windowClass: 'xl',
                    resolve: {
                        param: $scope.report
                    }
                });
                break;
            case 'idling':
                $uibModal.open({
                    animation: true,
                    templateUrl: 'app/view/report/idling.html',
                    controller: 'idlingController',
                    keyboard: true,
                    size: 'xl',
                    windowClass: 'xl',
                    resolve: {
                        param: $scope.report
                    }
                });
                break;
            case 'geofencing':
                $uibModal.open({
                    animation: true,
                    templateUrl: 'app/view/report/geofencing.html',
                    controller: 'geofencingController',
                    keyboard: true,
                    size: 'xl',
                    windowClass: 'xl',
                    resolve: {
                        param: $scope.report
                    }
                });
                break;
            case 'ignition':
                $uibModal.open({
                    animation: true,
                    templateUrl: 'app/view/report/ignition.html',
                    controller: 'ignitionController',
                    keyboard: true,
                    size: 'xl',
                    windowClass: 'xl',
                    resolve: {
                        param: $scope.report
                    }
                });
                break;
            case 'speeding':
                $uibModal.open({
                    animation: true,
                    templateUrl: 'app/view/report/speeding.html',
                    controller: 'speedingController',
                    keyboard: true,
                    size: 'xl',
                    windowClass: 'xl',
                    resolve: {
                        param: $scope.report
                    }
                });
                break;
            case 'powercutting':
                $uibModal.open({
                    animation: true,
                    templateUrl: 'app/view/report/powercutting.html',
                    controller: 'powercuttingController',
                    keyboard: true,
                    windowClass: 'xl',
                    size: 'xl',
                    resolve: {
                        param: $scope.report
                    }
                });
                break;
            case 'trackers':
                $uibModal.open({
                    animation: true,
                    templateUrl: 'app/view/report/trackers.html',
                    controller: 'trackersController',
                    keyboard: true,
                    windowClass: 'xl',
                    size: 'xl',
                    resolve: {
                        param: $scope.report
                    }
                });
                break;
        }
    };
    $scope.showReplay = function () {
        $scope.replay.dateFrom = $filter('date')($scope.dtReplay.from, 'yyyy-MM-dd HH:mm:ss', 'UTC');
        $scope.replay.dateTo = $filter('date')($scope.dtReplay.to, 'yyyy-MM-dd HH:mm:ss', 'UTC');

        //$scope.replay.dateFrom = $filter('date')($scope.dtReplay.from, 'yyyy-MM-dd HH:mm:ss', 'UTC');
        //var day = 24 * 60 * 60 * 1000 * 30;
        //var timeStamp = $scope.dtReplay.from.getTime() + day;
        //var newDate = new Date(timeStamp);
        //$scope.replay.dateTo = $filter('date')(newDate, 'yyyy-MM-dd HH:mm:ss', 'UTC');

        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/report/replay.html',
            controller: 'replayController',
            keyboard: true,
            windowClass: 'xl',
            size: 'xl',
            resolve: {
                param: $scope.replay
            }
        });
    };

    $scope.sendCommand = function () {

        $scope.ui.isLoading = true;

        $scope.command.vehicle = vehicle;

        //console.log(JSON.stringify($scope.command));

        Command.prepare(
            $scope.command,
            function (result) {
                $scope.ui.isLoading = false;

                var alert = { type: 'success', message: result.message };
                $scope.ui.alert.show(alert);
            },
            function (result) {
                $scope.ui.isLoading = false;

                var alert = { type: 'danger', message: result.data.message };
                $scope.ui.alert.show(alert);
            });
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

