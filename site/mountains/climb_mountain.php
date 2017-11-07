<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";

  if(isset($_GET["id"]))
    $mountain_id = $_GET["id"];
  else
    header("Location: results.php?page=1");

  if(check_login($dbh))
  {
    $user_id = $_SESSION["user_id"];
    if(!mountain_user($mountain_id, $user_id, $dbh))
    {
      $sql = "INSERT INTO mountain_users (user_id, mountain_id) VALUES (?, ?)";

      if($query = $dbh -> prepare($sql))
      {
        $query -> bindValue(1, $user_id);
        $query -> bindValue(2, $mountain_id);
        $query -> execute();
      }
    }
  }
  header("Location: show.php?id=" . $mountain_id);
?>
