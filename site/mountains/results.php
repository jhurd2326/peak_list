<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";

  session_start();

  if(!isset($_SESSION["mountain_name"]))
    $_SESSION["mountain_name"] = $_POST["name"];

  if(!isset($_SESSION["mountain_state"]))
    $_SESSION["mountain_state"] = $_POST["state"];

  if(!isset($_SESSION["mountain_country"]))
    $_SESSION["mountain_country"] = $_POST["country"];

  if(!isset($_SESSION["mountain_latitude"]))
    $_SESSION["mountain_latitude"] = $_POST["latitude"];

  if(!isset($_SESSION["mountain_longitude"]))
    $_SESSION["mountain_longitude"] = $_POST["longitude"];

  if(!isset($_SESSION["mountain_max_elevation"]))
    $_SESSION["mountain_max_elevation"] = $_POST["max_elevation"];

  if(!isset($_SESSION["mountain_min_elevation"]))
    $_SESSION["mountain_min_elevation"] = $_POST["min_elevation"];

  $mountains = search_mountains(array($_SESSION["mountain_name"], $_SESSION["mountain_state"],
    $_SESSION["mountain_country"], $_SESSION["mountain_latitude"], $_SESSION["mountain_longitude"],
    $_SESSION["mountain_max_elevation"], $_SESSION["mountain_min_elevation"]), $dbh);

  $page_number = 0;
  $limit = 10;

  if(isset($_GET["page"]))
    $page_number = $_GET["page"];
  else
    header("Location: results.php?page=1");

  $curr_mountains = array_slice($mountains, $limit * ($page_number-1), $limit);
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
            <div class="card">
              <div class="card-header default-color text-center">
                <h2 class="h2-responsive" style="color: white;">Results</h2>
              </div>
              <div class="card-body">
                <a href="search.php" style="color: #2BBBAD"> << Return to Search</a>
                <br />
                <?php if(empty($curr_mountains) || empty($mountains)): ?>
                  <h2 class="text-center">No Mountains Found</h1>
                <?php else: ?>
                  <br />

                  <ul class = "search-list">
                    <?php foreach($curr_mountains as $mountain) { ?>
                      <a href="#">
                        <div class="row list-item u-hover--grey mx-4">
                          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <?php echo $mountain["name"]; ?>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <?php echo $mountain["state"]; ?>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <?php echo $mountain["country"]; ?>
                          </div>
                        </div>
                      </a>
                    <?php } ?>
                  </ul>
                  <div class="text-center">
                    <?php displayPagination($mountains, $page_number, $limit); ?>
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
