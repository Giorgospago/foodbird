<?php
    require_once("includes/connection.php");

    $user_id = $_POST['user_id'];
    $query = "SELECT * FROM addresses WHERE user_id = '$user_id'";
    $res = mysqli_query($con, $query);
    $addresses = [];

    while ($a = mysqli_fetch_assoc($res)) {
        $addresses[] = $a;
    }

    header("Content-type: application/json");
    echo json([
        'success' => true,
        'addresses' => $addresses
    ]);
?>