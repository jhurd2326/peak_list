<?php
  include_once "db_config.php";

  /*** Create a secure php session ***/
  function sec_session_start()
  {
    $session_name = "sec_session_id";
    $secure = SECURE;
    $httponly = true;
    if(ini_set("session.use_only_cookies", 1) === FALSE) {
      header("Location: ../error.php?error=Could not initiate a safe session (ini_set)");
      exit();
    }
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"],
      $cookieParams["domain"], $secure, $httponly);
    session_name($session_name);
    session_start();
    session_regenerate_id();
  }

  /*** Checks the login attempt against the database ***/
  function login($username, $password, $mysqli)
  {
    $sql = "SELECT id, username, password_hash FROM users WHERE username = ? LIMIT 1";
    if($query = $mysqli -> prepare($sql))
    {
      $query -> bind_param("s", $username);
      $query -> execute();
      $query -> store_result();

      // Store results from query
      $query -> bind_result($user_id, $db_username, $db_password);
      $query -> fetch();

      if($query -> num_rows == 1)
      {
        if(password_verify($password, $db_password))
        {
          // Prevent Cross-Site Scripting Attack
          $user_id = preg_replace("/[^0-9]/", "", $user_id);
          $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);

          $_SESSION["user_id"] = $user_id;
          $_SESSION["username"] = $username;
          $_SESSION["login_hash"] = hash("sha512", $db_password . $_SERVER["HTTP_USER_AGENT"]);
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

      $sql = "SELECT password FROM users WHERE id = ? LIMIT 1";
      if($query = $mysqli -> prepare($sql))
      {
        $query -> bind_param("i", $user_id);
        $query -> execute();
        $query -> store_result();

        if($query -> num_rows == 1)
        {
          $query -> bind_result($password);
          $query -> fetch();
          $login_check = hash("sha512", $password, $_SERVER["HTTP_USER_AGENT"]);

          if(hash_equals($login_check, $login_hash)) { return true; }
          else { return false; }
        }
        else { return false; }
      }
      else { return false; }
    }
    else { return false; }
  }

  function esc_url($url) {

    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;

    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }

    $url = str_replace(';//', '://', $url);

    $url = htmlentities($url);

    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        return '';
    } else {
        return $url;
    }
  }
?>
