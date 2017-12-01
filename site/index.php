<?php
  include_once "php/db_connect.php";
  include_once "php/functions.php";
?>

<!DOCTYPE html>
<html>
  <head>
    <title>
      <?php
        if(!check_login($dbh))
          echo "Login | RangeFinder";
        else
          echo "Home | RangeFinder";
      ?>
    </title>
    <link rel="icon" href="myfavicon.ico"/>
    <link rel="stylesheet" href="stylesheets/custom.css" />
    <link rel="stylesheet" href="stylesheets/hover.css" />
    <link rel="stylesheet" href="stylesheets/font-awesome.css" />

    <meta name="google" content="notranslate" />

    <script src="javascripts/jquery-3.2.1.min.js"></script>
      <script>
      $.get("navigation.php", function(data){
          $("#nav-placeholder").replaceWith(data);
      });
    </script>

    <script src="javascripts/jquery-3.2.1.min.js"></script>
      <script>
      $.get("footer.php", function(data){
          $("#foot-placeholder").replaceWith(data);
      });
    </script>

    <script>
        document.onkeydown=function(evt){
            var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
            if(keyCode == 13)
            {
              login_check(login_form, login_form.username, login_form.password);
            }
        }
    </script>

  </head>
  <body>

    <div id= "nav-placeholder"></div>
    <div class="background animated fadeIn">
      <div class="container h-100">
        <?php if(check_login($dbh) == false): ?>
          <div class="row flex-center">
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="animated fadeIn">
                  <?php
                    if(isset($_GET["error"]))
                    {
                      echo "<p class='error' style='color: red;'>There was an error logging you in.<br> Please check your username and password.<br></p>";
                    }
                  ?>
                  <form action="php/process_login.php" method="post" name="login_form" id="login_form">
                    <div class="md-form">
                      <input type="text" name="username" id="username" class="form-control" />
                      <label for="username">Username</label>
                    </div>
                    <div class="md-form">
                      <input type="password" name="password" id="password" class="form-control" />
                      <label for="password">Password</label>
                    </div>
                    <div class="text-center my-3">
                      <input type="button" value="Login" onclick="login_check(this.form,this.form.username, this.form.password);" class="btn btn-primary"/>
                    </div>
                  </form>

                  <p class="text-center my-3">
                    Don't have an account?
                    <a href='register.php'class="custom-link hvr-grow mx-2">Register</a>
                  </p>
                </div>
            </div>
          </div>
        </div>
        <?php else: ?>
        <div class ="background2">
            <div class="container h-100">
              <div class = "d-flex row flex-center">
                <div class = "col-12 text-center mt-5 animated slideInUp">
                  <form action="mountains/search.php" method="get">
                    <input type="submit" value="Search Mountain Database" onclick="mountains/search.php" class="btn btn-primary mt-5"/>
                  </form>
                </div>
              </div>
            </div>
        </div>
        <?php endif; ?>
      </div>

      <div id= "foot-placeholder"></div>



    <script type="text/JavaScript" src="javascripts/jquery-3.2.1.min.js"></script>
    <script type="text/JavaScript" src="javascripts/sha512.js"></script>
    <script type="text/JavaScript" src="javascripts/forms.js"></script>
    <script type="text/JavaScript" src="javascripts/popper.min.js"></script>
    <script type="text/JavaScript" src="javascripts/bootstrap.min.js"></script>
    <script type="text/JavaScript" src="javascripts/mdb.min.js"></script>
  </body>
</html>
