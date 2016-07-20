var app = angular.module('app');


app.factory('systemFactory', function (


    ) {

    var systemFactory = {};
  
    systemFactory.appName = "Ats Gps Tracking";
    systemFactory.appVersion = "0.1";


    return systemFactory;
});