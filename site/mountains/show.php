<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";

  if(isset($_GET["id"]))
    $mountain = find_mountain($_GET["id"], $dbh);
  else
    $mountain = array();

  $comments = find_mountain_comments($mountain["id"], $dbh);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="google" content="notranslate" />
    <link rel="icon" href="../myfavicon.ico"/>
    <script src="../javascripts/jquery-3.2.1.min.js"></script>
      <script>
      $.get("../navigation.php", function(data){
          $("#nav-placeholder").replaceWith(data);
      });
    </script>

    <script src="../javascripts/jquery-3.2.1.min.js"></script>
      <script>
      $.get("../footer.php", function(data){
          $("#foot-placeholder").replaceWith(data);
      });
    </script>

    <title><?php echo $mountain["name"], " | RangeFinder"; ?></title>

    <link rel="stylesheet" href="../stylesheets/custom.css" />
    <link rel="stylesheet" href="../stylesheets/font-awesome.css" />
  </head>
  <body>
    <div id= "nav-placeholder"></div>

    <div class="background">
      <div class="container p-5 h-100">
        <?php
          if(isset($_GET["error"]))
          {
            echo "<p class='error'>Error Searching For Mountains</p>";
          }
        ?>
        <div class="form-group">
            &nbsp;
        </div>
        <div class="row">
          <div class = "col-lg-6 col-md-12 mb-4">
            <?php if(empty($mountain)): ?>
                <h2 class="text-center">No Mountain Found</h2>
            <?php else: ?>
              <?php display_google_map($mountain["latitude"], $mountain["longitude"]); ?>
          </div>
          <div class="col-lg-6 col-md-12 col-sm-12">
              <?php if(empty($mountain)): ?>
                <h2 class="h2-responsive" style="color: Black;"><strong>Error</strong></h2>
              <?php else: ?>
                <div class="d-flex justify-content-between">
                  <div>
                    <h2 class="h2-responsive" style="color: Black;"><strong><?php echo $mountain["name"]; ?></strong></h2>
                  </div>
                  <div>
                    <?php if(check_login($dbh) && ($_SESSION["user_id"] == $user["id"] || check_admin($_SESSION["user_id"], $dbh)) ): ?>
                      <a href=<?php echo("edit.php?id=" . $mountain["id"]); ?> class="custom-link"><b>Edit</b></a>
                    <?php endif; ?>
                    <?php if(check_login($dbh) && check_admin($_SESSION["user_id"], $dbh) ): ?>
                      |
                      <a href=<?php echo("delete.php?id=" . $mountain["id"]); ?> class="custom-link"><b>Delete</b></a>
                    <?php endif; ?>
                  </div>
                </div>
              <?php endif; ?>

              <div class="mountain-details" style="position: relative;">
                <!--  Mountain Information  -->

                <div class="row">
                    <div class ="col">
                      <p> <b>State/Province:</b> <?php echo $mountain["state"]; ?></p>
                  </div>
                </div>
                <div class =" row">
                    <div class = "col">
                      <p><b> Country:</b> <?php echo $mountain["country"]; ?></p>
                    </div>
                </div>

                <div class="row">
                  <div class="col">
                    <p><b>Elevation:</b> <?php echo $mountain["elevation"]; ?> ft. </p>
                  </div>
                </div>
                <div class ="row">

                  <div class="col">
                    <p><b>Lattitude:</b> <?php echo $mountain["latitude"]; ?></p>
                  </div>
                </div>

                <div class ="row">

                  <div class="col">
                    <p><b>Longitude:</b> <?php echo $mountain["longitude"]; ?></p>
                  </div>
                </div>

                <hr />

                  <!-- Buttons -->
                  <div class="d-flex justify-content-end mt-3 py-0">
                    <div class="text-center mx-2">
                      <?php if(!check_login($dbh) || mountain_user($_GET["id"], $_SESSION["user_id"], $dbh)): ?>
                        <div class="mx-2 mountain-stats-disabled">
                          <h3 class="my-0 text-center"><i class=" fa fa-check-circle" aria-hidden="true"></i></h3>
                        </div>
                      <?php else: ?>
                        <div class="mx-2 mountain-stats">
                          <a href=<?php echo("climb_mountain.php?id=" . $mountain["id"]); ?>>
                            <h3 class="my-0 text-center"><i class=" fa fa-check-circle-o" aria-hidden="true"></i></h3>
                          </a>
                        </div>
                      <?php endif; ?>
                      <a class="custom-link" href=<?php echo("climbers.php?page=1&mountain=" . $mountain["id"]); ?>>
                        <span><small>
                          <?php
                            $climbers = find_mountain_users_count($mountain["id"], $dbh);
                            echo $climbers;
                            if($climbers == 1): echo " climber";
                            else: echo " climbers";
                            endif;
                          ?>
                        </small></span>
                      </a>
                    </div>
                    <div class="text-center mx-2">
                      <?php if(!check_login($dbh) || user_mountain_rating($_GET["id"], $_SESSION["user_id"], $dbh)): ?>
                        <div class="mx-2 mountain-stats-disabled-heart">
                          <h4 class="my-0 text-center"><i class="fa fa-heart" aria-hidden="true"></i></h4>
                        </div>
                      <?php else: ?>
                        <div class="mx-2 mountain-stats-heart">
                          <a href=<?php echo("like_mountain.php?id=" . $mountain["id"]); ?>>
                            <h4 class="my-0 text-center"><i class="fa fa-heart-o" aria-hidden="true"></i></h4>
                          </a>
                        </div>
                      <?php endif; ?>
                      <a class="custom-link" href=<?php echo("likes.php?page=1&mountain=" . $mountain["id"]); ?>>
                        <span><small>
                          <?php
                            $likes = find_mountain_likes_count($mountain["id"], $dbh);
                            echo $likes;
                            if($likes == 1): echo " like";
                            else: echo " likes";
                            endif;
                          ?>
                        </small></span>
                      </a>
                    </div>
                  </div> <!--Buttons -->
                <?php endif; ?>
              </div> <!-- Mountain Deatils -->
          </div> <!-- End Col 2 -->
        </div> <!-- End First Row -->
      </div> <!-- End Container -->

      <div class = "container-fluid unique-color px-5">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="d-flex card-section-title">
              <h2 class="white-text">Comments</h2>

              <!--  Comments Modal  -->
              <?php if(check_login($dbh)): ?>
                <div class="modal fade" id="modalCommentForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header text-center">
                        <h4 class="h4-responsive modal-title w-100 font-bold"><?php echo "Comment on " . $mountain["name"]; ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action=<?php echo ("../php/new_comment.php?mountain=" . $mountain["id"]); ?> method="post" name="commment_form">
                        <div class="modal-body mx-3">
                          <div class="md-form">
                            <i class="fa fa-comments-o prefix"></i>
                            <textarea type="text" name="comment_body" id="comment_body" class="md-textarea"></textarea>
                            <label for="comment-body">Comment</label>
                          </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                          <input type="button" value="Post" class="btn btn-primary" onclick="this.form.submit();" />
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <a class="mx-4 pt-2" href="" data-toggle="modal" data-target="#modalCommentForm">
                  <h3><i class="fa fa-pencil-square-o comments-button" aria-hidden="true"></i></h3>
                </a>
              <?php endif; ?>
            </div>

            <!--  Link to view all comments if there are more than 5 comments  -->
            <?php if(count($comments) > 5): ?>
              <?php $comments = array_slice($comments, 0, 5); ?>
              <div class="d-flex justify-content-end">
                <a class="custom-link my-2 comments-button" href=<?php echo("comments.php?page=1&mountain=" . $mountain["id"]); ?>> View all  <?php echo (" " . count($comments) . " comments "); ?>>> </a>
              </div>
            <?php endif; ?>

            <!--  List the most recent comments  -->
            <?php foreach($comments as $comment) { ?>
              <div class="row px-4 white-text">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 px-2">
                  <a class ="comments-button" href=<?php echo "../users/show.php?id=" . $comment["user_id"]; ?>>
                    <b><?php echo ($comment["username"]); ?></b>
                  </a>
                  <small><?php echo (" " . time_elapsed_string($comment["created_at"])); ?></small>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 px-4">
                  <p><?php  echo ($comment["content"]);?></p>
                </div>
              </div>
            <?php } ?>

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
