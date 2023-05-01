<?php
    header("Content-type: application/json");
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        include "../config/connection.php";
        include "functions.php";
        try {
            $regName = "/^[A-ZŠĐŽĆČ][a-zšđžćč]{2,15}$/";
            if(!preg_match($regName, $_POST["firstName"])){
                header("Location: ../../index.php?page=register&error=Neispravno%20ime.");
                die();
            }

            if(!preg_match($regName, $_POST["lastName"])){
                header("Location: ../../index.php?page=register&error=Neispravno%20prezime.");
                die();
            }

            $regEmail = "/^[a-z]((\.|-|_)?[a-z0-9]){2,}@[a-z]((\.|-|_)?[a-z0-9]+){2,}\.[a-z]{2,6}$/i";
            if(!preg_match($regEmail, $_POST["email"])){
                header("Location: ../../index.php?page=register&error=Neispravan%20email.");
                die();
            }

            $regPasswd = "/^[A-z\d]{8,}$/";
            if(!preg_match($regPasswd, $_POST["password"])){
                header("Location: ../../index.php?page=register&error=Neispravna%20lozinka.");
                die();
            }
            $firstName = $_POST["firstName"];
            $lastName = $_POST["lastName"];
            $email = $_POST["email"];
            $password =  md5($_POST["password"]);

            try {
                global $conn;

                $query = $conn->prepare("SELECT email FROM user WHERE email = ?");
                $query->execute([$email]);
                $user = $query->fetch();

            } catch (PDOException $ex) {
                $error = "Greška pri komunikaciji sa serverom, probajte kasnije ponovo.";
                header("Location: ../../index.php?page=register&error=".$error);
            }
            if ($user) {
                if($user->email == $email){

                    $error = "Email je vec u upotrebi.";

                    header("Location: ../../index.php?page=register&error=vec_u_upotrebi");
                }
            }

            $sifrovanalozinka = md5($password);
            $unosKorisnika = unosKorisnika($firstName, $lastName, $email, $sifrovanalozinka);
            if($unosKorisnika){
                $_SESSION['user'] = $unosKorisnika;
                echo json_encode([
                    "user" =>1
                ]);
            }
        }
        catch(PODException $exception){
            http_response_code(500);
        }
    }
    else{
        http_response_code(404);
    }