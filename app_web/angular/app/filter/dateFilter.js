var app = angular.module('app');

app.filter('dateFilter', function ($filter) {
    return function (input) {
        var date = new Date(input);
        var formatted = $filter('date')(date, 'yyyy-MM-dd');
        //console.log(input);
        //console.log(formatted);
        return formatted;
    };
});