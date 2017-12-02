<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";

  if(isset($_GET["user"], $_GET["page"]))
  {
    $user_id = $_GET["user"];
    $following = get_user_following($user_id, $dbh);
    $page_number = $_GET["page"];
  }
  else { header("Location: search.php"); }

  $limit = 10;

  $curr_following = array_slice($following, $limit * ($page_number-1), $limit);
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Following | RangeFinder</title>

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
                <h2 class="h2-responsive" style="color: white;">Following</h2>
              </div>
              <div class="card-body">
                <a class="custom-link my-2" href=<?php echo("show.php?id=" . $user_id); ?>> << Return To User </a>
                <br />
                <?php if(empty($curr_following)): ?>
                  <h2 class="text-center">No Following</h2>
                <?php else: ?>
                  <br />

                  <ul>
                    <?php foreach($curr_following as $user) { ?>
                      <div class="list-item text-left">
                        <div class="d-flex row mx-0">
                          <div class="d-flex col-12 justify-content-between">
                            <span>
                              <a class = "custom-link mb-1 mr-2" href=<?php echo "../users/show.php?id=" . $user["id"];?>>
                                <i class="mx-2 fa fa-user-circle-o" aria-hidden="true" style="font-size: 150%"></i>
                                <b><?php echo ($user["username"]); ?></b>
                              </a>
                            </span>
                            <?php if(check_login($dbh) && $_SESSION["user_id"] != $user["id"]): ?>
                              <?php if(user_following($_SESSION["user_id"], $user["id"], $dbh)): ?>
                                <div>
                                  <a class="btn btn-sm btn-outline-primary mx-0" href=<?php echo("unfollow.php?user=" . $user["id"]); ?>><b>Unfollow</b></a>
                                </div>
                              <?php else: ?>
                                <div>
                                  <a href=<?php echo("follow.php?user=" . $user["id"]); ?> class="btn btn-sm btn-primary mx-0"><b>Follow</b></a>
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
                      $url = "following.php?user=" . $user_id . "&page=" . $page_number;
                      display_pagination($following, $page_number, $limit, $url); ?>
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
