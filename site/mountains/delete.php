<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";

  if(isset($_GET["id"]))
    $mountain = find_mountain($_GET["id"], $dbh);
  else
    header("Location: search.php");

  if(check_login($dbh) && check_admin($_SESSION["user_id"], $dbh))
  {
    $sql = "DELETE FROM comments WHERE mountain_id = :id;
            DELETE FROM mountain_ratings WHERE mountain_id = :id;
            DELETE FROM mountain_users WHERE mountain_id = :id;
            DELETE FROM mountains WHERE id = :id";

    if($query = $dbh -> prepare($sql))
    {
      $query -> bindValue(":id", $mountain["id"]);
      if($query -> execute())
        header("Location: search.php");
      else
        echo "Error deleting mountain";
    }
    else { echo "Error deleting mountain"; }
  }
  else { echo "Error: Cannot Delete Mountain, Permission Denied"; }
?>
