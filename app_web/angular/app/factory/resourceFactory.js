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
    return $resource('http://184.107.179.181/v1/main/user/:id/:type', { id: '@id', type: '@type'}, {
        'update': {
            method: 'PUT'
        },
        setCredential: {
            method: 'PUT'
        }
    });
});

app.factory('Info', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/info/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        }
    });
});
app.factory('Sim', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/sim/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        }
    });
});

app.factory('Unit', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/unit/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        }
    });
});

app.factory('UnitSim', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/unitsim/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        }
    });
});

app.factory('UnitType', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/unittype/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        }
    });
});