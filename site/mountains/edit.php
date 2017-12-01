<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";
  include_once "../php/constants.php";


  if(isset($_GET["id"]))
    $mountain = find_mountain($_GET["id"], $dbh);
  else
    $mountain = array();
?>

<!DOCTYPE html>
<html>
  <head>

    <link rel="icon" href="../myfavicon.ico"/>
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

    <title><?php echo $mountain["name"] . " | RangeFinder"; ?></title>

    <link rel="stylesheet" href="../stylesheets/custom.css" />
    <link rel="stylesheet" href="../stylesheets/font-awesome.css" />
  </head>
  <body>
    <div id= "nav-placeholder"></div>

    <div class="background-white">
      <div class="container p-5">
        <?php
          if(isset($_GET["error"]))
          {
            echo "<p class='error'>Error Searching For users</p>";
          }
        ?>
        <div class="form-group">
            &nbsp;
        </div>
        <div class="row flex-center">
          <div class="col-6 text-left">
            <h2 class="h2-responsive mb-4" style="color: Black;">
              <strong>
                <?php if(empty($mountain)): ?>
                  Error
                <?php elseif(check_login($dbh) && check_admin($_SESSION["user_id"], $dbh) ): ?>
                  <?php echo $mountain["name"]; ?>
                <?php else: ?>
                  Error
                <?php endif; ?>
              </strong>
            </h2>
            <hr>

            <!--  user Information  -->
            <?php if(empty($mountain)): ?>
              <h4 class="h4-responsive mb-4">No Mountain</h4>
            <?php elseif(check_login($dbh) && check_admin($_SESSION["user_id"], $dbh) ): ?>
              <form action=<?php echo "update.php?id=" . $mountain["id"]; ?> method="post" name="mountain_edit_form" id="mountain_edit_form">
                <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="md-form">
                      <input type="text" name="name" id="name" class="form-control" value="<?php echo $mountain["name"]; ?>">
                      <label for="name">Name</label>
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                      <small><label for="state" style="color: #888888;">State</label></small>
                      <select class="form-control custom-dropdown" name="state" id="state">
                        <?php
                          foreach ($us_states as $state)
                          {
                            if($state == $mountain["state"]) echo "<option selected='selected'>";
                            else echo "<option>";
                            echo $state . "</option>";
                          }
                          foreach ($canadian_states as $state)
                          {
                            if($state == $mountain["state"]) echo "<option selected='selected'>";
                            else echo "<option>";
                            echo $state . "</option>";
                          }
                          foreach ($mexican_states as $state)
                          {
                            if($state == $mountain["state"]) echo "<option selected='selected'>";
                            else echo "<option>";
                            echo $state . "</option>";
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-2">
                    <div class="form-group">
                      <small><label for="country" style="color: #888888;">Country</label></small>
                      <select class="form-control custom-dropdown" name="country" id="country">
                        <?php
                          foreach ($countries as $country)
                          {
                            if($country == $mountain["country"]) echo "<option selected='selected'>";
                            else echo "<option>";
                            echo $country . "</option>";
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="md-form">
                      <input type="number" name="elevation" id="elevation" class="form-control" value="<?php echo $mountain["elevation"]; ?>">
                      <label for="elevation">Elevation</label>
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="md-form">
                      <input type="number" name="latitude" id="latitude" class="form-control" value="<?php echo $mountain["latitude"]; ?>">
                      <label for="latitude">Latitude</label>
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="md-form">
                      <input type="number" name="longitude" id="longitude" class="form-control" value="<?php echo $mountain["longitude"]; ?>">
                      <label for="longitude">Longitude</label>
                    </div>
                  </div>
                </div>

                <div class="text-center my-3">
                  <a class="btn btn-primary" onclick="mountain_edit_form.submit();">
                    <i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>
                    Save
                  </a>
                </div>
              </form>
            <?php else: ?>
              <h4 class="h4-responsive mb-4">You are not authorized to view this page</h4>
            <?php endif; ?>
          </div> <!-- End Col 2 -->


        </div> <!-- End First Row -->
      </div> <!-- End Container -->

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
