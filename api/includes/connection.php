<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "foodbird";

    $con = mysqli_connect($host, $user, $pass, $db);
    mysqli_query($con, "SET NAMES utf8");

    // Say PHP to understand json
    $postdata = file_get_contents("php://input");
    $_POST = json_decode($postdata, true);


    function json($data) {
        return json_encode($data, JSON_NUMERIC_CHECK);
    }
?>