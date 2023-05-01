<?php
header("Content-type: application/json");
include_once "../config/connection.php";
include "functions.php";

if(!isset($_SESSION['user'])){
    header("Location: ../index.php?page=register");
    die();
}

$id_item =intval($_GET['id_product_in_cart']);
$amount = intval($_GET['amount']);


if(changeAmount($amount, $id_item)) {
    $result = [
        'result' => true,
        'amount' => $amount,
        'id_product' => $id_item
    ];
}
else {
    $result = [
        'result' => false
    ];
}
echo json_encode($result);
