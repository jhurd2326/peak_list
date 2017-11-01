<?php
  include_once "db_connect.php";
  include_once "functions.php";

  if(isset($_POST["username"], $_POST["p"], $_POST["email"], $_POST["first_name"],
    $_POST["last_name"], $_POST["age"], $_POST["phone"], $_POST["address"]))
  {
    $username =   filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
    $password =   filter_input(INPUT_POST, "p", FILTER_SANITIZE_STRING);
    $email =      filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
    $first_name = filter_input(INPUT_POST, "first_name", FILTER_SANITIZE_STRING);
    $last_name =  filter_input(INPUT_POST, "last_name", FILTER_SANITIZE_STRING);
    $age =        filter_input(INPUT_POST, "age", FILTER_SANITIZE_STRING);
    $phone =      filter_input(INPUT_POST, "phone", FILTER_SANITIZE_STRING);
    $address =    filter_input(INPUT_POST, "address", FILTER_SANITIZE_STRING);

    if(register($username, $password, $email, $first_name, $last_name, $age,
      $phone, $address, $dbh) == true)
    {
      login($username, $password, $dbh);
      header("Location: ../protected_page.php");
    }
    else
    {
      header("Location: ../register.php?error=1");
    }
  }
  else { echo "Invalid Request"; }
?>
