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
                company: '@company'
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
    return $resource('http://184.107.179.181/v1/main/user/:id/:type', { id: '@id', type: '@type' }, {
        'update': {
            method: 'PUT'
        },
        setCredential: {
            method: 'PUT'
        },
        getByCompany: {
            method: 'GET',
            params: {
                company: '@company'
            },
            isArray: true
        }
    });
});

app.factory('UserInfo', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/userinfo/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        },
        getByUser: {
            method: 'GET',
            params: {
                user: '@user'
            }
        }
    });
});
app.factory('Sim', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/sim/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        },
        getByCompany: {
            method: 'GET',
            params: {
                company: '@company'
            },
            isArray: true
        }
    });
});

app.factory('Unit', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/unit/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        },
        getByCompany: {
            method: 'GET',
            params: {
                company: '@company'
            },
            isArray: true
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

app.factory('UnitStatus', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/unitstatus/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        }
    });
});


app.factory('Driver', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/driver/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        },
        getByCompany: {
            method: 'GET',
            params: {
                company: '@company'
            },
            isArray: true
        }
    });
});

app.factory('Vehicle', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/vehicle/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        },
        getByCompany: {
            method: 'GET',
            params: {
                company: '@company'
            },
            isArray: true
        }
    });
});

app.factory('VehicleCollection', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/vehiclecollection/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        },
        getByCollection: {
            method: 'GET',
            params: {
                collection: '@collection'
            },
            isArray: true
        },
        deleteByCollection: {
            method: 'DELETE',
            params: {
                collection: '@collection'
            },
            isArray: false
        }
    });
});


app.factory('TrackeeType', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/trackeetype/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        }
    });
});

app.factory('Session', function ($resource) {
    return $resource('http://184.107.179.181/v1/session/login/', {}, {
        'login': {
            method: 'POST',
            data: {
                Name: '@Name',
                Password: '@Password'
            }
        }
    });
});

app.factory('Collection', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/collection/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        },
        getByCompany: {
            method: 'GET',
            params: {
                company: '@company'
            },
            isArray: true
        }
    });
});



//Data
app.factory('UnitData', function ($resource) {
    return $resource('http://184.107.179.181/v1/data/unitdata/:imei', { imei: '@imei' }, {
        'update': {
            method: 'PUT'
        }
    });
});

app.factory('Poi', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/poi/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        },
        getByCompany: {
            method: 'GET',
            params: {
                company: '@company'
            },
            isArray: true
        }
    });
});
app.factory('Geofence', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/geofence/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        },
        getByCompany: {
            method: 'GET',
            params: {
                company: '@company'
            },
            isArray: true
        }
    });
});
app.factory('Route', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/route/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        },
        getByCompany: {
            method: 'GET',
            params: {
                company: '@company'
            },
            isArray: true
        }
    });
});
app.factory('Area', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/area/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        },
        getByNation: {
            method: 'GET',
            params: {
                nation: '@nation'
            },
            isArray: true
        }
    });
});
//===============================================================================
//System
//===============================================================================
app.factory('AppNote', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/appnote/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        }
    });
});

app.factory('UserOnline', function ($resource) {
    return $resource('http://184.107.179.181/v1/main/useronline/:id', { id: '@id' }, {
        'update': {
            method: 'PUT'
        },
        getByTime: {
            method: 'GET',
            params: {
                time: '@time'
            },
            isArray: true
        }
    });
});
