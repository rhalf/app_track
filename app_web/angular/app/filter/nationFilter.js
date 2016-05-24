var app = angular.module('app');

app.filter('nationFilter', function ($filter, flagFactory) {
    return function (id, option) {
        var result = "UNKNOWN";

        angular.forEach(flagFactory.Nation, function (nation) {
            if (nation.Id === id) {
                switch (option) {
                    case 'nameShort':
                        result = nation.NameShort;
                        break;
                    case 'nameLong':
                        result = nation.NameLong;
                        break;
                    case 'dialCode':
                        result = nation.DialCode;
                        break;
                }
            }
        });
        return result;
    }
});