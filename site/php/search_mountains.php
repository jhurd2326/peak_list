<?php
  include_once "db_connect.php";
  include_once "functions.php";

  session_start();

  $mountains = search_mountains(array($_POST["name"], $_POST["state"], $_POST["country"],
    $_POST["latitude"], $_POST["longitude"], $_POST["elevation"]), $dbh);


  foreach($mountains as $mountain)
    print_r($mountain);
?>
