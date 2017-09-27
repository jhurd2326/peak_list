<?php
  include_once "php/functions.php";
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Register</title>
    <script type="text/JavaScript" src="javascripts/sha512.js"></script>
    <script type="text/JavaScript" src="javascripts/forms.js"></script>
  </head>
  <body>
    <h1>Register</h1>
    <?php
      if(!empty($error_msg)) { echo $error_msg; }
    ?>
    <ul>
      <li>Usernames may contain only digits, upper and lowercase letters and underscores</li>
      <li>Emails must have a valid email format</li>
      <li>Passwords must be at least 6 characters long</li>
      <li>Passwords must contain
          <ul>
              <li>At least one uppercase letter (A..Z)</li>
              <li>At least one lowercase letter (a..z)</li>
              <li>At least one number (0..9)</li>
          </ul>
      </li>
      <li>Your password and confirmation must match exactly</li>
    </ul>
    <form action="php/process_registration.php" method="post" name="registration_form">
      Username: <input type="text" name="username" id="username" /><br>
      Password: <input type="password" name="password" id="password"/><br>
      Confirm password: <input type="password" name="confirmation" id="confirmation" /><br>
      <input type="button" value="Register" onclick="regformhash(this.form, this.form.username, this.form.password, this.form.confirmation);" />
    </form>
    <p>Return to the <a href="index.php">login page</a>.</p>
  </body>
</html>
