var app = angular.module('app');


app.factory('panelLeftFactory', function () {
    var panelLeftFactory = {};


    panelLeftFactory.toggle = true;
    
    return panelLeftFactory;
});