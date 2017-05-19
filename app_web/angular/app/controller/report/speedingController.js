/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Directive for dateDirective. 
                            Used for showing generated reports from the server.
*/
var app = angular.module('app');


app.controller('speedingController', function (
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

    Report,


    param
    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getUser();
        $scope.ui = uiFactory;

        $scope.report = {};
        $scope.ui.isLoading = true;


        Report.generate(
            param,
            function (result) {
                $scope.report = result;

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


    $scope.showReplay = function (data) {
        $scope.replay = {};
        $scope.replay.dateFrom = data.dtFrom;
        $scope.replay.dateTo = data.dtTo;
        $scope.replay.vehicle = param.vehicle;
        $scope.replay.type = "historical";

        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/report/replay.html',
            controller: 'replayController',
            keyboard: true,
            size: 'lg',
            resolve: {
                param: $scope.replay
            }
        });
    };

    $scope.download = function () {
        exportFactory.reportToCsv('report', $scope.report);
    };


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

