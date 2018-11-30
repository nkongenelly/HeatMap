<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>Heatmaps</title>
      <style>
         /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
         #map {
         height: 100%;
         }
         /* Optional: Makes the sample page fill the window. */
         html, body {
         height: 100%;
         margin: 0;
         padding: 0;
         }

         #floating-panel {
            position: relative;
            left: 25%;
            z-index: 5;
            background-color: #fff;
            padding: 5px;
            border: 1px solid #999;
            text-align: center;
            font-family: 'Roboto', 'sans-serif';
            line-height: 30px;
            padding-left: 15px;
            border-radius: 5px;
        }

        #floating-panel {
            background-color: #fff;
            border: 1px solid #999;
            left: 54%;
            padding: 5px;
            position: absolute;
            z-index: 5;
        }
      </style>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link href="css/style.css" rel="stylesheet">
   </head>

  <body onload="getCoordinates()">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <form class="form-inline my-2 my-lg-0 float:right" name = "selectDate" id ="selectDateId">
          <label for="month" class="text-white">Select Month</label>&nbsp;&nbsp;
              <select name = "month">
              <option value="1">January</option>
              <option value="2">February</option>
              <option value="3">March</option>
              <option value="4">April</option>
              <option value="5">May</option>
              <option value="6">June</option>
              <option value="7">July</option>
              <option value="8">August</option>
              <option value="9">September</option>
              <option value="10">October</option>
              <option value="11">November</option>
              <option value="12">December</option>
              <option value="13">First Quarter</option>
              <option value="14">Second Quarter</option>
              <option value="15">Third Quarter</option>
              <option value="16">Fourth Quarter</option>
              <input name= "year" class="form-control mr-sm-2" type="search" placeholder="year" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </ul>
      </div>
      <div id="floating-panel">
      <button onclick="toggleHeatmap()">Toggle Heatmap</button>
      <button onclick="changeGradient()">Change gradient</button>
      <button onclick="changeRadius()">Change radius</button>
      <button onclick="changeOpacity()">Change opacity</button>
    </div>
    </nav>
    <strong>{{ Session::get('error') }}</strong>
    <div id="map"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&callback=initialize"></script>

    <script>
    const maxI = 25, rad = 21, opac = .6;
     var map, heatmap, collection, month, year;

      // This example requires the Visualization library. Include the libraries=visualization
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=visualization">
      var methods = ["GET", "POST"];
    var baseUrl = "http://127.0.0.1:8000/";
        function createObject(readyStateFunction,requestMethod,requestUrl, sendData = null){
            obj = new XMLHttpRequest;
            obj.onreadystatechange = function(){
            if((this.readyState ==4) && (this.status ==200)){
            readyStateFunction(this.responseText);
            }
            };
            obj.open(requestMethod, requestUrl, true);
            if (requestMethod == 'POST'){
            obj.setRequestHeader("Content-type", "application/x-www-form-urlencoded" );
            obj.setvarRequestHeader("X-CSRF-Token", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            obj.send(sendData);
            }
            else
            {
            obj.send();
            }
            }

    function getCoordinates(){
        createObject(initMap,methods[0],baseUrl + "mapCoordinates");
    }

    function getPointss(jsonResponse){
        // var responseObj = JSON.parse(jsonResponse);

        // var array = [for(tData is sonResponse){
        //     return (new google.map.LatLng(responseObj[tData].latitude,responseObj[tData].latitude));
        // }];
        // // array.push(jsonResponse);
        // console.log(array);
    }
    function selectDateNow(){
       month = document.forms['selectDate']['month'].value;
         year = document.forms['selectDate']['year'].value;
    }

      function initMap(jsonResponse) {
        month = document.forms['selectDate']['month'].value;
         year = document.forms['selectDate']['year'].value;
         var url = "http://127.0.0.1:8000/mapCoordinates/" + month + "/" + year;
        // fetch(url)
        fetch('/mapCoordinates')
        .then(function(response) {
          response.json()
          .then(function(result) {
            var locations = result.map((val) => {
              // console.log(val.data_throughput);
                return {location: new google.maps.LatLng(val.latitude, val.longitude), key: val.data_throughput};
                // return {location: new google.maps.LatLng(val.latitude, val.longitude), weight: val.data_throughput};
              // return new google.maps.LatLng(val.latitude, val.longitude);
            })

        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 9,
          center: {lat: 0.0181605, lng: 37.074055},
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
          'rgb(255,0,255)',
          'rgb(0,0,255)',
          'rgb(0,255,0)',
          'rgb(255,255,0)',
          'rgb(255,0,0)'
        ]
        heatmap.set('gradient', heatmap.get('gradient') ? null : gradient);
      }

      function changeRadius() {
        heatmap.set('radius', heatmap.get('radius') ? null : 20);
      }

      function changeOpacity() {
        heatmap.set('opacity', heatmap.get('opacity') ? null : 0.2);
      }

      // Function to change maxIntensity of the heatmap
      function changeIntensity(bool) {
        const step = 25, min = 0, max = 25;
        let current = heatmap.get('maxIntensity');
        let newValue = toggleUpDown(bool, current, step, min, max);
        heatmap.set('maxIntensity', newValue);
        document.getElementById("intensityNum").innerText = newValue;
      };
      // Changes our toggle values and keeps them within our min/max values
      function toggleUpDown(bool, current, step, min, max){
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
        function getPoints(jsonResponse){
            var responseObj = JSON.parse(jsonResponse);
            var array_of_functions = [
            function(){
                for (tData in responseObj)
            {
                    return ({location: new google.map.LatLng(responseObj[tData].latitude,responseObj[tData].longitude),weight:20});
        //         latLng.push({location:'new google.map.LatLng('+responseObj[tData].latitude+','+responseObj[tData].longitude+')',key:20});
        //             // new google.map.LatLng(responseObj[tData].latitude,responseObj[tData].latitude);
        //         ]:
            }
            }
        ];
            return (array_of_functions[0]('a string'));
        }


             document.getElementById("selectDateId").addEventListener("submit", initMap);
            //  selectDateNow
      </script>
      <script async defer
         src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBqpe5MxT-z7CHNWtJHCDm0cp9Mpiwuk3s&libraries=visualization&callback=initMap"></script>
   </body>
</html>
