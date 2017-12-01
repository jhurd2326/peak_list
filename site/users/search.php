<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";
  include_once "../php/constants.php";

  unset($_SESSION["user_results"], $_SESSION["user_page"]);
?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="icon" href="../myfavicon.ico"/>
    <meta name="google" content="notranslate" />


    <title>User Search | RangeFinder</title>
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
                document.mountain_search_form.submit();
            }
        }
    </script>

    <link rel="stylesheet" href="../stylesheets/custom.css" />
    <link rel="stylesheet" href="../stylesheets/font-awesome.css" />

  </head>
  <body>

    <div id= "nav-placeholder"></div>

    <div class="background animated fadeIn">
      <div class="container py-5 h-100">
        <?php
          if(isset($_GET["error"]))
          {
            echo "<p class='error'>Error Searching For Mountains</p>";
          }
        ?>

        <div class = "row mt-5 text-center text-lg-left text-md-left">
          <div class = "col">
            <h1 class = "h1-responsive">Search Users</h1>
          </div>
        </div>
        <div class="row mt-5">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form action="results.php?page=1" method="post" name="user_search_form">
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="md-form">
                    <input type="text" name="username_name" id="username_name" class="form-control" />
                    <label for="username_name">Username / Name</label>
                  </div>
                </div>
              </div>


              <div class="text-center my-3">
                <input type="button" value="Search" onclick="this.form.submit();" class="btn btn-primary"/>
              </div>

            </form>
          </div>
        </div>
      </div>
      <div id= "foot-placeholder"></div>

    </div>



    <script type="text/JavaScript" src="../javascripts/jquery-3.2.1.min.js"></script>
    <script type="text/JavaScript" src="../javascripts/sha512.js"></script>
    <script type="text/JavaScript" src="../javascripts/forms.js"></script>
    <script type="text/JavaScript" src="../javascripts/popper.min.js"></script>
    <script type="text/JavaScript" src="../javascripts/bootstrap.min.js"></script>
    <script type="text/JavaScript" src="../javascripts/mdb.min.js"></script>

  </body>
</html>
