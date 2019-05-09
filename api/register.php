<?php
    require_once("includes/connection.php");

    $id = $_POST['id'];
    $name = $_POST['name'];
    $photo = $_POST['photo'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $provider = $_POST['provider'];


    $checkQuery = "SELECT id FROM users WHERE id = '$id'";
    $res = mysqli_query($con, $checkQuery);
    $user = mysqli_fetch_assoc($res);

    $response = [
        'success' => true
    ];

    if ($user) {
        // update existing user
        $query = "
            UPDATE users 
            SET
                `name` = '$name',
                `photo` = '$photo',
                `email` = '$email',
                `gender` = '$gender',
                `provider` = '$provider'

            WHERE `id` = '$id'
        ";
        $response["msg"] = "User updated successfully";
    } else {
        // Create new user
        $query = "INSERT INTO users (`id`, `name`, `photo`, `email`, `gender`, `provider`) VALUES ('$id', '$name', '$photo', '$email', '$gender', '$provider')";
        $response["msg"] = "User created successfully";
    }

    mysqli_query($con, $query);

    header("Content-type: application/json");
    echo json($response);
?>