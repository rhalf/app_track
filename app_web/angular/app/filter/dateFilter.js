var app = angular.module('app');

app.filter('dateFilter', function ($filter) {
    return function (input, option) {
        var date = new Date(input);

        switch (option) {
            case 'date':
                var formatted = $filter('date')(date, 'yyyy-MM-dd');
                break;
            case 'time':
                var formatted = $filter('date')(date, 'HH:mm:ss');
                break;
            default:
                var formatted = $filter('date')(date, 'yyyy-MM-dd HH:mm:ss');
        }
    
        //console.log(input);
        //console.log(formatted);
        return formatted;
    };
});