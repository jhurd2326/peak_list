<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";

  if(!isset($_SESSION["mountains"]))
  {
    $_SESSION["mountains"] = search_mountains(array($_POST["name"], $_POST["state"], $_POST["country"],
      $_POST["latitude"], $_POST["longitude"], $_POST["max_elevation"], $_POST["min_elevation"]), $dbh);
  }

  $page_number = 0;
  $limit = 10;

  if(isset($_GET["page"]))
  {
    $page_number = $_GET["page"];
    $_SESSION["mountain_page"] = $page_number;
  }
  else
    header("Location: results.php?page=1");

  $curr_mountains = array_slice($_SESSION["mountains"], $limit * ($page_number-1), $limit);
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Mountain Search | RangeFinder</title>
    <link rel="icon" href="../myfavicon.ico"/>
    <link rel="stylesheet" href="../stylesheets/font-awesome.css" />

    <meta name="google" content="notranslate" />


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

    <link rel="stylesheet" href="../stylesheets/custom.css" />

  </head>
  <body>

    <div id= "nav-placeholder"></div>

    <div class="background animated fadeIn">
      <div class="container py-5 ">
        <?php
          if(isset($_GET["error"]))
          {
            echo "<p class='error'>Error Searching For Mountains</p>";
          }
        ?>
        <div class="row mt-5">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card animated fadeIn">
              <div class="card-header primary-color text-center">
                <h2 class="h2-responsive" style="color: white;">Mountains</h2>
              </div>
              <div class="card-body">
                <a href="search.php" class="custom-link"> << Return to Search</a>
                <br />
                <?php if(empty($curr_mountains)): ?>
                  <h2 class="text-center">No Mountains Found</h2>
                <?php else: ?>
                  <br />

                    <?php foreach($curr_mountains as $mountain) { ?>
                      <a href=<?php echo ("show.php?id=" . $mountain["id"]); ?>>
                        <div class="row list-item u-hover--grey">
                          <div class="col-lg-4 col-md-4 col-sm-12 text-center custom-link">
                            <?php echo $mountain["name"]; ?>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                            <?php echo $mountain["state"]; ?>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                            <?php echo $mountain["country"]; ?>
                          </div>
                        </div>
                      </a>
                    <?php } ?>
                  <div class="text-center">
                    <?php
                      $url = "results.php?page=" . $page_number;
                      display_pagination($_SESSION["mountains"], $page_number, $limit, $url);
                    ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>
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
