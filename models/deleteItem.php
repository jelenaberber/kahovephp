<?php
header("Content-type: application/json");
include_once "../config/connection.php";
include "functions.php";

if(!isset($_SESSION['user'])){
    header("Location: ../index.php?page=register");
    die();
}

$id = intval($_GET['id_product_in_cart']);

if(delete_from_cart($id, "cart_content")) {
    $result = [
        'result' => true,
        'id' => $id,
    ];
}
else {
    $result = [
        'result' => false,
        'id' => $id
    ];
}
echo json_encode($result);
