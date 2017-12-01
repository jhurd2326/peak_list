<?php
  include_once "php/functions.php";
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | RangeFinder</title>
    <link rel="stylesheet" href="stylesheets/custom.css"  />
    <link rel="icon" href="myfavicon.ico"/>
    <link rel="stylesheet" href="stylesheets/font-awesome.css" />

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
              regformhash(registration_form,            registration_form.username,
                          registration_form.password,   registration_form.confirmation,
                          registration_form.email,      registration_form.first_name,
                          registration_form.last_name,  registration_form.age,
                          registration_form.phone,      registration_form.address);
            }
        }
    </script>
  </head>
  <body>
    <div id="nav-placeholder"></div>
    <div class ="background-white">
      <div class="container py-5">
        <?php if(!empty($error_msg)) { echo $error_msg; } ?>
        <div class="row mt-5">
          <div class="col-8  animated slideInUp">
                <h2 class="h2-responsive text-center" style="color: Black;">Register</h2>
              <div class="card-body-register">
                <form action="php/process_registration.php" method="post" name="registration_form" id="registration_form">
                  <div class="md-form">
                    <input type="text" name="email" id="email" />
                    <label for="email">Email</label>
                  </div>
                  <div class="md-form">
                    <input type="text" name="username" id="username" />
                    <label for="username">Username</label>
                    <p class="mt-1 inline-form-text">Digits, Letters, and Underscores Only</p>
                  </div>
                  <div class="md-form">
                    <input type="password" name="password" id="password"/>
                    <label for="password">Password</label>
                    <p class="mt-1 inline-form-text">At least 6 characters in length</p>
                  </div>
                  <div class="md-form">
                    <input type="password" name="confirmation" id="confirmation" />
                    <label for="confirmation">Password Confirmation</label>
                    <p class="mt-1 inline-form-text">Must match password exactly</p>
                  </div>
                  <div class="md-form">
                    <input type="text" name="first_name" id="first_name" />
                    <label for="first_name">First Name</label>
                  </div>
                  <div class="md-form">
                    <input type="text" name="last_name" id="last_name" />
                    <label for="last_name">Last Name</label>
                  </div>
                  <div class="md-form">
                    <input type="number" name="age" id="age" />
                    <label for="age">Age</label>
                  </div>
                  <div class="md-form">
                    <input type="text" name="phone" id="phone" />
                    <label for="phone">Telephone</lable>
                  </div>
                  <div class="md-form">
                    <input type="text" name="address" id="address" />
                    <label for="address">Address</label>
                  </div>

                  <div class="text-center my-3">
                    <input type="button" value="Register" class="btn btn-primary"
                      onclick="regformhash(this.form, this.form.username, this.form.password,
                               this.form.confirmation, this.form.email, this.form.first_name,
                               this.form.last_name, this.form.age, this.form.phone, this.form.address);" />
                  </div>
                </form>
                <p class="text-center my-3">
                  Return to the
                  <a href="index.php" class="custom-link">login page</a>
                </p>
              </div>
          </div>
          <div class = "col animated slideInRight">
          <div class="card">
            <h4 class="card-header primary-color white-text text-center"><b>Why Register?</b></h4>
            <div class="card-body">
              <p class="card-text">
              Follow your friends to display them on your dashboard!
              This also will let you leave comments on mountains for others to see!
            </p>
            <a class="custom-link" href="about.php"><br><br>Want to learn more about our site?<br></a>

            </div>
          </div>
        </div>

        </div>
      </div>

      <div id="foot-placeholder"></div>
    </div>

    <script type="text/JavaScript" src="javascripts/jquery-3.2.1.min.js"></script>
    <script type="text/JavaScript" src="javascripts/sha512.js"></script>
    <script type="text/JavaScript" src="javascripts/forms.js"></script>
    <script type="text/JavaScript" src="javascripts/popper.min.js"></script>
    <script type="text/JavaScript" src="javascripts/bootstrap.min.js"></script>
    <script type="text/JavaScript" src="javascripts/mdb.min.js"></script>
  </body>
</html>
