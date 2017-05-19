/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Factory for exportFactory. 
                            Class for exporting text to csv.
*/
var app = angular.module('app');

app.factory('exportFactory', function () {

    var exportFactory = {};

    exportFactory.stringToCsv = function (name, data) {
        var report = $('<a/>', {
            style: 'display:none',
            href: 'data:application/octet-stream;base64,' + btoa(data),
            download: name
        }).appendTo('body');
        report[0].click();
        report.remove();
    }

    exportFactory.reportToCsv = function (elementId, report) {
        var table = document.getElementById(elementId);

        var csvString = "";
        csvString += "name," + report.vehicle.name + "\n";
        csvString += "imei,'" + report.vehicle.unit.imei + "\n";
        csvString += "dateTimeFrom," + report.dateFrom + "\n";
        csvString += "dateTimeTo," + report.dateTo + "\n";
        csvString += "Distance," + report.totalDistance + "\n";
        csvString += "Time," + report.totalTime + "\n";
        csvString += "Fuel," + report.totalFuel + "\n";
        csvString += "\n\n";



        for (var i = 0; i < table.rows.length; i++) {
            var rowData = table.rows[i].cells;
            for (var j = 0; j < rowData.length; j++) {
                csvString = csvString + rowData[j].innerHTML + ",";
            }
            csvString = csvString.substring(0, csvString.length - 1);
            csvString = csvString + "\n";
        }
        csvString = csvString.substring(0, csvString.length - 1);

        exportFactory.stringToCsv(report.vehicle.name + "_" + report.type + ".csv", csvString);
    };
    exportFactory.historicalToCsv = function (report) {
        var csvString = "";

        csvString += 
            "id,hServer,hClient,hCommand,hEvent,hLength," +
            "gLatitude,gLongitude,gAltitude,gCourse,gSatellite,gStatus,gAccuracy,"+
            "cSignal,cStatus," +
            "iSpeed,iRuntime,iOdo,iAcc,iSos,iEpc,iBatt,iVcc,iRelay," +
            "iAcce,iDecel,iRpm,iFuel,iButton,iAlarm,iMode,iPic,iWeight" +
            "\n";

        angular.forEach(report.datas, function (data, index) {
            csvString += data.id + ",";
            csvString += data.header.dtServer + ",";
            csvString += data.header.dtClient + ",";
            csvString += data.header.command + ",";
            csvString += data.header.event + ",";
            csvString += data.header.length + ",";

            csvString += data.gps.coordinate.latitude + ",";
            csvString += data.gps.coordinate.longitude + ",";
            csvString += data.gps.coordinate.altitude + ",";
            csvString += data.gps.coordinate.course + ",";
            csvString += data.gps.satellite + ",";
            csvString += data.gps.status + ",";
            csvString += data.gps.accuracy + ",";

            csvString += data.gprs.signal + ",";
            csvString += data.gprs.signal + ",";

            csvString += data.io.speed + ",";
            csvString += data.io.runtime + ",";
            csvString += data.io.odo + ",";
            csvString += data.io.acc + ",";
            csvString += data.io.sos + ",";
            csvString += data.io.epc + ",";
            csvString += data.io.batt + ",";
            csvString += data.io.vcc + ",";
            csvString += data.io.relay4 + data.io.relay3 + data.io.relay2 + data.io.relay1 + ",";

            csvString += data.io.accel + ",";
            csvString += data.io.decel + ",";
            csvString += data.io.rpm + ",";
            csvString += data.io.fuel + ",";
            csvString += data.io.iButton + ",";
            csvString += data.io.alarm + ",";
            csvString += data.io.mode + ",";
            csvString += data.io.pic + ",";
            csvString += data.io.weight;

            csvString += "\n";
        });

        exportFactory.stringToCsv(report.vehicle.name + "_" + report.type + ".csv", csvString);
    };
    exportFactory.trackersToCsv = function (report) {
        var csvString = "";

        csvString +=
            "vehicle_name,vehicle_plate,distance,areas" +
            "\n";

        angular.forEach(report.datas, function (data, index) {
            csvString += data.vehicle.name + ",";
            csvString += data.vehicle.plate + ",";
            csvString += data.distance + ",";
            csvString += data.areas;

            csvString += "\n";
        });

        exportFactory.stringToCsv(report.vehicle.name + "_" + report.type + ".csv", csvString);
    };
    exportFactory.usersToCsv = function (users, company) {

        var csvString = "";

        csvString += "id,dtCreated,dtExpired,name,privilege,status\n\n";

        angular.forEach(users, function (user, index) {
            csvString += user.id + ",";
            csvString += user.dtCreated + ",";
            csvString += user.dtExpired + ",";
            csvString += user.name + ",";
            csvString += user.privilege.name + ",";
            csvString += user.status.name + "\n";
        });

        csvString = csvString.substring(0, csvString.length - 1);

        var now = new Date();
        var full =
            now.getYear().toString() +
            now.getMonth().toString() +
            now.getDay().toString() +
            now.getHours().toString() +
            now.getMinutes().toString() +
            now.getSeconds().toString();

        exportFactory.stringToCsv(company.name + "_users_" + full + ".csv", csvString);
    };
    exportFactory.vehiclesToCsv = function (vehicles, company) {

        var csvString = "";

        csvString += "#,id,dtCreated,dtExpired,name,plate,model,type,maInitial,maLimit,maMaintenace,speedMax,fuelMax,status,";
        csvString += "driverName,";
        csvString += "unitImei,";
        csvString += "simNumber\n";

        angular.forEach(vehicles, function (vehicle, index) {
            index++;
            csvString += index.toString() + ",";
            csvString += vehicle.id + ",";
            csvString += vehicle.dtCreated + ",";
            csvString += vehicle.dtExpired + ",";
            csvString += vehicle.name + ",";
            csvString += vehicle.plate + ",";
            csvString += vehicle.model + ",";

            if (vehicle.type)
                csvString += vehicle.type.name + ",";
            else {
                csvString += ",";
            }

            csvString += vehicle.maInitial + ",";
            csvString += vehicle.maLimit + ",";
            csvString += vehicle.maMaintenance + ",";
            csvString += vehicle.speedMax + ",";
            csvString += vehicle.fuelMax + ",";

            if (vehicle.status)
                csvString += vehicle.status.name + ",";
            else {
                csvString += ",";
            }
            if (vehicle.driver) {
                var name = vehicle.driver.name.replace(",", "|")
                csvString += name + ",";
            } else {
                csvString += ",";
            }
            if (vehicle.unit)
                csvString += vehicle.unit.imei + ",";
            else {
                csvString += ",";
            }
            if (vehicle.unit.sim)
                csvString += vehicle.unit.sim.number + "\n";
            else {
                csvString += "\n";
            }
        });

        csvString = csvString.substring(0, csvString.length - 1);

        var now = new Date();
        var full =
            now.getYear().toString() +
            now.getMonth().toString() +
            now.getDay().toString() +
            now.getHours().toString() +
            now.getMinutes().toString() +
            now.getSeconds().toString();

        exportFactory.stringToCsv(company.name + "_vehicles_" + full + ".csv", csvString);
    };
    exportFactory.unitsToCsv = function (units, company) {

        var csvString = "";

        csvString += "#,id,dtCreated,dtSubscribed,dtExpired,imei,serial,unitType,unitStatus,sim\n";

        angular.forEach(units, function (unit, index) {
            index++;
            csvString += index.toString() + ",";
            csvString += unit.id + ",";
            csvString += unit.dtCreated + ",";
            csvString += unit.dtSubscribed + ",";
            csvString += unit.dtExpired + ",";
            csvString += unit.imei + ",";
            csvString += unit.serial + ",";

            if (unit.unitType)
                csvString += unit.unitType.name + ",";
            else {
                csvString += ",";
            }
            if (unit.unitStatus)
                csvString += unit.unitStatus.name + ",";
            else {
                csvString += ",";
            }
            if (unit.sim)
                csvString += unit.sim.number+ "\n";
            else {
                csvString += "\n";
            }
           
        });

        csvString = csvString.substring(0, csvString.length - 1);

        var now = new Date();
        var full =
            now.getYear().toString() +
            now.getMonth().toString() +
            now.getDay().toString() +
            now.getHours().toString() +
            now.getMinutes().toString() +
            now.getSeconds().toString();

        exportFactory.stringToCsv(company.name + "_units_" + full + ".csv", csvString);
    };
    exportFactory.simsToCsv = function (sims, company) {

        var csvString = "";

        csvString += "#,id,dtCreated,imei,number,roaming,simVendor,status\n";

        angular.forEach(sims, function (sim, index) {
            index++;
            csvString += index.toString() + ",";
            csvString += sim.id + ",";
            csvString += sim.dtCreated + ",";
            csvString += sim.imei + ",";
            csvString += sim.number + ",";
            csvString += sim.roaming + ",";

            if (sim.simVendor)
                csvString += sim.simVendor.name + ",";
            else {
                csvString += ",";
            }
            if (sim.status)
                csvString += sim.status.name + "\n";
            else {
                csvString += "\n";
            }
        });

        csvString = csvString.substring(0, csvString.length - 1);

        var now = new Date();
        var full =
            now.getYear().toString() +
            now.getMonth().toString() +
            now.getDay().toString() +
            now.getHours().toString() +
            now.getMinutes().toString() +
            now.getSeconds().toString();

        exportFactory.stringToCsv(company.name + "_sims_" + full + ".csv", csvString);
    };
    exportFactory.driversToCsv = function (drivers, company) {

        var csvString = "";

        csvString += "#,id,dtCreated,driverId,name,rfid,status\n";

        angular.forEach(drivers, function (driver, index) {
            index++;
            csvString += index.toString() + ",";
            csvString += driver.id + ",";
            csvString += driver.dtCreated + ",";
            csvString += driver.driverId + ",";
            csvString += driver.name + ",";
            csvString += driver.rfid + ",";

            if (driver.status)
                csvString += driver.status.name + "\n";
            else {
                csvString += "\n";
            }
        });

        csvString = csvString.substring(0, csvString.length - 1);

        var now = new Date();
        var full =
            now.getYear().toString() +
            now.getMonth().toString() +
            now.getDay().toString() +
            now.getHours().toString() +
            now.getMinutes().toString() +
            now.getSeconds().toString();

        exportFactory.stringToCsv(company.name + "_drivers_" + full + ".csv", csvString);
    };
    exportFactory.collectionsToCsv = function (collections, company) {

        var csvString = "";

        csvString += "#,id,name,desc,user\n";

        angular.forEach(collections, function (collection, index) {
            index++;
            csvString += index.toString() + ",";
            csvString += collection.id + ",";
            csvString += collection.name + ",";
            csvString += collection.desc + ",";

            if (collection.user)
                csvString += collection.user.name + "\n";
            else {
                csvString += "\n";
            }
        });

        csvString = csvString.substring(0, csvString.length - 1);

        var now = new Date();
        var full =
            now.getYear().toString() +
            now.getMonth().toString() +
            now.getDay().toString() +
            now.getHours().toString() +
            now.getMinutes().toString() +
            now.getSeconds().toString();

        exportFactory.stringToCsv(company.name + "_collections_" + full + ".csv", csvString);
    };

    return exportFactory;
});