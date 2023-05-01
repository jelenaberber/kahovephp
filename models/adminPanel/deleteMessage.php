<?php
include "../functions.php";
include_once "../../config/connection.php";
if (!isset($_GET["id"])) {
    header("Location: index.php?page=home");
    die();
}

$id = intval($_GET["id"]);
if (deleteMessage($id)) {
    header("Location: ../index.php?page=admin&contactMessage=UspesnoPromenjeno");
    die();
    http_response_code(200);
}
else {
    header("Location: ../index.php?page=admin&contactMessage=greska");
    die();
    //http_response_code(200);
}