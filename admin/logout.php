<?php
session_start();

unset($_SESSION['montblancadmin']);
unset($_SESSION['error']);
header("Location: login.php");
?>