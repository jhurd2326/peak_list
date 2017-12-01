<?php
  include_once "php/db_connect.php";
  include_once "php/functions.php";

  if(check_login($dbh))
    $user = find_user($_SESSION["user_id"], $dbh);
  else
    header("Location: index.php");
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Dashboard | RangeFinder</title>
    <link rel="icon" href="myfavicon.ico"/>
    <link rel="stylesheet" href="stylesheets/font-awesome.css" />
    <meta name="google" content="notranslate" />

    <script src="javascripts/jquery-3.2.1.min.js"></script>
      <script>
      $.get("navigation.php", function(data){
          $("#nav-placeholder").replaceWith(data);
      });
    </script>

    <script src="javascripts/jquery-3.2.1.min.js"></script>
      <script>
      $.get("footer.php", function(data){
          $("#foot-placeholder").replaceWith(data);
      });
    </script>

    <link rel="stylesheet" href="stylesheets/custom.css" />
    <link rel="stylesheet" href="stylesheets/font-awesome.css" />
  </head>
  <body>
    <div id="nav-placeholder"></div>
    <div class="background">
      <div class="container py-5">
        <?php
          if(isset($_GET["error"]))
          {
            echo "<p class='error'>Error Searching For Mountains</p>";
          }
        ?>
        <div class="row animated slideInUp py-5 ">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
              <div class="card-header primary-color text-center">
                <h2 class="h2-responsive" style="color: white;">Dashboard</h2>
              </div>
              <div class="card-body">

                <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 px-0">

                    <!--  Top Rated Climbs  -->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <?php
                        $top_rated_climbs = find_top_rated_mountains($dbh);
                        if(!empty($top_rated_climbs) && count($top_rated_climbs) > 5)
                          $top_rated_climbs = array_slice($top_rated_climbs, 0, 5);
                      ?>
                      <div class="card-section-title">
                        <h2>Top Rated Climbs</h2>
                      </div>

                      <ul>
                        <?php foreach($top_rated_climbs as $mountain) { ?>
                          <a href=<?php echo ("mountains/show.php?id=" . $mountain["id"]); ?>>
                            <div class="row list-item mx-2">
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left custom-link">
                                <?php echo $mountain["name"]; ?>
                              </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                                <?php
                                  echo $mountain["count(mountains.id)"];
                                  if($mountain["count(mountains.id)"] != 1) echo " likes";
                                  else echo " like";
                                ?>
                              </div>
                            </div>
                          </a>
                        <?php } ?>
                      </ul>
                    </div>

                    <br />

                    <!--  Popular Climbs  -->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <?php
                        $popular_climbs = find_most_popular_mountains($dbh);
                        if(!empty($popular_climbs) && count($popular_climbs) > 5)
                          $popular_climbs = array_slice($popular_climbs, 0, 5);
                      ?>
                      <div class="card-section-title">
                        <h2>Popular Climbs</h2>
                      </div>

                      <ul>
                        <?php foreach($popular_climbs as $mountain) { ?>
                          <a href=<?php echo ("mountains/show.php?id=" . $mountain["id"]); ?>>
                            <div class="row list-item mx-2">
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left custom-link">
                                <?php echo $mountain["name"]; ?>
                              </div>
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                                <?php
                                  echo $mountain["count(mountains.id)"];
                                  if($mountain["count(mountains.id)"] != 1) echo " climbers";
                                  else echo " climber";
                                ?>
                              </div>
                            </div>
                          </a>
                        <?php } ?>
                      </ul>
                    </div>
                  </div>

                  <!--  User Feed  -->
                  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <?php
                      $feed = user_feed($_SESSION["user_id"], $dbh);
                      if(!empty($feed) && count($feed) > 8)
                        $popular_climbs = array_slice($popular_climbs, 0, 8);
                    ?>
                    <div class="card-section-title">
                      <h2>Feed</h2>
                    </div>

                    <ul>
                      <?php foreach($feed as $item) { ?>
                        <div class="row custom-list-item mx-2">
                          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
                            <i class="mx-1 fa fa-user-circle-o" aria-hidden="true"></i>
                            <a class="custom-link" href=<?php echo "users/show.php?id=" . $item["user_id"]?>>
                              <?php echo $item["username"]; ?>
                            </a>
                            climbed

                            <a class="custom-link" href=<?php echo ("mountains/show.php?id=" . $item["mountain_id"]); ?>>
                              <?php echo $item["name"]; ?>
                            </a>
                            <br />
                            <small class="mx-4"><?php echo (" " . time_elapsed_string($item["created_at"])); ?></small>
                          </div>
                        </div>
                      <?php } ?>
                    </ul>

                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="foot-placeholder"></div>

    </div>

    <script type="text/JavaScript" src="javascripts/jquery-3.2.1.min.js"></script>
    <script type="text/JavaScript" src="javascripts/sha512.js"></script>
    <script type="text/JavaScript" src="javascripts/forms.js"></script>
    <script type="text/JavaScript" src="javascripts/popper.min.js"></script>
    <script type="text/JavaScript" src="javascripts/bootstrap.min.js"></script>
    <script type="text/JavaScript" src="javascripts/mdb.min.js"></script>
  </body>
</html>
