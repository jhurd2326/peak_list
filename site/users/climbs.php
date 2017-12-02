<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";

  if(isset($_GET["user"], $_GET["page"]))
  {
    $user_id = $_GET["user"];
    $climbs = user_climbs($_GET["user"], $dbh);
    $page_number = $_GET["page"];
  }
  else { header("Location: search.php"); }

  $limit = 10;

  $curr_climbs = array_slice($climbs, $limit * ($page_number-1), $limit);
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Climbs | RangeFinder</title>

    <link rel="icon" href="../myfavicon.ico"/>
    <link rel="stylesheet" href="../stylesheets/custom.css" />
    <link rel="stylesheet" href="../stylesheets/font-awesome.css" />
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
              <div class="card-header primary-color text-center">
                <h2 class="h2-responsive" style="color: white;">Mountains Climbed</h2>
              </div>
              <div class="card-body">
                <a class="custom-link my-2" href=<?php echo("show.php?id=" . $user_id); ?>> << Return To User </a>
                <br />
                <?php if(empty($curr_climbs)): ?>
                  <h2 class="text-center">No Mountains Climbed</h2>
                <?php else: ?>
                  <br />

                  <ul>
                    <?php foreach($curr_climbs as $climb) { ?>
                      <a href=<?php echo ("../mountains/show.php?id=" . $climb["id"]); ?>>
                        <div class="row list-item u-hover--grey">
                          <div class="col-lg-4 col-md-4 col-sm-12 text-center custom-link">
                            <?php echo $climb["name"]; ?>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                            <?php echo $climb["state"]; ?>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                            <?php echo $climb["country"]; ?>
                          </div>
                        </div>
                      </a>
                    <?php } ?>
                  </ul>
                  <div class="text-center">
                    <?php
                      $url = "climbs.php?user=" . $user_id . "&page=" . $page_number;
                      display_pagination($climbs, $page_number, $limit, $url); ?>
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
