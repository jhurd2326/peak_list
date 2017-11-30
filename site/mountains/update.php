<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";

  if(isset($_GET["id"]))
    $mountain = find_mountain($_GET["id"], $dbh);
  else
    header("Location: search.php");

  $name = isset($_POST["name"]) ? $_POST["name"] : "";
  $state = isset($_POST["state"]) ? $_POST["state"] : "";
  $country = isset($_POST["country"]) ? $_POST["country"] : "";
  $elevation = isset($_POST["elevation"]) ? $_POST["elevation"] : "";
  $latitude = isset($_POST["latitude"]) ? $_POST["latitude"] : "";
  $longitude = isset($_POST["longitude"]) ? $_POST["longitude"] : "";

  if(check_login($dbh) && check_admin($_SESSION["user_id"], $dbh) )
  {
    $sql = "UPDATE mountains SET name = :name, state = :state, country = :country,
            elevation = :elevation, latitude = :latitude, longitude = :longitude
            WHERE id = :id";
    if($query = $dbh -> prepare($sql))
    {
      $query -> bindValue(":name", $name);
      $query -> bindValue(":state", $state);
      $query -> bindValue(":country", $country);
      $query -> bindValue(":elevation", $elevation);
      $query -> bindValue(":latitude", $latitude);
      $query -> bindValue(":longitude", $longitude);
      $query -> bindValue(":id", $mountain["id"]);
      if($query -> execute())
        header("Location: show.php?id=" . $mountain["id"]);
      else
        echo "Error updating mountain";
    }
    else { echo "Error updating mountain"; }
  }
  else
  {
    echo "Error: Cannot Update Mountain, Permission Denied";
  }
?>
