<?php
  include_once "php/functions.php";
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link rel="stylesheet" href="stylesheets/custom.css"  />
  </head>
  <body>
    <div class="background">
      <div class="container h-100">
        <?php if(!empty($error_msg)) { echo $error_msg; } ?>
        <div class="row flex-center">
          <div class="col-12 col-lg-4">
            <div class="card animated fadeIn">
              <div class="card-header default-color text-center">
                <h2 class="h2-responsive" style="color: white;">Register</h2>
              </div>
              <div class="card-body-register card-body">
                <form action="php/process_registration.php" method="post" name="registration_form">
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
                    <input type="button" value="Register" class="btn btn-default"
                      onclick="regformhash(this.form, this.form.username, this.form.password,
                               this.form.confirmation, this.form.email, this.form.first_name,
                               this.form.last_name, this.form.age, this.form.phone, this.form.address);" />
                  </div>
                </form>
                <p class="text-center my-3">
                  Return to the
                  <a href="index.php" style="color: #2BBBAD;">login page</a>
                </p>
              </div>
            </div>
          </div>
        </div>
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
