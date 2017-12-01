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
        $encrypted_password = hash("sha512", $password);

        if($encrypted_password == $db_password)
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

          if($login_check ==  $login_hash) { return true; }
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
    $sql = "SELECT id FROM users WHERE username = :username LIMIT 1";
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
      $password = hash("sha512", $password);
      $sql = "INSERT INTO users (username, password_hash, first_name, last_name,
              age, telephone, email, address, admin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

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
        $stmt -> bindValue(9, 0);
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
    $sql = "SELECT * FROM mountains WHERE";

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

  /*** Return the mountains in order of most likes ***/
  function find_top_rated_mountains($dbh)
  {
    $sql = "SELECT count(mountains.id), mountains.name, mountains.id FROM mountains
            INNER JOIN mountain_ratings ON mountains.id = mountain_ratings.mountain_id
            GROUP BY (mountains.id) ORDER BY count(mountains.id) DESC;";

    if($query = $dbh -> prepare($sql))
    {
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

  /*** Returns the logged in user's feed ***/
  function user_feed($user_id, $dbh)
  {
    $sql = "SELECT mountains.id AS mountain_id, mountains.name, mountain_users.created_at,
            users.username, users.id AS user_id FROM relationships INNER JOIN mountain_users ON
            relationships.followed_id = mountain_users.user_id INNER JOIN users ON
            relationships.followed_id = users.id INNER JOIN mountains ON
            mountain_users.mountain_id = mountains.id WHERE
            follower_id = :user_id ORDER BY mountain_users.created_at DESC;";

    if($query = $dbh -> prepare($sql))
    {
      $query -> bindValue(":user_id", $user_id);
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

  /*** Returns the users mountain information for show.php***/
  function recent_climbs($user_id, $dbh){
    $sql = "SELECT id, name, created_at FROM mountain_users INNER JOIN mountains
     ON mountain_users.mountain_id = mountains.id WHERE mountain_users.user_id
     = :user_id ORDER BY created_at DESC LIMIT 5";
    if($query = $dbh -> prepare($sql))
    {
      $query -> bindValue(":user_id", $user_id);
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

  /*** Return the mountains in order of most climbs ***/
  function find_most_popular_mountains($dbh)
  {
    $sql = "SELECT count(mountains.id), mountains.name, mountains.id FROM mountains
            INNER JOIN mountain_users ON mountains.id = mountain_users.mountain_id
            GROUP BY (mountains.id) ORDER BY count(mountains.id) DESC;";

    if($query = $dbh -> prepare($sql))
    {
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


  /*** Find mountain based on id ***/
  function find_mountain($id, $dbh)
  {
    $sql = "SELECT * FROM mountains WHERE id = :id LIMIT 1";
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
  function find_mountain_likes_count($id, $dbh)
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

  /*** Return the number of mountains that the user has climbined ***/
  function find_climb_count($user_id, $dbh)
  {
    $sql = "SELECT COUNT(*) FROM mountain_users WHERE user_id = :id";
    if($query = $dbh -> prepare($sql))
    {
      $query -> bindValue(":id", $user_id);
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

  /*** Return the number of mountains that the user has liked ***/
  function find_like_count($user_id, $dbh)
  {
    $sql = "SELECT COUNT(*) FROM mountain_ratings WHERE user_id = :id";
    if($query = $dbh -> prepare($sql))
    {
      $query -> bindValue(":id", $user_id);
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

  /*** Return the number of followers that have followed the user ***/
  function find_follower_count($user_id, $dbh)
  {
    $sql = "SELECT COUNT(*) FROM relationships WHERE followed_id = :id";
    if($query = $dbh -> prepare($sql))
    {
      $query -> bindValue(":id", $user_id);
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

  /*** Return the number of users that the user follows ***/
  function find_following_count($user_id, $dbh)
  {
    $sql = "SELECT COUNT(*) FROM relationships WHERE follower_id = :id";
    if($query = $dbh -> prepare($sql))
    {
      $query -> bindValue(":id", $user_id);
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

  /*** Determines if a user has admin privileges ***/
  function check_admin($id, $dbh)
  {
    $user = find_user($id, $dbh);
    if($user["admin"] == true)
      return true;
    else
      return false;
  }

  /*** Search the database of users based off username and first/last name ***/
  function search_users($name, $dbh)
  {
    $sql = "SELECT * FROM users WHERE username LIKE ? OR first_name
            LIKE ? OR last_name LIKE ?";

    if($query = $dbh -> prepare($sql))
    {
      $query -> bindValue(1, ($name . "%"));
      $query -> bindValue(2, ($name . "%"));
      $query -> bindValue(3, ($name . "%"));
      if($query -> execute())
        return $query -> fetchAll();
      else
        return array();
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

  /*** Returns if a user has liked the mountain or not ***/
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

  /*** Returns an array of mountain_ratings joined with users for a specific mountain ***/
  function find_mountain_ratings($mountain_id, $dbh)
  {
    $sql = "SELECT id, username, created_at FROM mountain_ratings INNER JOIN users ON mountain_ratings.user_id = users.id WHERE mountain_id = :id ORDER BY created_at DESC";
    if($query = $dbh -> prepare($sql))
    {
      $query -> bindValue(":id", $mountain_id);
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

  /*** Returns the number of users who marked the given mountain as climbed ***/
  function find_mountain_users_count($mountain_id, $dbh)
  {
    $sql = "SELECT COUNT(*) FROM mountain_users WHERE mountain_id = :mountain_id";
    if($query = $dbh -> prepare($sql))
    {
      $query -> bindValue(":mountain_id", $mountain_id);
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

  /*** Returns an array of all the users who marked the mountain as climbed ***/
  function find_mountain_users($mountain_id, $dbh)
  {
    $sql = "SELECT id, username, created_at FROM mountain_users INNER JOIN users ON mountain_users.user_id = users.id WHERE mountain_id = :id ORDER BY created_at DESC";
    if($query = $dbh -> prepare($sql))
    {
      $query -> bindValue(":id", $mountain_id);
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

  /*** Returns if the mountain has been marked as climbed by the user ***/
  function mountain_user($mountain_id, $user_id, $dbh)
  {
    $sql = "SELECT * FROM mountain_users WHERE mountain_id = :mountain_id AND user_id = :user_id";
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

  /*** Returns whether the logged in user follows the specified user ***/
  function user_following($signed_in_id, $user_id, $dbh)
  {
    $sql = "SELECT * FROM relationships WHERE follower_id = :follower_id AND followed_id = :followed_id";
    if($query = $dbh -> prepare($sql))
    {
      $query -> bindValue(":follower_id", $signed_in_id);
      $query -> bindValue(":followed_id", $user_id);
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
  function display_pagination($arr, $page_number, $limit, $url)
  {
    $total_count = count($arr);
    $total_pages = ceil($total_count / $limit);
    $link_count = 5;

    // Button for going to previous page
    $prev_page = str_replace(("page=" . $page_number), ("page=" . ($page_number-1)), $url);
    if($page_number > 1)
      echo ("<a class='btn btn-sm px-2 btn-primary' href='" . $prev_page . "'><b> << </b></a>");
    else
      echo ("<a class='btn btn-sm px-2 btn-primary disabled'><b> << </b></a>");

    // Set the starting value for the loop
    $loop_start = ((ceil($page_number / $link_count) - 1) * $link_count) + 1;

    // Set the ending value for the loop
    $loop_end = $loop_start + $link_count - 1;
    if($loop_end > $total_pages)
      $loop_end = $total_pages;

    // Display the link to go back to page one
    if($loop_start > $link_count)
    {
      $uri = str_replace(("page=" . $page_number), "page=1", $url);
      echo ("<a class='mx-2'style='color: #4285F4;' href='" . $uri . "'><b>1</b></a>");
      echo "<span style='color: #4285F4;'>...</span>";
    }

    // Loop and create links to the specified pages
    for($i = $loop_start; $i <= $loop_end; $i++)
    {
      $uri = str_replace(("page=" . $page_number), ("page=" . ($i)), $url);
      if($i == $page_number)
        echo ("<a class='mx-2' style='color: #4285F4; text-decoration: underline;' href='" . $uri . "'><b>" . $i . "</b></a>");
      else
        echo ("<a class='mx-2'style='color: #4285F4;' href='" . $uri . "'><b>" . $i . "</b></a>");
    }

    // Display link to go to the last page
    if($loop_end != $total_pages)
    {
      $uri = str_replace(("page=" . $page_number), ("page=" . $total_pages), $url);
      echo "<span style='color: #4285F4;'>...</span>";
      echo ("<a class='mx-2'style='color: #4285F4;' href='" . $uri . "'><b>" . $total_pages . "</b></a>");
    }

    // Button for going to the next page
    $next_page = str_replace(("page=" . $page_number), ("page=" . ($page_number+1)), $url);
    if(($page_number * $limit) <= $total_count)
      echo ("<a class='btn btn-sm px-2 btn-primary' href='" . $next_page . "'><b> >> </b></a>");
    else
      echo ("<a class='btn btn-sm px-2 btn-primary disabled'><b> >> </b></a>");
  }


  /*** Display a Google Map showing the given coordinates using Google Maps API ***/
  function display_google_map($latitude, $longitude)
  {
    if($key = file_get_contents("../api_keys/google_maps_key.txt"))
    {
      echo ("<iframe class='google_map' frameborder='0' alt='Google Map API is not available at this time.' style='border:0' ");
      echo ("src='https://www.google.com/maps/embed/v1/place?key=" . $key);
      echo ("&zoom=12&q=" . $latitude . "," . $longitude . "' allowfullscreen> ");
      echo ("</iframe>");
    }
    else { echo "Google API Key Not Found"; }
  }

  /*** Returns a string of elapsed time in 'time ago ' format ***/
  function time_elapsed_string($date)
  {
    $timestamp = strtotime($date);

	   $strTime = array("second", "minute", "hour", "day", "month", "year");
	   $length = array("60","60","24","30","12","10");

	   $currentTime = time();
	   if($currentTime >= $timestamp) {
			$diff     = time()- $timestamp;
			for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
			$diff = $diff / $length[$i];
			}

			$diff = round($diff);
      if($diff == 0)
        return " just now";
      else if($diff == 1)
        return $diff . " " . $strTime[$i] . " ago ";
      else
			   return $diff . " " . $strTime[$i] . "s ago ";
    }
  }
?>
