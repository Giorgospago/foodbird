<?php
    $host = "5.189.177.98";
    $user = "bird_user";
    $pass = "3N~rl53s";
    $db = "FoodBirdDB";

    $con = mysqli_connect($host, $user, $pass, $db);
    mysqli_query($con, "SET NAMES utf8");

    // Say PHP to understand json
    $postdata = file_get_contents("php://input");
    $_POST = json_decode($postdata, true);

    header("Content-type: application/json");
    
    function json($data) {
        return json_encode($data, JSON_NUMERIC_CHECK);
    }
?>