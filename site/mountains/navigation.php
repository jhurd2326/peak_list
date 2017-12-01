<?php
  include_once "../php/db_connect.php";
  include_once "../php/functions.php";
?>
<nav class="navbar navbar-expand-lg navbar-light fixed-top scrolling-navbar white">
    <div class="container">

      <img class = "mr-4" src=<?php echo "../img/navbar-logo.png"; ?> height="30" alt="RangeFinder">

        <!-- Collapse button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- Links -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href=<?php echo "../index.php"; ?>>Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href=<?php echo "../about.php"; ?>>About</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search</a>
                    <div class=" dropdown-primary dropdown-content" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href=<?php echo "../mountains/search.php"; ?>>Mountains</a>
                        <a class="dropdown-item" href=<?php echo "../users/search.php"; ?>>Users</a>
                    </div>
                </li>

                <!-- Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Account</a>
                    <div class="dropdown-content dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                      <?php if(check_login($dbh)): ?>
                        <a class="dropdown-item" href=<?php echo "../dashboard.php"; ?>>My Dashboard</a>
                      <?php endif; ?>
                      <?php if(check_login($dbh)): ?>
                        <a class="dropdown-item" href= <?php echo "../users/show.php?id=" . $_SESSION["user_id"];?>>
                          My Account
                        </a>
                      <?php endif; ?>
                      <?php if(!check_login($dbh)): ?>
                        <a class="dropdown-item" href=<?php echo "../index.php"; ?>>Login</a>
                      <?php endif; ?>
                      <?php if(check_login($dbh)): ?>
                        <a class="dropdown-item" href=<?php echo "../php/logout.php"; ?>>Logout</a>
                      <?php endif; ?>
                    </div>
                </li>

                <?php if(check_login($dbh) && check_admin($_SESSION["user_id"], $dbh)): ?>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin</a>
                    <div class="dropdown-content dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                      <a class="nav-link" href=<?php echo "../admin/perform_backup.php"; ?>>DB Backup</a>
                    </div>
                  </li>
                <?php endif; ?>

            </ul>

            <?php if(check_login($dbh) && check_admin($_SESSION["user_id"], $dbh)): ?>
                <h1 class="navbar-brand" href=<?php echo "../index.php"; ?>><b>Admin</b></h1>
            <?php else: ?>
                <a class="navbar-brand" href=<?php echo "../index.php"?>>Range Finder</a>
            <?php endif; ?>
        </div>

    </div>
</nav>
