<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";

  if(!isset($_SESSION["user_results"]))
    $_SESSION["user_results"] = search_users($_POST["username_name"], $dbh);

  $page_number = 0;
  $limit = 10;

  if(isset($_GET["page"]))
    $page_number = $_GET["page"];
  else
    header("Location: results.php?page=1");

  $curr_users = array_slice($_SESSION["user_results"], $limit * ($page_number-1), $limit);
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Search Users</title>
    <link rel="icon" href="/myfavicon.ico"/>

    <script src="/javascripts/jquery-3.2.1.min.js"></script>
      <script>
      $.get("../navigation.php", function(data){
          $("#nav-placeholder").replaceWith(data);
      });
    </script>

    <script src="/javascripts/jquery-3.2.1.min.js"></script>
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
      <div class="container py-5 h-100">
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
                <h2 class="h2-responsive" style="color: white;">Users</h2>
              </div>
              <div class="card-body">
                <a href="search.php" class="custon-link"> << Return to Search</a>
                <br />
                <?php if(empty($curr_users)): ?>
                  <h2 class="text-center">No Users Found</h2>
                <?php else: ?>
                  <br />

                  <?php foreach($curr_users as $user) { ?>
                    <a href=<?php echo ("show.php?id=" . $user["id"]); ?>>
                      <div class="row list-item u-hover--grey">
                        <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                          <?php echo $user["username"]; ?>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                          <?php echo $user["first_name"] . " " . $user["last_name"]; ?>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                          <?php
                            $climbs = find_climb_count($user["id"], $dbh);
                            if($climbs == 1)
                              $climbs = $climbs . " climb";
                            else
                              $climbs = $climbs . " climbs";

                            echo $climbs;
                          ?>
                        </div>
                      </div>
                    </a>
                  <?php } ?>

                  <div class="text-center">
                    <?php display_pagination($_SESSION["user_results"], $page_number, $limit); ?>
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
