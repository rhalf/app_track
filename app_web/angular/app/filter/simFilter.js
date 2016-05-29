var app = angular.module('app');

app.filter('simFilter', function ($filter, flagFactory) {
    return function (id, option) {
        var result = "UNKNOWN";

        angular.forEach(flagFactory.Sim, function (object) {
            if (object.Id === id) {
                switch (option) {
                    case 'number':
                        result = object.Number;
                        break;
                    case 'imei':
                        result = object.Imei;
                        break;
                    case 'simVendor':
                        result = object.SimVendor;
                        break;
                    default:
                        result = object.Number;
                }
            }
        });
        return result;
    }
});