<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";

  if(isset($_GET["id"]))
    $user = find_user($_GET["id"], $dbh);
  else
    header("Location: search.php");

  if(check_login($dbh) && check_admin($_SESSION["user_id"], $dbh))
  {
    $sql = "DELETE FROM comments WHERE user_id = :id;
            DELETE FROM mountain_ratings WHERE user_id = :id;
            DELETE FROM mountain_users WHERE user_id = :id;
            DELETE FROM relationships WHERE follower_id = :id OR followed_id = :id;
            DELETE FROM users WHERE id = :id";

    if($query = $dbh -> prepare($sql))
    {
      $query -> bindValue(":id", $user["id"]);
      if($query -> execute())
        header("Location: search.php");
      else
        echo "Error deleting user";
    }
    else { echo "Error deleting user"; }
  }
  else { echo "Error: Cannot Delete User, Permission Denied"; }
?>
