<?php
    require_once("includes/connection.php");

    $id = $_GET["id"];
    $query = "SELECT * FROM users WHERE id = '$id'";

    $res = mysqli_query($con, $query);
    $user = mysqli_fetch_assoc($res);

    if ($user) {
        $response = [
            'success' => true,
            'user' => $user
        ];
    } else {
        $response = [
            'success' => false
        ];
    }
    
    header("Content-type: application/json");
    echo json_encode($response);
?>