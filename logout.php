<link rel="stylesheet" type="text/css" href="./indexStyle.css">

<?php

    unset($_SESSION['userType']);
    unset($_SESSION["username"]);
    session_start();
    session_destroy();

    include('navi.php');
    ?> 
    <p class = "msg">
        You have been logged out. <br><a href="./login.php">Login Again</a>
    </p>
