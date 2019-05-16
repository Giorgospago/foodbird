<?php
    require_once("includes/connection.php");

    $addressId = $_POST['addressId'];
    $query = "SELECT * FROM addresses WHERE id = $addressId";
    $res = mysqli_query($con, $query);
    $address = mysqli_fetch_assoc($res);

    $filters = [];
    $categoriesQuery = "SELECT * FROM categories";
    $resCategories = mysqli_query($con, $categoriesQuery);
    while ($category = mysqli_fetch_assoc($resCategories)) {
        
        $sub_filters = [];
        $filtersQuery = "SELECT * FROM filters WHERE category_id = ".$category["id"];
        $resFilters = mysqli_query($con, $filtersQuery);
        while ($fil = mysqli_fetch_assoc($resFilters)) {
            $sub_filters[] = $fil;
        }

        $filters[] = [
            "id" => $category["id"],
            "name" => $category["name"],
            "filters" => $sub_filters
        ];
    }

    $stores = [];
    $storesQuery = "
        SELECT tbl.*,
        GROUP_CONCAT(store_filter.filter_id) as filters
        FROM (
            SELECT
                stores.*,
                ( 6371 * acos( cos( radians(".$address['latitude'].") )
                    * cos(  radians( stores.latitude )   )
                    * cos(  radians( stores.longitude ) - radians(".$address['longitude'].") )
                    + sin( radians(".$address['latitude'].") )
                    * sin( radians( stores.latitude ) )
                ))
                AS distance
            FROM stores
            HAVING distance < 0.8
        ) as tbl
        INNER JOIN store_filter ON tbl.id = store_filter.store_id
        GROUP BY tbl.id
    ";
    $resStores = mysqli_query($con, $storesQuery);
    while ($store = mysqli_fetch_assoc($resStores)) {
        $store["filters"] = explode(",", $store["filters"]);
        $stores[] = $store;
    }

    header("Content-type: application/json");
    echo json([
        'success' => true,
        'filters' => $filters,
        'stores' => $stores,
        'address' => $address
    ]);
?>