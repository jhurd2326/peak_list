<?php
  include_once "db_connect.php";

  $error_msg = "";

  if(isset($_POST["username"], $_POST["p"]))
  {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "p", FILTER_SANITIZE_STRING);

    $sql = "SELECT id FROM users where username = ? LIMIT 1";
    $query = $mysqli -> prepare($sql);

    if($query)
    {
      $query -> bind_param("s", $username);
      $query -> execute();
      $query -> store_result();

      if($query -> num_rows ==1)
      {
        $error_msg .= "<p class='error'>A user with this username already exists.</p>";
        $query -> close();
      }
    }
    else
    {
      $error_msg .= "<p class='error'>Database error.</p>";
      $query -> close();
    }

    if(empty($error_msg))
    {
      $password = password_hash($password, PASSWORD_DEFAULT);
      $sql = "INSERT INTO users (username, password_hash) VALUES (?, ?)";
      if($stmt = $mysqli -> prepare($sql))
      {
        $stmt -> bind_param("ss", $username, $password);
        $stmt -> execute();
        $stmt -> close();
      }
      header("Location: ../register_success.php");
    }
  }
?>
