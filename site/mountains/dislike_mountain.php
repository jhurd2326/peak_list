<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";

  if(isset($_GET["id"]) && check_login($dbh))
  {
    $mountain_id = $_GET["id"];
    $user_id = $_SESSION["user_id"];
    $ratings = find_user_mountain_ratings($mountain_id, $user_id, $dbh);

    if(!empty($ratings))
      delete_user_mountain_ratings($mountain_id, $user_id, $dbh);

    $sql = "INSERT INTO mountain_ratings (user_id, mountain_id, rating) VALUES (?, ?, ?)";

    if($query = $dbh -> prepare($sql))
    {
      $query -> bindValue(1, $user_id);
      $query -> bindValue(2, $mountain_id);
      $query -> bindValue(3, -100);
      $query -> execute();
    }

    header("Location: show.php?id=" . $mountain_id);
  }
  else { echo "Could not like mountain"; }
?>
