<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";

  if(isset($_GET["file"]))
    $file = $_GET["file"];
  else
    header("Location: backup.php");

  if( check_login($dbh) && check_admin($_SESSION["user_id"], $dbh) )
  {
    $command = "cat ../../backups/" . $file;
    $output = NULL;
    exec($command, $output);

    header("Content-type: text/plain");
    header("Content-Disposition: attachment; filename=backup-" . date("YmdHis") . ".sql");
    echo implode("\n", $output);
  }
  else { echo "Error: Permission Denied"; }
?>
