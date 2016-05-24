var app = angular.module('app');


app.factory('Company', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/company/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        }
    });
});



app.factory('CompanyInfo', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/companyinfo/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        },
        getByCompany: {
            method: 'GET',
            params: {
                company : '@company'
            }
        }
    });
});

app.factory('Field', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/field/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        }
    });
});

app.factory('Status', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/status/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        }
    });
});

app.factory('Privilege', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/privilege/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        }
    });
});

app.factory('SimVendor', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/simvendor/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        }
    });
});

app.factory('Nation', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/nation/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        }
    });
});


app.factory('User', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/user/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        }
    });
});

app.factory('UserInfo', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/userinfo/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        }
    });
});
app.factory('UserSim', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/usersim/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        }
    });
});