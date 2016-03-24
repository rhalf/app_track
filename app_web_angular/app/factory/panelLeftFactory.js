var app = angular.module('app');


app.factory('panelLeftFactory', function () {
    var panelLeft = {};

    panelLeft.toggle = true;
    
    return panelLeft;
});