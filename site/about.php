<?php
  include_once "php/db_connect.php";
  include_once "php/functions.php";
?>

<!DOCTYPE html>
<html>
  <head>
    <title>About</title>
    <link rel="icon" href="/myfavicon.ico"/>
    <link rel="stylesheet" href="stylesheets/custom.css" />
    <link rel="stylesheet" href="stylesheets/hover.css" />

    <script src="/javascripts/jquery-3.2.1.min.js"></script>
      <script>
      $.get("navigation.php", function(data){
          $("#nav-placeholder").replaceWith(data);
      });
    </script>

    <script src="/javascripts/jquery-3.2.1.min.js"></script>
      <script>
      $.get("footer.html", function(data){
          $("#foot-placeholder").replaceWith(data);
      });
    </script>

  </head>
  <body>

    <div id= "nav-placeholder"></div>
    <div class="background-white animated fadeIn">
      <div class="container py-5">
        <div class = "row mt-5">
          <div class = "col-8  animated slideInUp">
            <h1 >Thank you for visiting RangeFinder.</h1><hr>
            <h2>About</h2><hr>
            <p>RangeFinder is a site where mountain climbers
               and outdoor enthusiasts can search for thier favorite mountains
               and get the details they need about them. The site was designed
               for a class project by Jake Hurd and Benjamin Hargett at Clemson
                University. </p>
            <h2>Features</h2><hr>
            <h3>Search</h3>
            <p> Our database has thousands of mountains and all their data from
              places all over North America. You can search using a variety of methods
              including by name, location, or even their Latitude and Longitude. Have you
              ever been hiking and you wish you knew what mountains you passed over? With our
              database, you can easily find the mountains you've been looking for.
            </p>
            <h3>Follow</h3>
            <p>Want to know where your friends have been hiking? Follow them to put
            them on your user dashboard.</p>
            <h3>Like/Climb</h3>
            <p>You can easily like a mountain or mark it as climbed so that all your
              followers can see where youve been or maybe where you'd like to go!</p><hr>
          </div>
          <div class = "col-lg-4 col-sm-12  animated slideInRight">
            <div class = "row">
                <div class = "card">
                  <div class="view overlay hm-white-slight">
                      <img src="/img/about-page-screen.png" class="img-fluid" alt="">
                      <a href="/index.php">
                          <div class="mask"></div>
                      </a>

                  </div>
                </div>
            </div>

            <div class = "row mt-5">
                <div class = "card">
                  <div class="view overlay hm-white-slight">
                    <img src="/img/about-2.png" class="img-fluid" alt="">
                    <a href="/mountains/search.php">
                        <div class="mask"></div>
                    </a>
                  </div>
                </div>
            </div>
            <div class = "row mt-5">
                <div class = "card">
                  <div class="view overlay hm-white-slight">
                    <img src="/img/about-3.png" class="img-fluid" alt="">
                    <a href="/mountains/search.php">
                        <div class="mask"></div>
                    </a>
                  </div>
                </div>
            </div>



            <div class = "row">

            </div>
            <div class = "row">

            </div>
          </div>
        </div>

      </div>

      <div id= "foot-placeholder"></div>



    <script type="text/JavaScript" src="javascripts/jquery-3.2.1.min.js"></script>
    <script type="text/JavaScript" src="javascripts/sha512.js"></script>
    <script type="text/JavaScript" src="javascripts/forms.js"></script>
    <script type="text/JavaScript" src="javascripts/popper.min.js"></script>
    <script type="text/JavaScript" src="javascripts/bootstrap.min.js"></script>
    <script type="text/JavaScript" src="javascripts/mdb.min.js"></script>
  </body>
</html>
