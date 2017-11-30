<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";

  if(isset($_GET["id"]))
    $user = find_user($_GET["id"], $dbh);
  else
    $user = array();
?>

<!DOCTYPE html>
<html>
  <head>

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

    <title><?php echo $user["username"], " | RangeFinder"; ?></title>

    <link rel="stylesheet" href="../stylesheets/custom.css" />
    <link rel="stylesheet" href="../stylesheets/font-awesome.css" />
  </head>
  <body>
    <div id= "nav-placeholder"></div>

    <div class="background-white">
      <div class="container p-5 h-100">
        <?php
          if(isset($_GET["error"]))
          {
            echo "<p class='error'>Error Searching For users</p>";
          }
        ?>
        <div class="form-group">
            &nbsp;
        </div>
        <div class="row flex-center">
          <div class="col-6 text-left">
                <h2 class="h2-responsive mb-4" style="color: Black;"><strong>
                  <?php if(empty($user)): ?>
                    Error
                  <?php else: ?>
                    <?php echo $user["first_name"] . " " . $user["last_name"]; ?>
                  <?php endif; ?>
                </strong></h2><hr>

                  <!--  user Information  -->


                          <p> <b>Username: </b> <?php echo $user["username"]?></p>
                          <p> <b>Age: </b> <?php echo $user["age"]?></p>
                          <p> <b>Phone: </b> <?php echo $user["telephone"]?></p>
                          <p> <b>Email: </b> <?php echo $user["email"]?></p>
                          <p> <b>Address: </b> <?php echo $user["address"]?></p>


                    <?php if(check_login($dbh) && $_SESSION["user_id"] != $user["id"]): ?>
                      <?php if(user_following($_SESSION["user_id"], $user["id"], $dbh)): ?>
                        <div>
                          <button class="btn-sm btn-outline-primary mx-0"><b>Following</b></button>
                        </div>
                      <?php else: ?>
                        <div>
                          <a href=<?php echo("/users/follow.php?user=" . $user["id"]); ?> class="btn btn-sm btn-primary mx-0"><b>Follow</b></a>
                        </div>
                      <?php endif; ?>
                    <?php endif; ?>

          </div> <!-- End Col 2 -->

          
        </div> <!-- End First Row -->
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
