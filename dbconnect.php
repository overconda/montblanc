<?php
$dbh="";
try {
      $dbh = new PDO('mysql:host=localhost;dbname=overalls_wp393', 'overalls_wp393', '1c5S(1]pah');
    $dbh->query("SET NAMES 'UTF8' ");
} catch (PDOException $e) {
    print "<Br>Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>
