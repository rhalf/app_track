/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Factory for fleetFactory. 
                            Used for managing vehicles and collections.
*/
var app = angular.module('app');


app.factory('fleetFactory', function (
    $q,
    $timeout,

    Vehicle,
    Collection,
    VehicleCollection,
    Driver,
    Sim,
    Unit,

    authFactory

    ) {

    var fleetFactory = {};
    fleetFactory.vehicles = [];
    fleetFactory.collections = []


    fleetFactory.load = function (callback) {
        fleetFactory.loadVehicles(function () {
            fleetFactory.loadCollections(function () {
                if (typeof callback === "function")
                    callback();
            });
        });
    };
    fleetFactory.loadVehicles = function (callback) {
        Vehicle.getByCompany({ company: authFactory.getCompany().id },
             function (vehicles) {
                 fleetFactory.vehicles = vehicles;
                 if (typeof callback === "function")
                     callback();
             },
             function (result) {
                 var alert = { type: 'danger', message: result.data.message };
                 $scope.ui.alert.show(alert);
                 if (typeof callback === "function")
                     callback();
             });
    };
    fleetFactory.loadCollections = function (callback) {
        var requests = [];
        Collection.getByCompany(
              { company: authFactory.getCompany().id },
              function (result) {
                  fleetFactory.collections = result;

                  angular.forEach(fleetFactory.collections, function (collection, index) {
                      var promise = VehicleCollection.getByCollection(
                          { collection: collection.id },
                          function (vehiclesIds) {
                              collection.vehiclesIds = vehiclesIds;
                          });
                      requests.push(promise);
                  });
                  var promises = $q.all(requests);
                  promises.then(function (resultA) {
                      //Success 
                  });
                  if (typeof callback === "function")
                      callback();
              },
              function (result) {
                  var alert = { type: 'danger', message: result.data.message };
                  $scope.ui.alert.show(alert);

                  if (typeof callback === "function")
                      callback();
              });
    };

    fleetFactory.update = function (collection, callback) {
        var requests = [];

        VehicleCollection.deleteByCollection(
            { collection: collection.id },
            function (result) {
                angular.forEach(fleetFactory.vehicles, function (vehicle, index) {
                    if (vehicle.checked) {
                        var object = new VehicleCollection();
                        object.vehicleId = vehicle.id;
                        object.collectionId = collection.id;

                        var promise = VehicleCollection.save(object);

                        requests.push(promise);
                    }
                });

                //Success
                var promises = $q.all(requests);
                promises.then(function (newResult) {
                    fleetFactory.load(function () {
                        $timeout(function () {
                            if (typeof callback === "function")
                                callback(result);
                        }, 1000);
                    });
                });
            },
            function (result) {
                //Failed
                callback(result);
            });
    };

    //fleetFactory.byCollection = function (vehicle, collection) {
    //    var value = null;
    //    if (collection == null || vehicle == null) { return null; };
    //    angular.forEach(collection.vehiclesIds, function (item, index) {
    //        if (vehicle.id == item.vehicleId && collection.id === item.collectionId) {
    //            value = vehicle;
    //        }
    //    });

    //    return value;
    //};

    fleetFactory.getVehiclesByCollection = function (collection) {
        var array = [];
        angular.forEach(collection.vehiclesIds, function (vc, index) {
            angular.forEach(fleetFactory.vehicles, function (vehicle, index) {
                if (vc.vehicleId == vehicle.id) {
                    array.push(vehicle);
                }
            });
        });
        //console.log(array)
        return array;
    };

    return fleetFactory;
});