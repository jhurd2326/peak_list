<?php
include_once 'php/db_connect.php';
include_once 'php/functions.php';

session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Secure Login: Protected Page</title>
    </head>
    <body>
        <?php if (check_login($mysqli) == true) : ?>
            <p>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</p>
            <p>
                This is an example protected page.  To access this page, users
                must be logged in.
            </p>
            <p>Return to <a href="index.php">login page</a></p>
        <?php else : ?>
            <p>
              You are not authorized to access this page. Please <a href="index.php">login</a>.
            </p>
        <?php endif; ?>
    </body>
</html>
