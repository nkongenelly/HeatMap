const maxI = 25,
    rad = 21,
    opac = .6;
var map, heatmap, collection, month, year;

// This example requires the Visualization library. Include the libraries=visualization
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=visualization">
var methods = ["GET", "POST"];
var baseUrl = "http://127.0.0.1:8000/";

function createObject(readyStateFunction, requestMethod, requestUrl, sendData = null) {
    obj = new XMLHttpRequest;
    obj.onreadystatechange = function () {
        if ((this.readyState == 4) && (this.status == 200)) {
            readyStateFunction(this.responseText);
        }
    };
    obj.open(requestMethod, requestUrl, true);
    if (requestMethod == 'POST') {
        obj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        obj.setvarRequestHeader("X-CSRF-Token", document.querySelector('meta[name="csrf-token"]').getAttribute(
            'content'));
        obj.send(sendData);
    } else {
        obj.send();
    }
}

function getCoordinates() {
    createObject(initMap, methods[0], baseUrl + "mapCoordinates");
}

function getPointss(jsonResponse) {
    // var responseObj = JSON.parse(jsonResponse);

    // var array = [for(tData is sonResponse){
    //     return (new google.map.LatLng(responseObj[tData].latitude,responseObj[tData].latitude));
    // }];
    // // array.push(jsonResponse);
    // console.log(array);
}

function selectDateNow() {
    month = document.forms['selectDate']['month'].value;
    year = document.forms['selectDate']['year'].value;
}

function initMap(jsonResponse) {
    month = document.forms['selectDate']['month'].value;
    year = document.forms['selectDate']['year'].value;
    var url = "http://127.0.0.1:8000/map";
    // fetch(url)
    fetch('/mapCoordinates')
        .then(function (response) {
            response.json()
                .then(function (result) {
                    console.log("result");
                    console.log(result);
                    var locations = result.map((val) => {
                        // console.log(val.data_throughput);
                        return {
                            location: new google.maps.LatLng(val.latitude, val.longitude),
                            key: val.data_throughput
                        };
                        // return {location: new google.maps.LatLng(val.latitude, val.longitude), weight: val.data_throughput};
                        // return new google.maps.LatLng(val.latitude, val.longitude);
                    })

                    map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 9,
                        center: {
                            lat: 0.0181605,
                            lng: 37.074055
                        },
                        mapTypeId: 'roadmap'
                    });

                    heatmap = new google.maps.visualization.HeatmapLayer({
                        data: locations,
                        map: map,
                        maxIntensity: 25,
                        radius: rad,
                        opacity: opac
                    });
                    // console.log(heatmap.data);
                });
        });

}

function toggleHeatmap() {
    heatmap.setMap(heatmap.getMap() ? null : map);
}

function changeGradient() {
    var gradient = [
        'rgba(0, 255, 255, 0)',
        'rgba(0, 255, 255, 1)',
        'rgba(0, 191, 255, 1)',
        'rgba(0, 127, 255, 1)',
        'rgba(0, 63, 255, 1)',
        'rgba(0, 0, 255, 1)',
        'rgba(0, 0, 223, 1)',
        'rgba(0, 0, 191, 1)',
        'rgba(0, 0, 159, 1)',
        'rgba(0, 0, 127, 1)',
        'rgba(63, 0, 91, 1)',
        'rgba(127, 0, 63, 1)',
        'rgba(191, 0, 31, 1)',
        'rgba(255, 0, 0, 1)'
    ]
    heatmap.set('gradient', heatmap.get('gradient') ? null : gradient);
}

function changeRadius() {
    heatmap.set('radius', heatmap.get('radius') ? null : 20);
}

function changeOpacity() {
    heatmap.set('opacity', heatmap.get('opacity') ? null : 0.2);
}
console.log("Js Reached!");

// Function to change maxIntensity of the heatmap
function changeIntensity(bool) {
    const step = 25,
        min = 0,
        max = 25;
    let current = heatmap.get('maxIntensity');
    let newValue = toggleUpDown(bool, current, step, min, max);
    heatmap.set('maxIntensity', newValue);
    document.getElementById("intensityNum").innerText = newValue;
};
// Changes our toggle values and keeps them within our min/max values
function toggleUpDown(bool, current, step, min, max) {
    if (bool && current >= max) return current;
    if (!bool && current <= min) return current;
    if (bool) return current + step;
    return current - step;
}
// Used to round the opacity toggle to one decimal place
function round(value, precision) {
    var multiplier = Math.pow(10, precision || 0);
    return Math.round(value * multiplier) / multiplier;
}

// Heatmap data: 500 Points
function getPoints(jsonResponse) {
    var responseObj = JSON.parse(jsonResponse);
    var array_of_functions = [
        function () {
            for (tData in responseObj) {
                return ({
                    location: new google.map.LatLng(responseObj[tData].latitude, responseObj[tData].longitude),
                    weight: 20
                });
                //         latLng.push({location:'new google.map.LatLng('+responseObj[tData].latitude+','+responseObj[tData].longitude+')',key:20});
                //             // new google.map.LatLng(responseObj[tData].latitude,responseObj[tData].latitude);
                //         ]:
            }
        }
    ];


    return (array_of_functions[0]('a string'));

}


document.getElementById("selectDateId").addEventListener("submit", initMap);
