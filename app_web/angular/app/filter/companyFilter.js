var app = angular.module('app');

app.filter('companyFilter', function ($filter, flagFactory) {
    return function (id, option) {
        var result = "UNKNOWN";

        angular.forEach(flagFactory.Company, function (company) {
            if (company.Id === id) {
                switch (option) {
                    case 'name':
                        result = company.Name;
                        break;
                    case 'desc':
                        result = company.Desc;
                        break;
                }

            }
        });
        return result;
    }
});