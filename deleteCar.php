<?php
include 'config/db.php';
include 'config/utilities.php';
include 'config/session.php';
$id_car = $_GET['id_car'];
//delete car
$sql = "DELETE FROM compte WHERE id=?";
$reponse = $con->prepare($sql);
$reponse->execute([$id_car]);
header("location: Profil.php");
