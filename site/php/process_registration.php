<?php
  include_once "db_connect.php";
  include_once "functions.php";

  session_start();

  if(isset($_POST["username"], $_POST["p"]))
  {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "p", FILTER_SANITIZE_STRING);

    if(register($username, $password, $mysqli) == true)
    {
      login($username, $password, $mysqli);
      header("Location: ../protected_page.php");
    }
    else
    {
      header("Location: ../register.php?error=1");
    }
  }
  else { echo "Invalid Request"; }
?>
