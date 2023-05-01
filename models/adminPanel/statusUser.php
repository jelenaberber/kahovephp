<?php
include "../functions.php";
include_once "../../config/connection.php";
if (!isset($_GET["id"]) || !isset($_GET["status"])) {
    header("Location: index.php?page=home");
    die();
}

$id = intval($_GET["id"]);
$status = $_GET["status"] == "0" ? 0 : 1;
if (changeActiveStatusForUser($status, $id)) {
//    header("Location: ../../index.php?page=admin&userMessage=Uspesno#admin-user");
//    die();
    http_response_code(200);
    echo json_encode([
        "active" =>true,

    ]);
}
else {
    header("Location: ../../index.php?page=admin&userMessage=greska#admin-user");
    die();
    //http_response_code(200);
}