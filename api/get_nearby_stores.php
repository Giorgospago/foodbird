<?php
    require_once("includes/connection.php");

    $addressId = $_POST['addressId'];
    $query = "SELECT * FROM addresses WHERE id = $addressId";
    $res = mysqli_query($con, $query);
    $address = mysqli_fetch_assoc($res);

    $filters = [
        ["name" => "Filter 1"],
        ["name" => "Filter 2"],
        ["name" => "Filter 3"]
    ];
    $stores = [
        ["name" => "Store 1"],
        ["name" => "Store 2"],
        ["name" => "Store 3"],
        ["name" => "Store 4"]
    ];

    header("Content-type: application/json");
    echo json_encode([
        'success' => true,
        'filters' => $filters,
        'stores' => $stores,
        'address' => $address
    ]);
?>