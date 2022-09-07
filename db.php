<?php
//database user first will set to signinup which can only view or insert Customer table
//will be change after login as either admin or user and each will have their own db user
$pass = "";

$dbh = new PDO('mysql:host=localhost;dbname=lazada', $_SESSION['db_user'], $pass);
