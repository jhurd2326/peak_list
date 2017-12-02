<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";

  if(isset($_GET["mountain"], $_GET["page"]))
  {
    $mountain_id = $_GET["mountain"];
    $users = find_mountain_users($mountain_id, $dbh);
    $page_number = $_GET["page"];
  }
  else { header("Location: results.php?page=1"); }

  $limit = 10;

  $curr_users = array_slice($users, $limit * ($page_number-1), $limit);
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Climbers | RangeFinder</title>

    <link rel="icon" href="../myfavicon.ico"/>
    <link rel="stylesheet" href="../stylesheets/custom.css" />
    <link rel="stylesheet" href="../stylesheets/font-awesome.css" />
  </head>
  <body>
    <div class="background">
      <div class="container my-5">
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
                <h2 class="h2-responsive" style="color: white;">Climbers</h2>
              </div>
              <div class="card-body">
                <a class="custom-link my-2" href=<?php echo("show.php?id=" . $mountain_id); ?>> << Return to Mountain </a>
                <br />
                <?php if(empty($curr_users)): ?>
                  <h2 class="text-center">No Climbers</h2>
                <?php else: ?>
                  <br />

                  <ul class="search-list">
                    <?php foreach($curr_users as $user) { ?>
                      <div class="list-item text-left">
                        <div class="d-flex row mx-0">
                          <div class="d-flex col-12 justify-content-between">
                            <span>
                              <i class="mx-2 fa fa-user-circle-o" aria-hidden="true" style="font-size: 150%"></i>
                              <a class = "custom-link" href=<?php echo "../users/show.php?id=" . $user["id"];?>>
                                <b><?php echo ($user["username"]); ?></b>
                              </a>
                              <small><?php echo (" climbed it " . time_elapsed_string($user["created_at"])); ?></small>
                            </span>
                            <?php if(check_login($dbh) && $_SESSION["user_id"] != $user["id"]): ?>
                              <?php if(user_following($_SESSION["user_id"], $user["id"], $dbh)): ?>
                                <div>
                                  <a class="btn btn-sm btn-outline-primary mx-0" href=<?php echo("../users/unfollow.php?user=" . $user["id"]); ?>><b>Unfollow</b></a>
                                </div>
                              <?php else: ?>
                                <div>
                                  <a href=<?php echo("../users/follow.php?user=" . $user["id"]); ?> class="btn btn-sm btn-primary mx-0"><b>Follow</b></a>
                                </div>
                              <?php endif; ?>
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  </ul>
                  <div class="text-center">
                    <?php
                      $url = "climbers.php?mountain=" . $mountain_id . "&page=" . $page_number;
                      display_pagination($users, $page_number, $limit, $url); ?>
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
