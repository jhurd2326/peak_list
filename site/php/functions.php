<?php
  session_start();

  /*** Checks the login attempt against the database ***/
  function login($username, $password, $mysqli)
  {
    $sql = "SELECT id, username, password_hash FROM users WHERE username = ? LIMIT 1";
    if($query = $mysqli -> prepare($sql))
    {
      $query -> bind_param("s", $username);
      $query -> execute();
      $query -> store_result();

      $query -> bind_result($user_id, $db_username, $db_password);
      $query -> fetch();

      if($query -> num_rows == 1)
      {
        if(password_verify($password, $db_password))
        {
          $user_id = preg_replace("/[^0-9]/", "", $user_id);
          $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);

          $_SESSION["user_id"] = $user_id;
          $_SESSION["username"] = $db_username;
          $_SESSION["login_hash"] = hash("sha512", $db_password);
          return true;
        }
        else { return false; }
      }
      else { return false; }
    }
    else { return false; }
  }

  /*** Check if a user is logged in ***/
  function check_login($mysqli)
  {
    if(isset($_SESSION["user_id"], $_SESSION["username"], $_SESSION["login_hash"]))
    {
      $user_id = $_SESSION["user_id"];
      $username = $_SESSION["username"];
      $login_hash = $_SESSION["login_hash"];

      $sql = "SELECT password_hash FROM users WHERE id = ? LIMIT 1";
      if($query = $mysqli -> prepare($sql))
      {
        $query -> bind_param("i", $user_id);
        $query -> execute();
        $query -> store_result();

        if($query -> num_rows == 1)
        {
          $query -> bind_result($password);
          $query -> fetch();
          $login_check = hash("sha512", $password);

          if(hash_equals($login_check, $login_hash)) { return true; }
          else { return false; }
        }
        else { return false; }
      }
      else { return false; }
    }
    else { return false; }
  }

  function register($username, $password, $mysqli)
  {
    $error_msg = "";
    $sql = "SELECT id FROM users where username = ? LIMIT 1";
    if($query = $mysqli -> prepare($sql))
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
        return true;
      }
      else { return false; }
    }
    else
    {
      echo $error_msg;
      return false;
    }
  }
?>
