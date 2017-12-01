<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";

  if(isset($_GET["user"]))
    $user_id = $_GET["user"];
  else
    header("Location: ../index.php");

  if(check_login($dbh))
  {
    $signed_in_id = $_SESSION["user_id"];
    if(user_following($signed_in_id, $user_id, $dbh) && $signed_in_id != $user_id)
    {
      $sql = "DELETE FROM relationships WHERE followed_id = :followed AND follower_id = :follower";
      if($query = $dbh -> prepare($sql))
      {
        $query -> bindValue(":follower", $signed_in_id);
        $query -> bindValue(":followed", $user_id);
        $query -> execute();
      }
    }
  }
  header("Location: " . $_SERVER['HTTP_REFERER']);
?>
