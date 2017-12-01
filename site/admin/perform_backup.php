<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";

  if( check_login($dbh) && check_admin($_SESSION["user_id"], $dbh) )
  {
    $command = "/usr/bin/mysqldump --host={$db_host} --password={$db_password} --user={$db_username} ".
               "--databases {$db_name} > ../backups/backup-" . date("YdmHis") . ".sql";
    exec($command);

    $command = "chmod -R o+rx ../backups/";
    exec($command);

    header("Location: backup.php");
  }
  else { echo "Error: Permission Denied"; }
?>
