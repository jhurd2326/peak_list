<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";

  if(isset($_GET["mountain"], $_GET["page"]))
  {
    $mountain_id = $_GET["mountain"];
    $comments = find_mountain_comments($mountain_id, $dbh);
    $page_number = $_GET["page"];
  }
  else { header("Location: results.php?page=1"); }

  $limit = 5;

  $curr_comments = array_slice($comments, $limit * ($page_number-1), $limit);
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Comments</title>
    <link rel="icon" href="../myfavicon.ico"/>
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
              <div class="card-header primary-color text-center">
                <h2 class="h2-responsive" style="color: white;">Comments</h2>
              </div>
              <div class="card-body">
                <a class="custom-link my-2" href=<?php echo("show.php?id=" . $mountain_id); ?>> << Return to Mountain </a>
                <br />
                <?php if(empty($curr_comments)): ?>
                  <h2 class="text-center">No Comments</h2>
                <?php else: ?>
                  <br />

                  <ul class="search-list">
                    <?php foreach($curr_comments as $comment) { ?>
                      <div class="list-item text-left">
                        <div class="px-2">
                          <b><?php echo ($comment["username"]); ?></b>
                          <small><?php echo (" " . time_elapsed_string($comment["created_at"])); ?></small>
                        </div>
                        <div class="px-4">
                          <p><?php echo ($comment["content"]); ?></p>
                        </div>
                      </div>
                    <?php } ?>
                  </ul>
                  <div class="text-center">
                    <?php display_pagination($comments, $page_number, $limit); ?>
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
