<?php
session_start();

// remove all session variables
session_unset();

// destroy the session 
session_destroy();

// redirect to login page
header("location: login.php", true, 303);
exit();
