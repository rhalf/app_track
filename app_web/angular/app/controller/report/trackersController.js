var app = angular.module('app');


app.controller('trackersController', function (
    $scope,
    $timeout,
    $location,
    $filter,

    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,
    exportFactory,
    fleetFactory,
    leafletFactory,

    Report,


    param
    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getUser();
        $scope.ui = uiFactory;
        $scope.fleet = fleetFactory;

        $scope.report = {};
        $scope.report = param;


        $scope.report.datas = [];



        angular.forEach($scope.fleet.vehicles, function (vehicle1, index) {

            var parameter = {};
            parameter.dateFrom = param.dateFrom;
            parameter.dateTo = param.dateTo;
            parameter.vehicle = vehicle1;
            parameter.type = "areaing";

            Report.generate(parameter, function (result) {

                var newData = {};
                newData.vehicle = result.vehicle;
                newData.distance = result.totalDistance;
                newData.areas = ":";
                angular.forEach(result.areas, function (area, index1) {
                    newData.areas += $scope.getArea(area) + "-";
                });
                $scope.report.datas.push(newData);
            });
        });
    };

    $scope.getArea = function (id) {
        var areaName = "outside";
        if (id == null)
            return areaName;

        angular.forEach(leafletFactory.areas, function (area, index) {
            if (id == area.id) {
                areaName = area.name;
            }
        });
        return areaName;

    };
    //$scope.showReplay = function (data) {
    //    $scope.replay = {};
    //    $scope.replay.dateFrom = data.dtFrom;
    //    $scope.replay.dateTo = data.dtTo;
    //    $scope.replay.vehicle = param.vehicle;
    //    $scope.replay.type = "historical";

    //    $uibModal.open({
    //        animation: true,
    //        templateUrl: 'app/view/report/replay.html',
    //        controller: 'replayController',
    //        keyboard: true,
    //        size: 'lg',
    //        resolve: {
    //            param: $scope.replay
    //        }
    //    });
    //};

    $scope.download = function () {
        exportFactory.trackersToCsv($scope.report);
    };


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

