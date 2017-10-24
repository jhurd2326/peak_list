<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";

  session_start();

  unset($_SESSION["mountains"]);
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Search</title>

    <link rel="stylesheet" href="../stylesheets/custom.css" />
  </head>
  <body>
    <div class="background">
      <div class="container h-100">
        <?php
          if(isset($_GET["error"]))
          {
            echo "<p class='error'>Error Searching For Mountains</p>";
          }
        ?>
        <div class="row flex-center">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card animated fadeIn">
              <div class="card-header default-color text-center">
                <h2 class="h2-responsive" style="color: white;">Search Mountains</h2>
              </div>
              <div class="card-body">
                <form action="results.php?page=1" method="post" name="mountain_search_form">

                  <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <div class="md-form">
                        <input type="text" name="name" id="name" class="form-control" />
                        <label for="name">Name</label>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="md-form">
                        <input type="text" name="country" id="country" class="form-control" />
                        <label for="country">Country</label>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="md-form">
                        <input type="text" name="state" id="state" class="form-control" />
                        <label for="state">State</label>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="md-form">
                        <input type="number" name="max_elevation" id="max_elevation" class="form-control" />
                        <label for="max_elevation">Maximum Elevation</label>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="md-form">
                        <input type="number" name="min_elevation" id="min_elevation" class="form-control" />
                        <label for="min_elevation">Minimum Elevation</label>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="md-form">
                        <input type="number" name="latitude" id="latitude" class="form-control" />
                        <label for="latitude">Latitude</label>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="md-form">
                        <input type="number" name="longitude" id="longitude" class="form-control" />
                        <label for="longitude">Longitude</label>
                      </div>
                    </div>
                  </div>

                  <div class="text-center my-3">
                    <input type="button" value="Search" onclick="this.form.submit();" class="btn btn-default"/>
                  </div>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script type="text/JavaScript" src="../javascripts/jquery-3.2.1.min.js"></script>
    <script type="text/JavaScript" src="../javascripts/sha512.js"></script>
    <script type="text/JavaScript" src="../javascripts/forms.js"></script>
    <script type="text/JavaScript" src="../javascripts/popper.min.js"></script>
    <script type="text/JavaScript" src="../javascripts/bootstrap.min.js"></script>
    <script type="text/JavaScript" src="../javascripts/mdb.min.js"></script>
  </body>
</html>
