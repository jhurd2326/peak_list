<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";

  $dir = scandir( "../backups");
  $files = array();
  foreach($dir as $file)
    if(substr($file, 0, 1) !== ".")
      array_push($files, $file);

  $files = array_reverse($files);
  $page_number = 0;
  $limit = 8;

  if(isset($_GET["page"]))
    $page_number = $_GET["page"];
  else
    header("Location: backup.php?page=1");

  $curr_files = array_slice($files, $limit * ($page_number-1), $limit);
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Admin | RangeFinder</title>
    <link rel="icon" href="../myfavicon.ico"/>
    <link rel="stylesheet" href="../stylesheets/custom.css" />
    <link rel="stylesheet" href="../stylesheets/hover.css" />
    <link rel="stylesheet" href="../stylesheets/font-awesome.css" />

    <script src="../javascripts/jquery-3.2.1.min.js"></script>
      <script>
      $.get("navigation.php", function(data){
          $("#nav-placeholder").replaceWith(data);
      });
    </script>

    <script src="../javascripts/jquery-3.2.1.min.js"></script>
      <script>
      $.get("../footer.php", function(data){
          $("#foot-placeholder").replaceWith(data);
      });
    </script>

    <script>
        document.onkeydown=function(evt){
            var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
            if(keyCode == 13)
            {
              login_check(login_form, login_form.username, login_form.password);
            }
        }
    </script>

  </head>
  <body>

    <div id= "nav-placeholder"></div>
    <div class="background-white animated fadeIn">
      <div class="container h-100">
        <?php if(check_login($dbh) && check_admin($_SESSION["user_id"], $dbh)): ?>
          <div class="row flex-center">
            <div class="col-8">
                <div class="animated fadeIn">
                  <div class="row mb-3">
                    <div class="col-12">
                      <div class="flex-center col-12 justify-content-between">
                        <h1>Database Backups</h1>
                        <form action="perform_backup.php" method="post" name="backup_form" id="backup_form">
                          <a class="btn btn-primary" onclick="backup_form.submit();">
                            Create Backup
                          </a>
                        </form>
                      </div>
                      <hr />
                    </div>
                  </div>
                  <?php if(empty($curr_files)): ?>
                    <div class="pt-3">
                      <h2 class="h2-responsive text-center">No Backups</h2>
                    </div>
                  <?php else: ?>
                    <?php foreach($curr_files as $file) { ?>
                      <div class="row list-item mx-2">
                        <div class="d-flex col-12 justify-content-between">
                          <a class="custom-link" href=<?php echo "../backups/" . $file; ?>>
                            <i class="fa fa-database mr-3" aria-hidden="true"></i>
                            <b><?php echo $file ?></b>
                          </a>
                          <div>
                            <a href=<?php echo "restore.php?file=" . $file; ?> class="custom-link"><b>Restore</b></a>
                            <span class="mx-3"></span>
                            <a href=<?php echo "delete.php?file=" . $file; ?> class="custom-link"><b>Delete</b></a>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                    <div class="text-center">
                      <?php
                        $url = "backup.php?page=" . $page_number;
                        display_pagination($files, $page_number, $limit, $url);
                      ?>
                    </div>
                  <?php endif; ?>
                </div>
            </div>
          </div>
        </div>
        <?php else: ?>
          <div class="container h-100">
            <div class = "d-flex row flex-center">
              <div class = "col-12 text-center mt-5 animated slideInUp">
                <h3>Error: Permission Denied</h3>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <div id= "foot-placeholder"></div>



    <script type="text/JavaScript" src="../javascripts/jquery-3.2.1.min.js"></script>
    <script type="text/JavaScript" src="../javascripts/sha512.js"></script>
    <script type="text/JavaScript" src="../javascripts/forms.js"></script>
    <script type="text/JavaScript" src="../javascripts/popper.min.js"></script>
    <script type="text/JavaScript" src="../javascripts/bootstrap.min.js"></script>
    <script type="text/JavaScript" src="../javascripts/mdb.min.js"></script>
  </body>
</html>
