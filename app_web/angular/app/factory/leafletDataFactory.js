var app = angular.module('app');


app.factory('leafletDataFactory', function () {


    var leafletDataFactory = {};

    leafletDataFactory.mapLayer = {};
    leafletDataFactory.mapLayer.openCycle = "http://{s}.tile.thunderforest.com/cycle/{z}/{x}/{y}.png";
    leafletDataFactory.mapLayer.openStreet = "http://{s}.tile.osm.org/{z}/{x}/{y}.png";

    leafletDataFactory.icons = {};
    leafletDataFactory.icons.vehicles = [
        "img/marker/marker_triangle_50_blue.png",
        "img/marker/marker_triangle_50_red.png",
        "img/marker/marker_triangle_50_yellow.png",
        "img/marker/marker_triangle_50_orange.png",
        "img/marker/marker_triangle_50_gray.png"
    ];
    leafletDataFactory.icons.pois = [
      "img/pois/poi_pin_blue.png",
      "img/pois/poi_pin_red.png",
      "img/pois/poi_pin_green.png",
    ];

    return leafletDataFactory;
});