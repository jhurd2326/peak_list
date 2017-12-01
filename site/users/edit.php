<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";

  $user = array();
  if(isset($_GET["id"]))
    $user = find_user($_GET["id"], $dbh);
  else
    $user = array();
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

    <title><?php echo $user["username"], " | RangeFinder"; ?></title>

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
        <div class="row flex-center">
          <div class="col-6 text-left">
            <h2 class="h2-responsive mb-4" style="color: Black;">
              <strong>
                <?php if(empty($user)): ?>
                  Error
                <?php elseif(check_login($dbh) && ($_SESSION["user_id"] == $user["id"] || check_admin($_SESSION["user_id"], $dbh)) ): ?>
                  <?php echo $user["first_name"] . " " . $user["last_name"]; ?>
                <?php else: ?>
                  Error
                <?php endif; ?>
              </strong>
            </h2>
            <hr>

            <!--  user Information  -->
            <?php if(empty($user)): ?>
              <h4 class="h4-responsive mb-4">No User</h4>
            <?php elseif(check_login($dbh) && ($_SESSION["user_id"] == $user["id"] || check_admin($_SESSION["user_id"], $dbh)) ): ?>
              <form action=<?php echo "update.php?id=" . $user["id"]; ?> method="post" name="user_edit_form" id="user_edit_form">
                <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="md-form">
                      <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $user["first_name"]; ?>">
                      <label for="first_name">First Name</label>
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="md-form">
                      <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $user["last_name"]; ?>">
                      <label for="last_name">Last Name</label>
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="md-form">
                      <input type="text" name="email" id="email" class="form-control" value="<?php echo $user["email"]; ?>">
                      <label for="email">Email</label>
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="md-form">
                      <input type="number" name="age" id="age" class="form-control" value="<?php echo $user["age"]; ?>">
                      <label for="age">Age</label>
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="md-form">
                      <input type="text" name="phone" id="phone" class="form-control" value="<?php echo $user["telephone"]; ?>">
                      <label for="phone">Telephone</label>
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="md-form">
                      <input type="text" name="address" id="address" class="form-control" value="<?php echo $user["address"]; ?>">
                      <label for="address">Address</label>
                    </div>
                  </div>
                </div>

                <div class="text-center my-3">
                  <a class="btn btn-primary" onclick="user_edit_form.submit();">
                    <i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>
                    Save
                  </a>
                </div>

              </form>
            <?php else: ?>
              <h4 class="h4-responsive mb-4">You are not authorized to view this page</h4>
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
