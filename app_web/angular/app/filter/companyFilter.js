var app = angular.module('app');

app.filter('companyFilter', function (flagFactory) {
    function filter(id, option) {
        var result = "UNKNOWN";

        angular.forEach(flagFactory.Companies, function (company) {
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
    filter.$stateful = true;
    return filter;
});