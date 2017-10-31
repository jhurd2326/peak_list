<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";

  session_start();

  if(isset($_GET["id"]))
    $mountain = find_mountain($_GET["id"], $dbh);
  else
    $mountain = array();
?>

<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $mountain["name"]; ?></title>

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
            <div class="card">
              <div class="card-header default-color text-center">
                <h2 class="h2-responsive" style="color: white;">
                  <?php if(empty($mountain)): ?>
                    Error
                  <?php else: ?>
                    <?php echo $mountain["name"]; ?>
                  <?php endif; ?>
                </h2>
              </div>
              <div class="mountain-details">
                <?php if(empty($mountain)): ?>
                  <div class="card-body">
                    <h2 class="text-center">No Mountain Found</h2>
                  </div>
                <?php else: ?>
                  <?php display_google_map($mountain["latitude"], $mountain["longitude"]); ?>
                  <div class="card-body">

                    <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card-section-title">
                          <h2>Information</h2>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <b><h4 style="text-decoration:underline">Name</h4></b>
                        <p><?php echo $mountain["name"]; ?></p>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <b><h4 style="text-decoration:underline">State</h4></b>
                        <p><?php echo $mountain["state"]; ?></p>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <b><h4 style="text-decoration:underline">Country</h4></b>
                        <p><?php echo $mountain["country"]; ?></p>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <b><h4 style="text-decoration:underline">Elevation</h4></b>
                        <p><?php echo $mountain["elevation"]; ?> ft. </p>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <b><h4 style="text-decoration:underline">Latitude</h4></b>
                        <p><?php echo $mountain["latitude"]; ?></p>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <b><h4 style="text-decoration:underline">Longitude</h4></b>
                        <p><?php echo $mountain["longitude"]; ?></p>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card-section-title">
                          <h2>Comments</h2>
                        </div>
                      </div>
                    </div>

                  </div>
                <?php endif; ?>
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
