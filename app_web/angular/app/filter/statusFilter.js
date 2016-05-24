var app = angular.module('app');

app.filter('statusFilter', function ($filter, flagFactory) {
    return function (value) {
        var result = "UNKNOWN";
        angular.forEach(flagFactory.Status, function (status) {

            //console.log("Value:");
            //console.log(value);
            //console.log("StatusValue:");
            //console.log(status.Value);

            if (status.Value === value) {
                result = status.Name;
            }
        });
        return result;
    }
});