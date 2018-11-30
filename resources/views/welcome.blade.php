<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Heatmap</title>

  <!-- Bootstrap core CSS -->
  <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet" /> -->

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

  <!-- Custom styles for this template -->
  <link href="css/agency.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <script src="js/heatmap.js"></script>

</head>

<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top">Heat Map</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive"
        aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav text-uppercase ml-auto">
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="/map">Heatmap</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#throughput">Throughput</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#bucket">Bucket</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#manage">Manage Buckets</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#sales">Sales Reports</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <section id="intro">
    <div class="intro-content">
      <h2> MAWINGU NETWORKS</h2>
      <h3>Affordable and Reliable Internet</h3>
      <div>
        <h3>
          <font color="#fec503">Select an Action</font>
        </h3>
        <a class="nav-link  btn btn-info btn-sm" href="/map" style="display:inline-block;">Show Heat Map
        </a>
        <a class="nav-link  btn btn-info btn-sm" href="/upload" style="display:inline-block;">Upload
          Throughput</a>
        <a class="nav-link  btn btn-info btn-sm" href="/uploadBucket" style="display:inline-block; color:white;">Upload
          Bucket</a>
        <a class="nav-link btn btn-warning btn-sm" class="btn btn-warning btn-sm" href="/search/Bucket" style="display:inline-block; color:white;">Manage
          Buckets</a>
        <a class="nav-link btn btn-warning btn-sm" class="btn btn-warning btn-sm" href="/salesReport" style="display:inline-block; color:white;">Show
          Reports</a>
      </div>
    </div>
  </section>

  <!-- Heatmap -->
  <section id="heatmap" onload="getCoordinates()">
    <div class="container">
      <h2 class="text-center">
        Show Heatmap
      </h2>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
          aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <form class="form-inline my-2 my-lg-0 float:right" name="selectDate" id="selectDateId">
              <label for="month" class="text-white">Select Month</label>&nbsp;&nbsp;
              <select name="month" class="form-control mr-sm-2">
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
                <input name="year" class="form-control mr-sm-2" type="search" placeholder="year" aria-label="Search">
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
      <div id="map"></div>

    </div>
  </section>

  <!-- Upload Throughput -->
  <section class="bg-light" id="throughput">
    <div class="container">
      <h2 class="text-center">
        Upload-Throughput Data
      </h2>

      @if ( Session::has('success') )
          <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
              <span class="sr-only">Close</span>
              </button>
              <strong>{{ Session::get('success') }}</strong>
          </div>
      @endif

      @if ( Session::has('error') )
          <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  <span class="sr-only">Close</span>
              </button>
              <strong>{{ Session::get('error') }}</strong>
          </div>
      @endif

      @if (count($errors) > 0)
          <div class="alert alert-danger">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
              <div>
                  @foreach ($errors->all() as $error)
                  <p>{{ $error }}</p>
                  @endforeach
              </div>
          </div>
      @endif

      <form action="/import" method="POST" enctype="multipart/form-data">
      {{ csrf_field() }}
        Choose your xls/csv file : <input type="file" name="file" class="form-control"><br>
        <a href="#heatmap" class="btn btn-warning btn-md js-scroll-trigger" type="submit">Back</a>
        <button class="btn btn-success btn-md" type="submit">Submit</button>
      </form><br>
      <!-- <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="75"
          aria-valuemin="0" aria-valuemax="100" style="width: 40%">40%</div>
      </div> -->
    </div>
  </section>

  <!-- Upload Bucket -->
  <section id="bucket">
    <div class="container">
      <h2 class="text-center">
        Upload-Bucket Coordinates
      </h2>

      @if ( Session::has('success') )
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
                <span class="sr-only">Close</span>
            </button>
            <strong>{{ Session::get('success') }}</strong>
        </div>
      @endif

      @if ( Session::has('error') )
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
                <span class="sr-only">Close</span>
            </button>
            <strong>{{ Session::get('error') }}</strong>
        </div>
      @endif

      @if (count($errors) > 0)
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <div>
                @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
        </div>
      @endif

      <form action="/uploadBucket" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        Choose your xls/csv File : <input type="file" name="file" class="form-control"><br>
        <a href="#heatmap" class="btn btn-warning btn-md js-scroll-trigger" type="submit">Back</a>
        <button class="btn btn-success btn-md" type="submit">Submit</button>
      </form><br>
      <!-- <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar"
          aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 60%">60%</div>
      </div> -->
    </div>
  </section>

  <!-- Create Bucket -->
  <section class="bg-light" id="manage">
    <div class="container">
      <h2 class="text-center">
        Create Bucket
      </h2>
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">Bucket</div>
            <div class="card-body">
              <form action="/createBucket" method="POST">
                {{csrf_field()}}
                <div class="row">

                  <div class="col-sm-4">
                    <div class="form-group col-md-6">
                      <label for="bucket">Bucket Name </label>
                      <input class="form-control" type="text" name="bucket_name">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="ctype">Client Type</label>
                      <select name="client_type" class="form-control">
                        <option>Choose...</option>
                        <option value="MKT">MKT
                        <option>
                          <select>
                    </div>
                  </div>

                  <div class="col-sm-4">
                    <div class="form-group col-md-6">
                      <label for="lat">Latitude</label>
                      <input name="latitude" type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="lng">Longitude</label>
                      <input name="longitude" type="text" class="form-control">
                    </div>
                  </div>

                  <div class="col-sm-4">
                    <div class="form-group col-md-6">
                      <label for="base">Base Station</label>
                      <input name="bs_name" class="form-control" type="text">
                    </div>
                    <div class="form-group col-md-6">
                      <button class="btn btn-success btn-md" type="submit">Submit</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Search Bucket -->
  <section class="py-5">
    <div class="container">
      <h2 class="text-center">
        Search Bucket
      </h2>
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">Search</div>
            <div class="card-body">
              <form action="/searchBucket" method="POST">
              {{ csrf_field()}}
                <div class="form-group col-md-6">
                  <br>
                  <label for="bucketSearch">Search Bucket</label>
                  <input class="form-control" type="text" name="search" REQUIRED>
                </div>
                <div class="form-group col-md-6">
                  <button class="btn btn-success btn-md" type="submit">Search</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div><br>

    <!-- Show table -->
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-12">
          @if(isset($details))
          <table class="table table-bordered table-hover" style="border-radius: 5px;">
            <thead class="thead-light">
              <tr>
                <th>Id</th>
                <th>Bucket Name</th>
                <th>Base Station</th>
                <th>Client Type</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th colspan="3">Actions</th>
              </tr>
            </thead>
            @foreach($details as $bucket)
            <tr>
              <td>{{$bucket->id}}</td>
              <td>{{$bucket->bucket_name}}</td>
              <td>{{$bucket->bs_name}}</td>
              <td>{{$bucket->client_type}}</td>
              <td>{{$bucket->latitude}}</td>
              <td>{{$bucket->longitude}}</td>
              <td><a href="/bucket/edit/{{$bucket->id}}" class="btn btn-md btn-info">Edit</a></td>
              <td><a href="/bucket/delete/{{$bucket->id}}" class="btn btn-md btn-danger" onclick="return confirm('Are you sure you want to delete Bucket?')">Delete</a></td>
            </tr>
            @endforeach
          </table>
          @elseif(isset($message))
          <p>{{$message}}</p>
          @endif
        </div>
      </div>
    </div>
  </section>

  <!-- Sales Reports -->
  <section class="bg-light" id="sales">
    <div class="container">
      <h2 class="text-center">
        Sales Report
      </h2>
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">Generate Report</div>
            <div class="card-body">
              <form action="/salesReports" method="POST" enctype="multipart/form-data">
              {{ csrf_field() }}
                <div class="row">
                  <div class="col-sm-5">
                    <div class="form-group col-md-6">
                      <select name="month" class="form-control">
                        <option>--Choose month--</option>
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
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-5">
                    <div class="form-group col-md-6">
                      <input type="search" id="year" name="year" class="form-control mr-sm-2" placeholder="--Year e.g 2018--"
                        aria-label="Search">
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group col-md-6">
                      <button class="btn btn-success btn-md" type="submit">Submit</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <span class="copyright">&copy; Mawingu Heatmap 2018</span>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Contact form JavaScript -->
  <script src="js/jqBootstrapValidation.js"></script>
  <script src="js/contact_me.js"></script>

  <!-- Custom scripts for this template -->
  <script src="js/agency.min.js"></script>

  <!-- scripts for map coordinates -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&callback=initialize"></script>

  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBqpe5MxT-z7CHNWtJHCDm0cp9Mpiwuk3s&libraries=visualization&callback=initMap"></script>

</body>

</html>
