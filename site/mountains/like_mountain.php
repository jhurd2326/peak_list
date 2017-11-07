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
    if(!user_mountain_rating($mountain_id, $user_id, $dbh))
    {
      $sql = "INSERT INTO mountain_ratings (user_id, mountain_id, created_at) VALUES (?, ?, ?)";

      if($query = $dbh -> prepare($sql))
      {
        $query -> bindValue(1, $user_id);
        $query -> bindValue(2, $mountain_id);
        $query -> bindValue(3, date("Y-m-d H:i:s", time()));
        $query -> execute();
      }
    }
  }
  header("Location: show.php?id=" . $mountain_id);
?>
