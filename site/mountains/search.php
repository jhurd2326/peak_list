<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";
  include_once "../php/constants.php";

  unset($_SESSION["mountains"]);
?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="icon" href="../myfavicon.ico"/>
    <meta name="google" content="notranslate" />

    <title>Mountain Search | RangeFinder</title>
    <script src="../javascripts/jquery-3.2.1.min.js"></script>
      <script>
      $.get("navigation.php", function(data){
          $("#nav-placeholder").replaceWith(data);
      });
    </script>

    <script src="../javascripts/jquery-3.2.1.min.js"></script>
      <script>
      $.get("../footer.php", function(data){
          $("#foot-placeholder").replaceWith(data);
      });
    </script>

    <script>
        document.onkeydown=function(evt){
            var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
            if(keyCode == 13)
            {
                document.mountain_search_form.submit();
            }
        }
    </script>

    <link rel="stylesheet" href="../stylesheets/custom.css" />
  </head>
  <body>

    <div id= "nav-placeholder"></div>

    <div class="background-white animated fadeIn">
      <div class="container py-5">
        <?php
          if(isset($_GET["error"]))
          {
            echo "<p class='error'>Error Searching For Mountains</p>";
          }
        ?>

        <div class = "row mt-5 text-center text-lg-left text-md-left">
          <div class = "col">
            <h1 class = "h1-responsive">Search Mountains</h1>
          </div>
        </div>
        <div class="row mt-5">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form action="results.php?page=1" method="post" name="mountain_search_form" id="mountain_search_form">
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
                      <div class="form-group">
                        <label for="country" style="color: #757575;">Country:</label>
                        <select class="form-control custom-dropdown" name="country" id="country">
                          <option value=""> -- </option>
                          <?php foreach ($countries as $country) {?>
                            <option><?php echo $country; }?></option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="form-group">
                        <label for="state" style="color: #757575;">State:</label>
                        <select class="form-control custom-dropdown" name="state" id="state">
                          <option value=""> -- </option>
                          <?php foreach ($us_states as $state) {?>
                            <option><?php echo $state; }?></option>
                          <?php foreach ($canadian_states as $state) {?>
                            <option><?php echo $state; }?></option>
                          <?php foreach ($mexican_states as $state) {?>
                            <option><?php echo $state; }?></option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="md-form">
                        <input type="number" min="1" max="25000" name="max_elevation" id="max_elevation" class="form-control" />
                        <label for="max_elevation">Maximum Elevation</label>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="md-form">
                        <input type="number" min="1" max="25000" name="min_elevation" id="min_elevation" class="form-control" />
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
                    <input type="submit" value="Search" class="btn btn-primary"/>
                  </div>

                </form>
          </div>
        </div>
      </div>
      <div id= "foot-placeholder"></div>

    </div>



    <script type="text/JavaScript" src="../javascripts/jquery-3.2.1.min.js"></script>
    <script type="text/JavaScript" src="../javascripts/sha512.js"></script>
    <script type="text/JavaScript" src="../javascripts/forms.js"></script>
    <script type="text/JavaScript" src="../javascripts/popper.min.js"></script>
    <script type="text/JavaScript" src="../javascripts/bootstrap.min.js"></script>
    <script type="text/JavaScript" src="../javascripts/mdb.min.js"></script>

  </body>
</html>
