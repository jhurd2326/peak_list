<?php
  $base_addr = "/~bharget";
  include_once "{$base_addr}/php/db_connect.php";
  include_once "{$base_addr}/php/functions.php";
?>
<nav class="navbar navbar-expand-lg navbar-light fixed-top scrolling-navbar white">
    <div class="container">

        <!-- Navbar brand -->
        <?php if(check_login($dbh)): ?>
          <img class = "mr-4" src=<?php echo $base_addr . "/img/navbar-logo.png" ?> height="30" alt="RangeFinder">
          <?php if (check_admin($_SESSION["user_id"], $dbh)):?>
            <a class="navbar-brand" href=<?php echo $base_addr . "/index.php"?>><b>Admin</b></a>
        <?php endif;?>
        <?php else: ?>
          <img class = "mr-4" src=<?php echo $base_addr . "/img/navbar-logo.png"?> height="30" alt="">
          <a class="navbar-brand" href=<?php echo $base_addr . "/index.php"?>>Range Finder</a>
        <?php endif; ?>


        <!-- Collapse button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- Links -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href=<?php echo $base_addr . "/index.php"?>>Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href=<?php echo $base_addr . "/about.php"?>>About</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search</a>
                    <div class=" dropdown-primary dropdown-content" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href=<?php echo $base_addr . "/mountains/search.php"?>>Mountains</a>
                        <a class="dropdown-item" href=<?php echo $base_addr . "/users/search.php"?>>Users</a>
                    </div>
                </li>

                <!-- Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Account</a>
                    <div class="dropdown-content dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                      <?php if(check_login($dbh)): ?>
                        <a class="dropdown-item" href=<?php echo $base_addr . "/dashboard.php"?>>My Dashboard</a>
                      <?php endif; ?>
                      <?php if(check_login($dbh)): ?>
                        <a class="dropdown-item" href= <?php echo $base_addr ."/users/show.php?id=" . $_SESSION["user_id"];?>>
                          My Account
                        </a>
                      <?php endif; ?>
                      <?php if(!check_login($dbh)): ?>
                        <a class="dropdown-item" href=<?php echo $base_addr . "/index.php"?>>Login</a>
                      <?php endif; ?>
                      <?php if(check_login($dbh)): ?>
                        <a class="dropdown-item" href=<?php echo $base_addr . "/php/logout.php"?>>Logout</a>
                      <?php endif; ?>
                    </div>
                </li>

                <?php if(check_login($dbh) && check_admin($_SESSION["user_id"], $dbh)): ?>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin</a>
                    <div class="dropdown-content dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                      <a class="nav-link" href="/admin/backup.php?page=1">DB Backups</a>
                    </div>
                  </li>
                <?php endif; ?>

            </ul>

            <form class="form-inline">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
            </form>
        </div>

    </div>
</nav>
