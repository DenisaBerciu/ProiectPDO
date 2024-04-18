<?php
session_start();
$status=0;
include 'connection.php';
if(isset($_POST['register-button'])){
    $nume=$_POST['nume'];
    $pass=$_POST['password'];
    $usertype='utilizator';
    $query="SELECT * FROM koffee WHERE nume=:nume";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':nume', $nume, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(count($result) > 0){
        $status=1;
        $_SESSION['alert'] = 'Numele de utilizator este deja luat.';
        header('location:registerform.php');
        exit();
    }
    if($status==0){
        if($nume!=NULL && $pass!=NULL){
            $query="INSERT INTO koffee (nume, parola, utilizator) VALUES (:nume, :pass, :usertype)";
            $stmt = $con->prepare($query);
            $stmt->bindParam(':nume', $nume, PDO::PARAM_STR);
            $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
            $stmt->bindParam(':usertype', $usertype, PDO::PARAM_STR);
            if($stmt->execute()){
                $_SESSION['alert'] = 'Contul nou a fost creat. Te rog să te autentifici.';
                header('location:login.php');
                exit();
            }
            else{
                $_SESSION['alert'] = 'Eroare: ' . $query . '<br>' . $stmt->errorInfo()[2];
                header('location:registerform.php');
                exit();
            }
        }
        else{
            $_SESSION['alert'] = 'Te rog să introduci valori.';
            header('location:registerform.php');
            exit();
        }
    }
}
?>
