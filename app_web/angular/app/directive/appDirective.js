var app = angular.module('app');

app.directive('panelMenu', function () {
    return {
        templateUrl: '/app/view/directive/panelMenu.html',
        controller: 'panelMenuController'
    }
});

app.directive('panelLeft', function () {
    return {
        templateUrl: '/app/view/directive/panelLeft.html',
        controller: 'panelLeftController'
    }
});

app.directive('panelCenter', function () {
    return {
        templateUrl: '/app/view/directive/panelCenter.html',
        controller: 'panelCenterController'
    }
});

app.directive('panelMap', function () {
    return {
        templateUrl: '/app/view/directive/panelMap.html',
        controller: 'panelMapController'
    }
});

app.directive('panelLoading', function () {
    return {
        templateUrl: '/app/view/directive/panelLoading.html',
        controller: 'panelLoadingController'
    }
});

app.directive('panelBottom', function () {
    return {
        templateUrl: '/app/view/directive/panelBottom.html',
        controller: 'panelBottomController'
    }
});