<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";

  if( check_login($dbh) && check_admin($_SESSION["user_id"], $dbh) )
  {
    $command = "mysqldump --host={$db_host} --password={$db_password} --user={$db_username} ".
               "--databases {$db_name}";
    $output = NULL;
    exec($command, $output);

    $command = "chmod -R o+rx ../backups";
    exec($command);

    header("Content-type: text/plain");
    header("Content-Disposition: attachment; filename=backup-" . date("YmdHis") . ".sql");
    echo implode("\n", $output);
  }
  else { echo "Error: Permission Denied"; }
?>
