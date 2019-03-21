<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "foodbird";

    $con = mysqli_connect($host, $user, $pass, $db);


    // Say PHP to understand json
    $postdata = file_get_contents("php://input");
    $_POST = json_decode($postdata, true);
?>