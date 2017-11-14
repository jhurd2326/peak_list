<?php
  include_once "php/db_connect.php";
  include_once "php/functions.php";
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>

    <link rel="stylesheet" href="stylesheets/custom.css" />
    <link rel="stylesheet" href="stylesheets/hover.css" />

  </head>
  <body>
    <div class="background">
      <div class="container h-100">
        <?php
          if(isset($_GET["error"]))
          {
            echo "<p class='error'>Error Logging In</p>";
          }
        ?>
        <?php if(check_login($dbh) == false): ?>
          <div class="row flex-center">
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
              <div class="card animated fadeIn">
                <div class="card-header text-center">
                  <h2 class="h2-responsive" style="color: white;">Sign-In</h2>
                </div>
                <div class="card-body" style="background-color: white;">
                  <form action="php/process_login.php" method="post" name="login_form">
                    <div class="md-form">
                      <input type="text" name="username" id="username" class="form-control" />
                      <label for="username">Username</label>
                    </div>
                    <div class="md-form">
                      <input type="password" name="password" id="password" class="form-control" />
                      <label for="password">Password</label>
                    </div>
                    <div class="text-center my-3">
                      <input type="button" value="Login" onclick="formhash(this.form, this.form.password);" class="btn light-blue lighten-1"/>
                    </div>
                  </form>

                  <p class="text-center my-3">
                    Don't have an account?
                    <a href='register.php'class="custom-link hvr-grow hvr-underline-reveal mx-2">Register</a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        <?php else: ?>
          <a href="php/logout.php" class="btn btn-default">Logout</a>
        <?php endif; ?>
      </div>
    </div>

    <script type="text/JavaScript" src="javascripts/jquery-3.2.1.min.js"></script>
    <script type="text/JavaScript" src="javascripts/sha512.js"></script>
    <script type="text/JavaScript" src="javascripts/forms.js"></script>
    <script type="text/JavaScript" src="javascripts/popper.min.js"></script>
    <script type="text/JavaScript" src="javascripts/bootstrap.min.js"></script>
    <script type="text/JavaScript" src="javascripts/mdb.min.js"></script>
  </body>
</html>
