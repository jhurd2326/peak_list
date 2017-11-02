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

    $attributes = array(":name", ":state", ":country", ":latitude", ":longitude",
                        ":max_elevation", "min_elevation");

    $query_options = array(" name like :name and", " state = :state and", " country = :country and",
                           " latitude like :latitude and", " longitude like :longitude and",
                           " elevation <= :max_elevation and", " elevation >= :min_elevation and");

    if(!empty($params[0]))
      $params[0] = "%" . $params[0] . "%";

    if(!empty($params[3]))
      $params[3] .= "%";

    if(!empty($params[4]))
      $params[4] .= "%";

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
      else
        return array();
    }
    else { return array(); }
  }

  /*** Find mountain based on id ***/
  function find_mountain($id, $dbh)
  {
    $sql = "SELECT * FROM mountains where id = :id LIMIT 1";
    if($query = $dbh -> prepare($sql))
    {
      $query -> bindValue(":id", $id);
      if($query -> execute())
      {
        if ($query -> rowCount() == 1)
          return $query -> fetch();
        else
          return array();
      }
      else { return array(); }
    }
    else { return array(); }
  }

  /*** Return the number of likes that a mountain has ***/
  function find_mountain_likes($id, $dbh)
  {
    $sql = "SELECT COUNT(*) FROM mountain_ratings WHERE mountain_id = :id";
    if($query = $dbh -> prepare($sql))
    {
      $query -> bindValue(":id", $id);
      if($query -> execute())
      {
        $result = $query -> fetch();
        return $result[0];
      }
      else
        return 0;
    }
    else { return 0; }
  }

  /*** Find user based on id ***/
  function find_user($id, $dbh)
  {
    $sql = "SELECT * FROM users where id = :id LIMIT 1";
    if($query = $dbh -> prepare($sql))
    {
      $query -> bindValue(":id", $id);
      if($query -> execute())
      {
        if($query -> rowCount() == 1)
          return $query -> fetch();
        else
          return array();
      }
      else { return array(); }
    }
    else { return array(); }
  }

  /*** Get an array of all of the comments linked to a mountain ***/
  function find_mountain_comments($id, $dbh)
  {
    $sql = "SELECT * FROM comments INNER JOIN users ON comments.user_id = users.id WHERE mountain_id = :id ORDER BY created_at DESC";
    if($query = $dbh -> prepare($sql))
    {
      $query -> bindValue(":id", $id);
      if($query -> execute())
      {
        if($query -> rowCount() > 0)
          return $query -> fetchAll();
        else
          return array();
      }
      else { return array(); }
    }
    else { return array(); }
  }

  /*** Returns an array of all the comments left by a user for a specified mountain ***/
  function user_mountain_rating($mountain_id, $user_id, $dbh)
  {
    $sql = "SELECT * FROM mountain_ratings WHERE mountain_id = :mountain_id AND user_id = :user_id";
    if($query = $dbh -> prepare($sql))
    {
      $query -> bindValue(":mountain_id", $mountain_id);
      $query -> bindValue(":user_id", $user_id);
      if($query -> execute())
      {
        if($query -> rowCount() > 0)
          return true;
        else
          return false;
      }
      else { return false; }
    }
    else { return false; }
  }

  /*** Display the pagination links for the given array, page number, and limit ***/
  function display_pagination($arr, $page_number, $limit)
  {
    $total_count = count($arr);
    $total_pages = ceil($total_count / $limit);
    $link_count = 5;

    // Button for going to previous page
    $prev_page = str_replace(("page=" . $page_number), ("page=" . ($page_number-1)), $_SERVER["REQUEST_URI"]);
    if($page_number > 1)
      echo ("<a class='btn btn-sm px-2 btn-default' href='" . $prev_page . "'><b> << </b></a>");
    else
      echo ("<a class='btn btn-sm px-2 btn-default disabled'><b> << </b></a>");

    // Set the starting value for the loop
    $loop_start = ((ceil($page_number / $link_count) - 1) * $link_count) + 1;

    // Set the ending value for the loop
    $loop_end = $loop_start + $link_count - 1;
    if($loop_end > $total_pages)
      $loop_end = $total_pages;

    // Display the link to go back to page one
    if($loop_start > $link_count)
    {
      $uri = str_replace(("page=" . $page_number), "page=1", $_SERVER["REQUEST_URI"]);
      echo ("<a class='mx-2'style='color: #2BBBAD;' href='" . $uri . "'><b>1</b></a>");
      echo "<span style='color: #2BBBAD;'>...</span>";
    }

    // Loop and create links to the specified pages
    for($i = $loop_start; $i <= $loop_end; $i++)
    {
      $uri = str_replace(("page=" . $page_number), ("page=" . ($i)), $_SERVER["REQUEST_URI"]);
      if($i == $page_number)
        echo ("<a class='mx-2' style='color: #2BBBAD; text-decoration: underline;' href='" . $uri . "'><b>" . $i . "</b></a>");
      else
        echo ("<a class='mx-2'style='color: #2BBBAD;' href='" . $uri . "'><b>" . $i . "</b></a>");
    }

    // Display link to go to the last page
    if($loop_end != $total_pages)
    {
      $uri = str_replace(("page=" . $page_number), ("page=" . $total_pages), $_SERVER["REQUEST_URI"]);
      echo "<span style='color: #2BBBAD;'>...</span>";
      echo ("<a class='mx-2'style='color: #2BBBAD;' href='" . $uri . "'><b>" . $total_pages . "</b></a>");
    }

    // Button for going to the next page
    $next_page = str_replace(("page=" . $page_number), ("page=" . ($page_number+1)), $_SERVER["REQUEST_URI"]);
    if(($page_number * $limit) <= $total_count)
      echo ("<a class='btn btn-sm px-2 btn-default' href='" . $next_page . "'><b> >> </b></a>");
    else
      echo ("<a class='btn btn-sm px-2 btn-default disabled'><b> >> </b></a>");
  }


  /*** Display a Google Map showing the given coordinates using Google Maps API ***/
  function display_google_map($latitude, $longitude)
  {
    if($key = file_get_contents("../api_keys/google_maps_key.txt"))
    {
      echo ("<iframe class='google_map' frameborder='0' style='border:0' ");
      echo ("src='https://www.google.com/maps/embed/v1/place?key=" . $key);
      echo ("&zoom=12&q=" . $latitude . "," . $longitude . "' allowfullscreen> ");
      echo ("</iframe>");
    }
    else { echo "Google API Key Not Found"; }
  }

  /*** Returns a string of elapsed time in 'time ago ' format ***/
  function time_elapsed_string($datetime, $full = false)
  {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array('y' => 'year', 'm' => 'month', 'w' => 'week', 'd' => 'day',
                    'h' => 'hour', 'i' => 'minute', 's' => 'second');

    foreach ($string as $k => &$v) {
      if ($diff->$k)
        $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
      else
        unset($string[$k]);
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
  }
?>
