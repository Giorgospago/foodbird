<?php
    require_once("includes/connection.php");

    $id = $_GET["id"];
    $query = "SELECT * FROM users WHERE id = '$id'";

    $res = mysqli_query($con, $query);
    $user = mysqli_fetch_assoc($res);

    if ($user) {

        // Get all adresses
        $user["addresses"] = [];
        $queryAddresses = "SELECT * FROM addresses WHERE user_id = '$id'";
        $resAddresses = mysqli_query($con, $queryAddresses);
        while ($a = mysqli_fetch_assoc($resAddresses)) {
            $user["addresses"][] = $a;
        }

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