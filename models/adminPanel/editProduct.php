<?php
include "../functions.php";
include_once "../../config/connection.php";
if (!isset($_POST["id"])) {
    header("Location: index.php?page=home");
    die();
}

$name = $_POST["prName"];
$price = $_POST["prPrice"];
$category =intval($_POST["cat_id"]);
$id = intval($_POST["id"]);
if (editProduct($name, $price, $category, $id)) {
    header("Location: ../../index.php?page=admin&productMessage=UspesnoPromenjeno");
    die();
    http_response_code(200);
}
else {
    header("Location: ../../index.php?page=admin&productMessage=greska");
    die();
    //http_response_code(200);
}