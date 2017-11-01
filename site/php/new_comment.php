<?php
  include_once "db_connect.php";
  include_once "functions.php";

  if(isset($_POST["comment_body"], $_GET["mountain"]) && check_login($dbh))
  {
    $content = htmlspecialchars($_POST["comment_body"]);
    $mountain_id = $_GET["mountain"];
    $user_id = $_SESSION["user_id"];
    $curr_time = date("Y-m-d H:i:s", time());

    $sql = "INSERT INTO comments (content, created_at, updated_at, mountain_id, user_id) VALUES (?, ?, ?, ?, ?)";

    if($query = $dbh -> prepare($sql))
    {
      $query -> bindValue(1, $content);
      $query -> bindValue(2, $curr_time);
      $query -> bindValue(3, $curr_time);
      $query -> bindValue(4, $mountain_id);
      $query -> bindValue(5, $user_id);
      $query -> execute();
    }
    header("Location: ../mountains/show.php?id=" . $mountain_id);
  }
  else { echo "Cannot Create Comment"; }
?>
