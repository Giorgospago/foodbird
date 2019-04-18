<?php
    require_once("includes/connection.php");

    $user_id = $_POST['user_id'];
    $street = $_POST['street'];
    $number = $_POST['number'];
    $postal_code = $_POST['postal_code'];
    $floor_type = $_POST['floor_type'];
    $floor_num = $_POST['floor_num'];
    $floor_name = $_POST['floor_name'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $alias = $_POST['alias'];
    $notes = $_POST['notes'];

    $query = "INSERT INTO addresses 
        (`user_id`, `street`, `number`, `postal_code`, `floor_type`, `floor_num`, `floor_name`, `country`, `city`, `alias`, `notes`) 
        VALUES 
        ('$user_id', '$street', '$number', '$postal_code', $floor_type, '$floor_num', '$floor_name', '$country', '$city', '$alias', '$notes')
    ";
    mysqli_query($con, $query);

    header("Content-type: application/json");
    echo json_encode([
        'success' => true
    ]);
?>