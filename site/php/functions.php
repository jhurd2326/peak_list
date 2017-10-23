<?php
  session_start();

  /*** Checks the login attempt against the database ***/
  function login($username, $password, $dbh)
  {
    $sql = "SELECT id, username, password_hash FROM users WHERE username = :username LIMIT 1";
    if($query = $dbh -> prepare($sql))
    {
      $query -> bindValue(":username", $username);
      $query -> execute();

      if($query -> rowCount() == 1)
      {
        $user = $query -> fetch();
        $user_id = $user["id"];
        $db_username = $user["username"];
        $db_password = $user["password_hash"];

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
  function check_login($dbh)
  {
    if(isset($_SESSION["user_id"], $_SESSION["username"], $_SESSION["login_hash"]))
    {
      $user_id = $_SESSION["user_id"];
      $username = $_SESSION["username"];
      $login_hash = $_SESSION["login_hash"];

      $sql = "SELECT password_hash FROM users WHERE id = :id LIMIT 1";
      if($query = $dbh -> prepare($sql))
      {
        $query -> bindValue(":id", $user_id);
        $query -> execute();

        if($query -> rowCount() == 1)
        {
          $user = $query -> fetch();
          $password = $user["password_hash"];
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

  /*** Register a user ***/
  function register($username, $password, $email, $first_name, $last_name,
    $age, $phone, $address, $dbh)
  {
    $error_msg = "";
    $sql = "SELECT id FROM users where username = :username LIMIT 1";
    if($query = $dbh -> prepare($sql))
    {
      $query -> bindValue(":username", $username);
      $query -> execute();

      if($query -> rowCount() > 0)
        $error_msg .= "<p class='error'>A user with this username already exists.</p>";
    }
    else
    {
      $error_msg .= "<p class='error'>Database error.</p>";
    }

    if(empty($error_msg))
    {
      $password = password_hash($password, PASSWORD_DEFAULT);
      $sql = "INSERT INTO users (username, password_hash, first_name, last_name,
              age, telephone, email, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

      if($stmt = $dbh -> prepare($sql))
      {
        $stmt -> bindValue(1, $username);
        $stmt -> bindValue(2, $password);
        $stmt -> bindValue(3, $first_name);
        $stmt -> bindValue(4, $last_name);
        $stmt -> bindValue(5, $age);
        $stmt -> bindValue(6, $phone);
        $stmt -> bindValue(7, $email);
        $stmt -> bindValue(8, $address);
        $stmt -> execute();
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

  /*** Search the database of mountains given search parameters ***/
  function search_mountains($params, $dbh)
  {
    $sql = "SELECT * FROM mountains where";

    $attributes = array(":name", ":state", ":country", ":latitude", ":longitude", ":elevation");

    $query_options = array(" name = :name and", " state = :state and", " country = :country and",
                           " latitude = :latitude and", " longitude = :longitude and",
                           " elevation = :elevation and");

    foreach($params as $key => $param)
      if(!empty($param))
        $sql .= $query_options[$key];

    $stmt = rtrim($sql, "and");
    if($sql == $stmt) return array();

    if($query = $dbh -> prepare($stmt))
    {
      foreach($params as $key => $param)
        if(!empty($param))
          $query -> bindValue($attributes[$key], $param);

      if($query -> execute())
        return $query -> fetchAll();
    }
    else { return array(); }
  }
?>
