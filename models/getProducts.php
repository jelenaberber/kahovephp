<?php
header('Content-type: application/json');
require_once "../config/connection.php";
require_once "functions.php";

$params_array = [];
$stringQuery = '';
$search = isset($_GET['search']) ? ($_GET["search"]) : false;
$sortBy = isset($_GET['sortBy']) ? $_GET["sortBy"] : false;
$filter = isset($_GET['filter']) ? $_GET["filter"] : false;

if($search != ''){
    $stringQuery .= " AND LOWER(name) LIKE ?";
    $params_array []= "%$search%";
}
if($filter){
    $stringQuery .= ' AND id_category='.$filter;
}
if($sortBy){
    if($sortBy == 1){
        $stringQuery .= ' ORDER BY price asc';
    }
    else{
        $stringQuery .= ' ORDER BY price desc';
    }
}

try{
    global $conn;
    $query = "SELECT * FROM product WHERE active = 1".$stringQuery;
    $selectQuery = $conn->prepare($query);
    $selectQuery->execute($params_array);
    $products = $selectQuery->fetchAll();

    if(!$products){
        $products = [];
    }
    $response_code = 200;
}
catch (PDOException $ex){
    echo json_encode(["products"=>$ex]);
    $products = [];
    $response_code = 500;
}
echo json_encode([
   "products" =>$products
]);
http_response_code($response_code);