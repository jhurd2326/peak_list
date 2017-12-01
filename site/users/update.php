<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";

  if(isset($_GET["id"]))
    $user = find_user($_GET["id"], $dbh);
  else
    header("Location: search.php");

  $first_name = isset($_POST["first_name"]) ? $_POST["first_name"] : $user["first_name"];
  $last_name = isset($_POST["last_name"]) ? $_POST["last_name"] : $user["last_name"];
  $email = isset($_POST["email"]) ? $_POST["email"] : $user["email"];
  $age = isset($_POST["age"]) ? $_POST["age"] : $user["age"];
  $phone = isset($_POST["phone"]) ? $_POST["phone"] : $user["phone"];
  $address = isset($_POST["address"]) ? $_POST["address"] : $user["address"];
  $biography = isset($_POST["biography"]) ? $_POST["biography"] : $user["biography"];


  if(check_login($dbh) && ($_SESSION["user_id"] == $user["id"] || check_admin($_SESSION["user_id"], $dbh)))
  {
    $sql = "UPDATE users SET first_name = :first_name, last_name = :last_name,
            email = :email, age = :age, telephone = :phone, address = :address, biography = :bio WHERE
            id = :id";
    if($query = $dbh -> prepare($sql))
    {
      $query -> bindValue(":first_name", $first_name);
      $query -> bindValue(":last_name", $last_name);
      $query -> bindValue(":email", $email);
      $query -> bindValue(":age", $age);
      $query -> bindValue(":phone", $phone);
      $query -> bindValue(":address", $address);
      $query -> bindValue(":id", $user["id"]);
      $query -> bindValue(":bio", $biography);

      if($query -> execute())
        header("Location: show.php?id=" . $user["id"]);
      else
        echo "Error updating user";
    }
    else { echo "Error updating user"; }
  }
  else
  {
    echo "Error: Cannot Update User, Permission Denied";
  }
?>
