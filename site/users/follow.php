<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";

  if(isset($_GET["user"]))
    $user_id = $_GET["user"];
  else
    header("Location: index.php");

  if(check_login($dbh))
  {
    $signed_in_id = $_SESSION["user_id"];
    if(!user_following($signed_in_id, $user_id, $dbh) && $signed_in_id != $user_id)
    {
      $sql = "INSERT INTO relationships (follower_id, followed_id, created_at) VALUES (?, ?, ?)";
      if($query = $dbh -> prepare($sql))
      {
        $query -> bindValue(1, $signed_in_id);
        $query -> bindValue(2, $user_id);
        $query -> bindValue(3, date("Y-m-d H:i:s", time()));
        $query -> execute();
      }
    }
  }
  header("Location: " . $_SERVER['HTTP_REFERER']);
?>
