<?php
    require_once("includes/connection.php");

    $addressId = $_POST['addressId'];
    $query = "SELECT * FROM addresses WHERE id = $addressId";
    $res = mysqli_query($con, $query);
    $address = mysqli_fetch_assoc($res);

    if(!$address) {
        echo json([
            'success' => false,
            'message' => "Address not found !"
        ]);
        exit;
    }

    $storeId = $_POST['storeId'];
    $query = "SELECT * FROM stores WHERE id = $storeId";
    $res = mysqli_query($con, $query);
    $store = mysqli_fetch_assoc($res);
   
    if(!$store) {
        echo json([
            'success' => false,
            'message' => "Store not found !"
        ]);
        exit;
    }

    $distanceQuery = "
        SELECT
            ( 6371 * acos( cos( radians(".$address['latitude'].") )
                * cos( radians( stores.latitude ) )
                * cos( radians( stores.longitude ) - radians(".$address['longitude'].") )
                + sin( radians(".$address['latitude'].") )
                * sin( radians( stores.latitude ) )
            ))
            AS distance
        FROM stores
        WHERE stores.id = $storeId
        HAVING distance < stores.max_distance
    ";
    $res = mysqli_query($con, $distanceQuery);
    $distance = mysqli_fetch_assoc($res);

    if(!$distance) {
        echo json([
            'success' => false,
            'message' => "You are out of distance"
        ]);
        exit;
    }

    

    echo json([
        'success' => true,
        'filters' => $filters,
        'stores' => $stores,
        'address' => $address
    ]);
?>