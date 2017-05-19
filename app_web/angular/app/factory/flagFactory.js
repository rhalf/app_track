/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Factory for flagFactory. 
                            Class for storing temporary objects.
*/
var app = angular.module('app');


app.factory('flagFactory', function (
    $q,
    $timeout,

    uiFactory,

    Status,
    Field,
    Privilege,
    Nation,
    SimVendor,
    UnitStatus,
    UnitType,
    Type,

    AppNote

    ) {
    var flagFactory = {};


    flagFactory.statuses = {};
    flagFactory.fields = {};
    flagFactory.privileges = {};
    flagFactory.nations = {};
    flagFactory.simVendors = {};
    flagFactory.unitStatuses = {};
    flagFactory.unitTypes = {};
    flagFactory.types = {};
    flagFactory.appNotes = {};




    flagFactory.load = function (type) {
        switch (type) {
            case 'statuses':
                flagFactory.statuses = Status.query();
                break;
            case 'fields':
                flagFactory.fields = Field.query();
                break;
            case 'privileges':
                flagFactory.privileges = Privilege.query();
                break;
            case 'nations':
                flagFactory.nations = Nation.query();
                break;
            case 'simVendors':
                flagFactory.simVendors = SimVendor.query();
                break;
            case 'unitStatuses':
                flagFactory.unitStatuses = UnitStatus.query();
                break;
            case 'unitTypes':
                flagFactory.unitTypes = UnitType.query();
                break;
            case 'types':
                flagFactory.types = Type.query();
                break;
            case 'appnotes':
                flagFactory.appNotes = AppNote.query();
                break;
        }
    };

    flagFactory.init = function (callback) {

        var promises = $q.all(
            [
                Status.query(),
                Field.query(),
                Privilege.query(),
                Nation.query(),
                SimVendor.query(),
                UnitStatus.query(),
                UnitType.query(),
                Type.query(),
                AppNote.query()
            ]
        );

        promises.then(
            function (result) {
                flagFactory.statuses = result[0];
                flagFactory.fields = result[1];
                flagFactory.privileges = result[2];
                flagFactory.nations = result[3];
                flagFactory.simVendors = result[4];
                flagFactory.unitStatuses = result[5];
                flagFactory.unitTypes = result[6];
                flagFactory.types = result[7];
                flagFactory.appNotes = result[8];

                if (callback) {
                    callback();
                }
            }, function (result) {
                var alert = { type: 'danger', message: "flagFactory failed, " + result};
                uiFactory.alert.show(alert);
            });
    };

    return flagFactory;
});