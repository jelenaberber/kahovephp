<?php
include "../functions.php";
include_once "../../config/connection.php";
if (!isset($_GET["id"]) || !isset($_GET["status"])) {
    header("Location: index.php?page=home");
    die();
}

$id = intval($_GET["id"]);
$status = $_GET["status"] == "0" ? 0 : 1;
if (changeActiveStatusForProduct($status, $id)) {
    header("Location: ../../index.php?page=admin&productMessage=Uspesno#admin-user");
    die();
    http_response_code(200);
}
else {
    header("Location: ../../index.php?page=admin&productMessage=greska#admin-user");
    die();
    http_response_code(200);
}
function changeActiveStatusForProduct($status, $id){
    try {
        global $conn;
        $status = !$status;
        $result = $conn->prepare("UPDATE product SET active = ? WHERE id = ?");
        $result->execute([$status, $id]);

        return $result;
    } catch (PDOException $ex) {
        //createLog(ERROR_LOG_FAJL, $ex->getMessage());
        // todo obrisati ostatke createLog funkcije
        return $ex;
    }
}