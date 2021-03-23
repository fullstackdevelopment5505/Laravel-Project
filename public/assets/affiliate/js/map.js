/**
 * ---------------------------------------
 * This demo was created using amCharts 4.
 * 
 * For more information visit:
 * https://www.amcharts.com/
 * 
 * Documentation is available at:
 * https://www.amcharts.com/docs/v4/
 * ---------------------------------------
 */

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create map instance
var chart = am4core.create("chartdiv", am4maps.MapChart);

// Set map definition
chart.geodata = am4geodata_worldLow;

// Set projection
chart.projection = new am4maps.projections.Miller();

// Create map polygon series
var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());

// Exclude Antartica
polygonSeries.exclude = ["AQ"];

// Make map load polygon (like country names) data from GeoJSON
polygonSeries.useGeodata = true;

// Configure series
var polygonTemplate = polygonSeries.mapPolygons.template;
polygonTemplate.tooltipText = "{name}";
polygonTemplate.polygon.fillOpacity = 0.6;


// Create hover state and set alternative fill color
var hs = polygonTemplate.states.create("hover");
hs.properties.fill = chart.colors.getIndex(0);

// Add image series
var imageSeries = chart.series.push(new am4maps.MapImageSeries());
imageSeries.mapImages.template.propertyFields.longitude = "longitude";
imageSeries.mapImages.template.propertyFields.latitude = "latitude";
imageSeries.mapImages.template.tooltipText = "{title}";
imageSeries.mapImages.template.propertyFields.url = "url";

var circle = imageSeries.mapImages.template.createChild(am4core.Circle);
circle.radius = 3;
circle.propertyFields.fill = "color";

var circle2 = imageSeries.mapImages.template.createChild(am4core.Circle);
circle2.radius = 3;
circle2.propertyFields.fill = "color";


circle2.events.on("inited", function(event){
  animateBullet(event.target);
})


function animateBullet(circle) {
    var animation = circle.animate([{ property: "scale", from: 1, to: 5 }, { property: "opacity", from: 1, to: 0 }], 1000, am4core.ease.circleOut);
    animation.events.on("animationended", function(event){
      animateBullet(event.target.object);
    })
}

var colorSet = new am4core.ColorSet();

imageSeries.data = [ {
   "title": "Long Beach",
  "latitude": 33.770050,
  "longitude": -118.193741,
  "color":colorSet.next()
}, {
  "title": "Pasadena",
  "latitude": 34.156113,
  "longitude": -118.131943,
  "color":colorSet.next()
}, {
  "title": "Glendale",
    "latitude": 34.142509,
    "longitude": -118.255074,
    "color":colorSet.next()
},
{
  "title": "Los Angeles",
    "latitude":34.052235,
    "longitude":-118.243683,
    "color":colorSet.next()
},
{
  "title":"Columbia",
  "latitude":38.951561,
  "longitude":-92.328636,
  "color":colorSet.next()
},
{
  "title":"Burlingame",
  "latitude":37.5841667,
  "longitude":-122.365,
  "color":colorSet.next()
},
{
  "title":"Brooktrails",
  "latitude":39.4438,
  "longitude":-123.3853,
  "color":colorSet.next()
},
{
  "title":"Washington",
  "latitude":47.608013,
  "longitude":-122.335167,
  "color":colorSet.next()
},
{
  "title":"Pacifica",
  "latitude":37.61383,
  "longitude":-122.48692,
  "color":colorSet.next()
},
{
  "title":"Palmdale",
  "latitude":34.579449,
  "longitude":-118.109291,
  "color":colorSet.next()
}
 


 ];

