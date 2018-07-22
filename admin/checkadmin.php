<?php
session_start();

$U = "admin";
$P = "QpMyQ4xJ";

$u = $_POST['username'];
$p = $_POST['password'];

if( $U != $u || $P != $p){
    // incorrect
    unset($_SESSION['montblancadmin']);
    $_SESSION['error'] = 1;
    header("Location: login.php");
}else{
    // correct
    $_SESSION['montblancadmin'] = "admin";
    $_SESSION['error'] = "";
    header("Location: index.php");
}
?>