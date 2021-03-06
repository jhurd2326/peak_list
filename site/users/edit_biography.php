<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";

  if(isset($_GET["id"]))
  {
    $user = find_user($_GET["id"], $dbh);
    $recent = array_slice(user_climbs($user["id"], $dbh), 0, 5);
  }
  else
  {
    $user = array();
    $recent = array();
  }

?>

<!DOCTYPE html>
<html>
  <head>

    <link rel="icon" href="../myfavicon.ico"/>
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

    <title><?php echo "Edit ". $user["username"], " | RangeFinder"; ?></title>

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
        <div class="row">
          <div class="col">
                <h2 class="h2-responsive mb-4" style="color: Black;"><strong>
                  <?php if(empty($user)): ?>
                    Error
                  <?php else: ?>
                    <?php echo $user["first_name"] . " " . $user["last_name"]; ?>
                  <?php endif; ?>
                </strong></h2>
          </div> <!-- end col -->

          <?php if(check_login($dbh) && $_SESSION["user_id"] != $user["id"]): ?>
            <?php if(user_following($_SESSION["user_id"], $user["id"], $dbh)): ?>
              <div>
                <button class="btn-sm btn-outline-primary mx-0"><b>Following</b></button>
              </div>
            <?php else: ?>
              <div>
                <a href=<?php echo("follow.php?user=" . $user["id"]); ?> class="btn btn-sm btn-primary mx-0"><b>Follow</b></a>
              </div>
            <?php endif; ?>
          <?php endif; ?>

        </div> <!--end row -->

        <hr>

                  <!--  user Information  -->
        <div class ="row">
          <div class ="col-sm-12 col-md-6 col-lg-6">
            <div class = "row">
              <div class ="col-8">
                <p> <b>Username: </b> <?php echo $user["username"]?></p>
                <p> <b>Age: </b> <?php echo $user["age"]?></p>
                <p> <b>Phone: </b> <?php echo $user["telephone"]?></p>
                <p> <b>Email: </b> <?php echo $user["email"]?></p>
                <p> <b>Address: </b> <?php echo $user["address"]?></p>
              </div> <!--end col-->

              <div class="col-4 text-right">
                <?php if(check_login($dbh) && ($_SESSION["user_id"] == $user["id"] || check_admin($_SESSION["user_id"], $dbh)) ): ?>
                  <a href=<?php echo("edit.php?id=" . $user["id"]); ?> class="custom-link"><b>Edit</b></a>
                <?php endif; ?>
                <?php if(check_login($dbh) && check_admin($_SESSION["user_id"], $dbh) ): ?>
                  |
                  <a href=<?php echo("delete.php?id=" . $user["id"]); ?> class="custom-link"><b>Delete</b></a>
                <?php endif; ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-8">
                <h3 class ="h3-responsive"><b>Biography</b></h3>
              </div>
              <div class="col-4 text-right">

              </div>
            </div>
            <hr>
            <div class ="row">
              <div class ="col-12">
              <form action=<?php echo "update.php?id=" . $user["id"];?> method="post" name="bio_edit" id="bio_edit">
                <div class="md-form">
                  <textarea type="text" name="biography" id="biography" class="md-textarea"><?php echo $user['biography'];?></textarea>
                  <label for="biography">Type Here...</label>
                </div>
              </form>
            </div>
            </div>
            <div class ="row">
              <div class="col text-center">
                <a class="btn btn-md btn-primary" onclick="bio_edit.submit();">
                  <i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>
                  Save
                </a>
              </div>
            </div>

          </div>
          <div class = "col-sm-12  col-md-6 col-lg-6">
            <div class = "row">
              <div class = "col">
                <div class = "card">
                  <div class="card-header primary-color white-text">
                    <h2 class="h2-responsive">Climber Stats</h2>
                  </div>
                  <div class="card-body">
                    <div class ="row">
                      <div class = "col">
                        <p><b>Following:</b></p>
                      </div>
                      <div class ="col">
                        <?php
                          $following = find_following_count($user["id"], $dbh);
                          if($following == 1)
                            $following = $following . " user";
                          else
                            $following = $following . " users";

                          echo $following;
                        ?>
                      </div>
                    </div><hr>
                    <div class ="row">
                      <div class = "col">
                        <p><b>Followed By:</b></p>
                      </div>
                      <div class ="col">
                        <?php
                          $follower = find_follower_count($user["id"], $dbh);
                          if($follower == 1)
                            $follower = $follower . " user";
                          else
                            $follower = $follower . " users";

                          echo $follower;
                        ?>
                      </div>
                    </div><hr>
                    <div class ="row">
                      <div class = "col">
                        <p><b>Total Mountains Climbed:</b></p>
                      </div>
                      <div class ="col">
                        <p> <?php echo find_climb_count($user["id"], $dbh); ?></p>
                      </div>
                    </div><hr>

                    <div class ="row">
                      <div class = "col">
                        <p><b>Total Likes:</b></p>
                      </div>
                      <div class ="col">
                        <p> <?php echo find_like_count($user["id"], $dbh); ?></p>
                      </div>
                    </div><hr>

                  </div>
                </div>
              </div>
            </div>
            <div class = "row my-5">
              <div class = "col">
                <div class = "card">
                  <div class="card-header primary-color white-text">
                    <h2 class="h2-responsive">Recent Climbs</h2>
                  </div>
                  <div class="card-body py-0">
                      <?php if (empty($recent)): ?>
                        <div class="my-3 flex-center">
                          <h4>No Recent climbs</h4>
                        </div>
                    <?php else: ?>
                      <?php foreach($recent as $mountain) { ?>
                        <div class="row list-item">
                          <div class="col-6 text-center">
                            <a class="custom-link" href=<?php echo "../mountains/show.php?id=" . $mountain["id"];?>>
                              <?php echo $mountain["name"]; ?>
                            </a>
                          </div>
                          <div class="col-6 text-center">
                            <?php echo time_elapsed_string($mountain["created_at"]); ?>
                          </div>
                        </div>
                       <?php } ?>
                      <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          </div> <!--end col-->
        </div> <!--end row -->
         <!-- End First Row -->
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
