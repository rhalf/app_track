var app = angular.module('app');

app.filter('privilegeFilter', function ($filter, flagFactory) {
    return function (value) {
        var result = "UNKNOWN";
        angular.forEach(flagFactory.Privilege, function (privilege) {
            if (privilege.Value === value) {
                result = privilege.Name;
            }
        });
        return result;
    }
});