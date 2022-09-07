<?php
//this page is too delete all of the session varible to make the useer log out of the web
session_start();
session_unset();
session_destroy();

header('Location: login.php')
?>
