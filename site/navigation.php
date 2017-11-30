<?php
  include_once "php/db_connect.php";
  include_once "php/functions.php";
?>

<nav class="navbar navbar-expand-lg navbar-light fixed-top scrolling-navbar white">
    <div class="container">

        <!-- Navbar brand -->
        <?php if(check_login($dbh)): ?>
          <img class = "mr-4" src="/img/navbar-logo.png" height="30" alt="RangeFinder">
        <?php else: ?>
          <img class = "mr-4" src="/img/navbar-logo.png" height="30" alt="">
          <a class="navbar-brand" href="/index.php">Range Finder</a>
        <?php endif; ?>

        <!-- Collapse button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- Links -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/about.php">About</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search</a>
                    <div class=" dropdown-primary dropdown-content" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="/mountains/search.php">Mountains</a>
                        <a class="dropdown-item" href="/users/search.php">Users</a>
                    </div>
                </li>

                <!-- Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Account</a>
                    <div class="dropdown-content dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="../dashboard.php">My Account</a>
                        <a class="dropdown-item" href="../index.php">Login</a>
                        <a class="dropdown-item" href="/php/logout.php">Logout</a>
                    </div>
                </li>

            </ul>

            <form class="form-inline">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
            </form>
        </div>

    </div>
</nav>
