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
    <title><?php echo $mountain["name"]; ?></title>

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
              <div class="card-header default-color text-center">
                <h2 class="h2-responsive" style="color: white;">
                  <?php if(empty($mountain)): ?>
                    Error
                  <?php else: ?>
                    <?php echo $mountain["name"]; ?>
                  <?php endif; ?>
                </h2>
              </div>
              <div class="mountain-details" style="position: relative;">
                <?php if(empty($mountain)): ?>
                  <div class="card-body">
                    <h2 class="text-center">No Mountain Found</h2>
                  </div>
                <?php else: ?>
                  <?php display_google_map($mountain["latitude"], $mountain["longitude"]); ?>

                  <div class="d-flex justify-content-end mt-3 py-0">
                    <div class="text-center mx-2">
                      <div class="mx-2 mountain-stats">
                        <h4 class="my-0 text-center"><i class=" fa fa-user text-white" aria-hidden="true"></i></h4>
                      </div>
                      <span class=><small>(23)</small></span>
                    </div>
                    <div class="text-center mx-2">
                      <div class="mx-2 mountain-stats">
                        <a href=<?php echo("like_mountain.php?id=" . $mountain["id"]); ?>>
                          <h4 class="my-0 text-center"><i class="fa fa-thumbs-o-up text-white" aria-hidden="true"></i></h4>
                        </a>
                      </div>
                      <span class=><small>(<?php echo find_mountain_likes($mountain["id"], $dbh); ?>)</small></span>
                    </div>
                    <div class="text-center mx-2">
                      <div class="mx-2 mountain-stats">
                        <a href=<?php echo("dislike_mountain.php?id=" . $mountain["id"]); ?>>
                          <h4 class="my-0 text-center"><i class="fa fa-thumbs-o-down text-white" aria-hidden="true"></i></h4>
                        </a>
                      </div>
                      <span class=><small>(<?php echo find_mountain_dislikes($mountain["id"], $dbh); ?>)</small></span>
                    </div>
                  </div>

                  <div class="card-body">
                    <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card-section-title">
                          <h2>Information</h2>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <b><h4 style="text-decoration:underline">Name</h4></b>
                        <p><?php echo $mountain["name"]; ?></p>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <b><h4 style="text-decoration:underline">State</h4></b>
                        <p><?php echo $mountain["state"]; ?></p>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <b><h4 style="text-decoration:underline">Country</h4></b>
                        <p><?php echo $mountain["country"]; ?></p>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <b><h4 style="text-decoration:underline">Elevation</h4></b>
                        <p><?php echo $mountain["elevation"]; ?> ft. </p>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <b><h4 style="text-decoration:underline">Latitude</h4></b>
                        <p><?php echo $mountain["latitude"]; ?></p>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <b><h4 style="text-decoration:underline">Longitude</h4></b>
                        <p><?php echo $mountain["longitude"]; ?></p>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="d-flex card-section-title">
                          <h2>Comments <?php echo (" (" . count($comments) . ")"); ?></h2>

                          <?php if(check_login($dbh)): ?>
                            <div class="modal fade" id="modalCommentForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header text-center">
                                    <h4 class="modal-title w-100 font-bold">New Comment</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <form action=<?php echo ("/php/new_comment.php?mountain=" . $mountain["id"]); ?> method="post" name="commment_form">
                                    <div class="modal-body mx-3">
                                      <div class="md-form">
                                        <i class="fa fa-comments-o prefix"></i>
                                        <textarea type="text" name="comment_body" id="comment_body" class="md-textarea"></textarea>
                                        <label for="comment-body">Comment</label>
                                      </div>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                      <input type="button" value="Create" class="btn btn-default" onclick="this.form.submit();" />
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <a class="mx-4 pt-2" href="" data-toggle="modal" data-target="#modalCommentForm">
                              <h3><i class="fa fa-pencil-square-o custom-link" aria-hidden="true"></i></h3>
                            </a>
                          <?php endif; ?>
                        </div>

                        <?php foreach($comments as $comment) { ?>
                          <div class="row px-4">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 px-2">
                              <b><?php echo ($comment["username"]); ?></b>
                              <small><?php echo (" " . time_elapsed_string($comment["created_at"])); ?></small>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 px-4">
                              <p><?php echo ($comment["content"]); ?></p>
                            </div>
                          </div>
                        <?php } ?>

                      </div>
                    </div>
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
