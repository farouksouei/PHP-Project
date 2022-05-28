<?php
require 'db.php';
// Si l'utilisateur n'est pas connecté on le redirige vers la page de connexion
// Il suffit de tester si la variable $_SESSION["user_session"] existe
if (!isset($_SESSION)) {
  session_start();
}
if (!isset($_SESSION["user_session"])) {
  // S'il n'existe pas dans la variable session
  // on le redirige vers la page de connexion
  header('Location:index.php');
}

// ICI ça veut dire que l'utilisateur est connecté
// Récupérer les donnés de l'utilisateur connecté
$user_id = $_SESSION["user_session"];
$sql = "SELECT * FROM users WHERE id = $user_id";
$reponse = $con->query($sql);

$connected_user = $reponse->fetch(PDO::FETCH_ASSOC);
