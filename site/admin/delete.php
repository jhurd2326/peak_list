<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";

  if(isset($_GET["file"]))
    $file = $_GET["file"];
  else
    header("Location: backup.php");

  if( check_login($dbh) && check_admin($_SESSION["user_id"], $dbh) )
  {
    $command = "rm ../backups/" . $file;
    exec($command);

    header("Location: backup.php");
  }
  else { echo "Error: Permission Denied"; }
?>
