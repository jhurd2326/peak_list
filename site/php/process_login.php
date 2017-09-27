<?php
  include_once "db_connect.php";
  include_once "functions.php";

  if(isset($_POST["username"], $_POST["p"]))
  {
    $username = $_POST["username"];
    $password = $_POST["p"];

    if(login($username, $password, $mysqli) == true)
    {
      header("Location: ../index.php");
    }
    else
    {
      header("Location: ../index.php?error=1");
    }
  }
  else { echo "Invalid Request"; }
?>
