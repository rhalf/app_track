/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Factory for systemFactory. 
                            Used for managing systemInfo.
*/
var app = angular.module('app');


app.factory('systemFactory', function (


    ) {

    var systemFactory = {};
    systemFactory.app = {};
    systemFactory.app.name = "Gaia Watcher";
    systemFactory.app.version = "0.1";

    systemFactory.app.company = {};
    systemFactory.app.company.name = "Advanced Technologies and Solutions";
    systemFactory.app.company.address = "Office #10 (2nd Floor) Darwish Bldg. Salwa Road, Abu hamour, Qatar";
    systemFactory.app.company.mobile = "Office #10 (2nd Floor) Darwish Bldg. Salwa Road, Abu hamour, Qatar";
    systemFactory.app.company.email = "info@ats-qatar.com";
    systemFactory.app.company.mobile = "(974)30599362";
    systemFactory.app.company.telephone = "(974)44876611";





    return systemFactory;
});