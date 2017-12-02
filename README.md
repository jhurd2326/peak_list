# CPSC 4620 - RangeFinder

Semester project for CPSC 4620 titled RangeFinder. This web based application
is a social media that allows users to search a database of mountains and Users
and keep track of which mountains they've climbed as well as see which Mountains
their friends have climbed. They can also like or leave comments on the
Mountains.

Contributors:

    Benjamin Hargett  -  bharget
    Jacob Hurd        -  jhurd

## Source Code Structure

  The site is organized into one root folder which contains the entry level
  php files for the site. The Home page, about page, icons, and anything else
  needed for those pages to work(Navigation/Footer) are stored here. Beyond that
  there are a series of folders that contain other useful files to allow our
  site to run as intended visually. These folders are font, img, api_keys,
  javascripts, and stylesheets. These handle all images, styles, and animations
  of the site. There is also a backup folder at this level which is where
  database backups are stored and restored from. Everything else in this level
  is php functions that correspond to different elements in our database.
  These are mountains, php, users, and admin. Within each of those are several
  php files that run to make the site interact with the database in a visually
  dynamic way.

### Admin Login Information


    Username:   admin
    Password:   password
