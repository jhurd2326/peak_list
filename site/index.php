<?php
  include_once "php/db_connect.php";
  include_once "php/functions.php";

  session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
    <script type="text/JavaScript" src="javascripts/sha512.js"></script>
    <script type="text/JavaScript" src="javascripts/forms.js"></script>
  </head>
  <body>
    <?php
      if(isset($_GET["error"]))
      {
        echo "<p class='error'>Error Logging In</p>";
      }
    ?>
    <form action="php/process_login.php" method="post" name="login_form">
      Username: <input type="text" name="username" id="username" />
      Password: <input type="password" name="password" id="password" />
      <input type="button" value="Login" onclick="formhash(this.form, this.form.password);" />
    </form>
    <a href="php/logout.php">Logout</a>
    <?php
      if(check_login($mysqli) == true)
      {
        echo "<p>Currently logged in as " . htmlentities($_SESSION['username']) . ".</p>";
      }
      else
      {
        echo "<p>Currently logged out</p>";
        echo "<p><a href='register.php'>Register</a></p>";
      }
    ?>
  </body>
</html>
