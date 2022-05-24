<?php
try {
  // Set sessions
  if (!isset($_SESSION)) {
    session_start();
  }
  // Connexion à la base de données
  $con = new PDO('mysql:host=localhost;dbname=Sun_Motors;charset=utf8', 'root', '');
} catch (Exception $e) {
  die('Erreur de connexion.' . $e->getMessage());
}
