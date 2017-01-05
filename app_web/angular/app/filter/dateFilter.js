var app = angular.module('app');

app.filter('dateFilter', function ($filter) {
    return function (input, option) {
        var datetime = new Date(input);


        var dtUtc = new Date(
                  Date.UTC(
                      datetime.getFullYear(),
                      datetime.getMonth(),
                      datetime.getDate(),
                      datetime.getHours(),
                      datetime.getMinutes(),
                      datetime.getSeconds(),
                      datetime.getMilliseconds()
                  )
              );

        var date = new Date(dtUtc.toLocaleString());
        var formatted;

        switch (option) {
            case 'date':
                formatted = $filter('date')(date, 'yyyy-MM-dd');
                break;
            case 'time':
                formatted = $filter('date')(date, 'HH:mm:ss');
                break;
            case 'full':
                formatted = $filter('date')(date, 'yyyy-MM-dd HH:mm:ss');
            default:
                 formatted = $filter('date')(date, 'yyyy-MM-dd HH:mm:ss');
        }

        //console.log("input : " + input);
        //console.log("formatted : "+ formatted);
        return formatted;
    };
});