<?php
function getPageDetails($page_name){
    try {
        global $conn;

        $result = $conn->prepare("SELECT * FROM page WHERE path LIKE ?");
        $result->execute([$page_name]);

        return $result->fetch();
    } catch (PDOException $ex) {
        return $ex;
    }
}
function unosKorisnika($firstName, $lastName, $email, $sifrovanaLozinka){
    try{
        global $conn;
        $query = "INSERT INTO user(first_name, last_name, email, password) VALUES
        (:firstName, :lastName, :email, :password)";
        $priprema = $conn->prepare($query);
        $priprema ->bindParam(':firstName', $firstName);
        $priprema ->bindParam(':lastName', $lastName);
        $priprema ->bindParam(':email', $email);
        $priprema ->bindParam(':password', $sifrovanaLozinka);
        $result = $priprema->execute();

        $userParam = $conn->prepare("SELECT u.*, r.name as role_name FROM user u JOIN role r ON u.role = r.id_role WHERE u.email = ? AND u.password = ?");
        $userParam->execute([$email, $sifrovanaLozinka]);

        return $userParam->fetch();
    }
    catch (PDOException $ex) {
        return false;
    }

}
function queryFunction($queryString, $fetchAll = false){
    try {
        global $conn;

        if ($fetchAll){
            return $conn->query($queryString)->fetchAll();
        }

        return $conn->query($queryString)->fetch();

    } catch (PDOException $ex) {
        return false;
    }
}

function selectQuery($table, $fetchAll = false){
    try {

        global $conn;

        $query = "SELECT * FROM " . $table;
        return $conn->query($query)->fetchAll();

    } catch (PDOException $ex) {
        return false;
    }
}
function proveraLogovanja($email, $sifrovanalozinka){
    try {
        global $conn;

        $priprema = $conn->prepare('SELECT u.*, r.name as role_name FROM user u JOIN role r ON u.role = r.id_role WHERE u.email = :email AND u.password = :password');
        $priprema->bindParam(':email', $email);
        $priprema->bindParam(':password', $sifrovanalozinka);
        $priprema->execute();
        $result = $priprema->fetch();
        return $result;
    }
    catch (PDOException $ex){
        return $ex;
    }
}
function changeActiveStatusForUser($status, $id){

    try {
        global $conn;
        $status = !$status;
        $result = $conn->prepare("UPDATE user SET active = ? WHERE id = ?");
        $result->execute([$status, $id]);
//var_dump($result);
//die();
        return $result;
    } catch (PDOException $ex) {
        //createLog(ERROR_LOG_FAJL, $ex->getMessage());
        var_dump($ex);
        die();
        return false;
    }
}
function editProduct($name, $price, $cat_id, $id){
    try{
        global $conn;
        $result = $conn->prepare("UPDATE product SET name = ?, price = ?, id_category = ? WHERE id = ?");
        $result->execute([$name, $price, $cat_id, $id]);
        return $result;
    }
    catch (PDOException $ex) {
        return false;
    }
}

function deleteMessage($id){
    try{
        global $conn;
        $result = $conn->prepare("DELETE FROM message WHERE id = $id");
        $result->execute([$id]);
        return $result;
    }
    catch (PDOException $ex) {
        return false;
    }
}
function delete_from_cart($id, $string)
{
    global $conn;

    try {
        $string == "user" ? $query = "DELETE FROM cart_content WHERE id_user = ?" : $query = "DELETE FROM cart_content WHERE id = ?";

        $delete = $conn->prepare($query);
        $result = $delete->execute([$id]);
        return $result;
    } catch (PDOException $ex) {
        return false;
    }
}
function changeAmount($amount, $id_item){
    global $conn;

    $query = $conn->prepare("UPDATE cart_content SET amount = ? WHERE id = ?");
    $result = $query->execute([$amount, $id_item]);

    return $result;
}

?>


