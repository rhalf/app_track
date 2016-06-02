var app = angular.module('app');

app.filter('fieldFilter', function (flagFactory) {
    return function (id, option) {
        var result = "UNKNOWN";

        
        angular.forEach(flagFactory.Fields, function (object) {
            if (object.Id === id) {
                switch (option) {
                    case 'name':
                        result = object.Name;
                        break;
                    case 'desc':
                        result = object.Desc;
                        break;
                    default:
                        result = object.Name;
                }
            }
        });
        return result;
    }
});