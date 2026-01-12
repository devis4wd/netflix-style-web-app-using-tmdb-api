<?php
// Enable these only during local debugging
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

/*
  logout.php

  Purpose:
  - Ends the current user session
  - Removes all session data
  - Redirects the user to the homepage
*/

session_start();

/*
  Remove all session variables.
*/
session_unset();

/*
  Destroy the session completely, including the session ID
  and any data stored on the server.
*/
session_destroy();

/*
  Optional security hardening:
  If you ever create custom cookies, they should be removed here as well.
*/

/*
  After logout, redirect the user to the homepage.
*/
header('Location: index.php');
exit();
