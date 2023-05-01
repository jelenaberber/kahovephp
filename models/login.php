<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    include "../config/connection.php";
    include "functions.php";
    try {
        $email = $_POST['email'];
        $password = $_POST['password'];
        //provera
        $regEmail = "/^[a-z]((\.|-|_)?[a-z0-9]){2,}@[a-z]((\.|-|_)?[a-z0-9]+){2,}\.[a-z]{2,6}$/i";
        if(!preg_match($regEmail, $_POST["email"])){
            header("Location: ../index.php?page=login&error=Invalid%20email.");
            die();
        }

        $regPasswd = "/^[A-z\d]{8,}$/";
        if(!preg_match($regPasswd, $_POST["password"])){
            header("Location: ../index.php?page=login&error=Invalid%20password.");
            die();
        }
        $sifrovanalozinka = md5($password);
        $korisnikObj = proveraLogovanja($email, $sifrovanalozinka);

        if($korisnikObj){
            $_SESSION['user'] = $korisnikObj;
            if ($korisnikObj->role_name == "Admin"){
                header("Location: ../index.php?page=admin");
//                die();
            }
            else{
                header("Location: ../index.php?page=home");
            }
        }
    }
    catch(PODException $exception){
        //http_response_code(500);
        $error = "Greška pri komunikaciji sa serverom, probajte kasnije ponovo.";
        header("Location: ../index.php?page=login&error=".$error);
        die();
    }
}
else{
    header("Location: ../index.php?page=home");
    die();
}