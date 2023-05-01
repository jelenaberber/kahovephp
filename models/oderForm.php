<?php
include_once "../config/connection.php";
include "functions.php";
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php?page=home");
    die();
}
else {
    $regFullName = "/^[A-ZŠĐŽĆČ][a-zšđžćč]{2,15}(\s[A-ZŠĐŽĆČ][a-zšđžćč]{2,15}){0,2}$/";
    if (!preg_match($regFullName, $_POST["name"])) {
        header("Location: ../index.php?page=cart&error=Invalid%20name.");
        die();
    }

    $regEmail = "/^[a-z]((\.|-|_)?[a-z0-9]){2,}@[a-z]((\.|-|_)?[a-z0-9]+){2,}\.[a-z]{2,6}$/i";
    if (!preg_match($regEmail, $_POST["email"])) {
        header("Location: ../index.php?page=cart&error=Ivanlid%20email.");
        die();
    }

    $regAddress = "/^(([A-ZŠĐČĆŽ][a-zščćđž\d]+)|([0-9][1-9]*\.?))(\s[A-Za-zŠĐŽĆČščćđž\d]+){0,7}\s(([1-9][0-9]{0,5}[\/-]?[A-Z])|([1-9][0-9]{0,5})|(BB))\.?$/";
    if (!preg_match($regAddress, $_POST["address"])) {
        header("Location: ../index.php?page=cart&error=Ivalid%20address.");
        die();
    }

    $name = $_POST["name"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $price = intval($_POST["totalPrice"]);


    try {
        global $conn;
        $user = $_SESSION['user'];
        $userId = intval($user->id);
        $query = $conn->prepare("INSERT INTO cart_order(id_user, full_name, email, address, total_price) VALUES(?,?,?,?,?)");
        $result = $query->execute([$userId, $name, $email, $address, $price]);

        if ($result) {
            $message = "Thank you for your recent purchase. We are honored to gain you as a customer and hope to serve you for a long time.";
//            $query = $conn->prepare("SELECT id FROM cart_order WHERE id_user = ?");
//            $query->execute([$userId]);
//            $orderId = $query->fetch();
            $orderId = intval($conn->lastInsertId());
            $query = $conn->prepare("UPDATE cart_content SET active=0, id_order = ? WHERE id_user = ? AND active=1");
            $result = $query->execute([$orderId, $userId]);

            header("Location: ../index.php?page=cart&message=Ordered&success");
        }
        else {

            $error = "Greška na serveru. Molimo pokušajte malo kasnije.";
            header("Location: ../index.php?page=cart&error=".$error);
        }
    } catch (PDOException $ex) {
        $error = "Greška pri komunikaciji sa serverom, probajte kasnije ponovo.";
        header("Location: ../index.php?page=cart&error=".$error);
        die();
    }
}
