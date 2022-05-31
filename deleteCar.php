<?php
include 'config/db.php';
include 'config/utilities.php';
include 'config/session.php';
$id_car = $_GET['car_id'];
//delete car
$sql = "DELETE FROM annonce_voiture WHERE id=?";
$reponse = $con->prepare($sql);
$reponse->execute([$id_car]);
header("location: Profil.php");
