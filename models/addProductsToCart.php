<?php
header('Content-type: application/json');
require_once "../config/connection.php";
require_once "functions.php";
if(!isset($_SESSION['user'])){
    echo json_encode([
        "user" =>0
    ]);
    die();
}
$user = $_SESSION['user'];

$id_product = intval($_GET['id_product']);
$id_user = intval($user->id);
try {
    global $conn;

    $query = $conn->prepare("SELECT id_product FROM cart_content WHERE id_user = ? AND id_product = ?");
    $query->execute([$id_user, $id_product]);
    $usersProduct = $query->fetch();
} catch (PDOException $ex) {

    //create_log(ERROR_LOG_FAJL, $ex->getMessage());
    $error = "Greška pri komunikaciji sa serverom, probajte kasnije ponovo.";
    header("Location: ../../index.php?page=register&error=".$error);
}

//ako ne postoji => upis
if (!$usersProduct) {
    try {
        $query = $conn->prepare("INSERT INTO cart_content(id_user, id_product) VALUES(?,?) ");
        $result = $query->execute([$id_user, $id_product]);

        if ($result) {
            $message = "Uspešno dodat";
            header("Location: ../../index.php?page=artworks&message=".$message);
        }
        else {
            $error = "Greška na serveru. Molimo pokušajte malo kasnije.";

            header("Location: ../../index.php?page=artworks&error=".$error);
        }
    } catch (PDOException $ex) {
        $error = "Greška pri komunikaciji sa serverom, probajte kasnije ponovo.";
        header("Location: ../../index.php?page=artworks&error=".$error);
        die();
    }
}
else{
    try {
        $query = $conn->prepare("UPDATE cart_content SET amount = amount + 1 WHERE id_user = ? AND id_product = ?");
        $result = $query->execute([$id_user, $id_product]);

        if ($result) {
            $message = "Uspešno uvacano";
            header("Location: ../../index.php?page=artworks&message=".$message);
        }
        else {
            $error = "Greška na serveru. Molimo pokušajte malo kasnije.";

            header("Location: ../../index.php?page=artworks&error=".$error);
        }
    } catch (PDOException $ex) {
        $error = "Greška pri komunikaciji sa serverom, probajte kasnije ponovo.";
        header("Location: ../../index.php?page=artworks&error=".$error);
        die();
    }
}
