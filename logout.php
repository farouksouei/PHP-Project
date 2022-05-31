<?php

// On déconnecte l'utilisateur => Destruction de la session
session_start();
unset($_SESSION["user_session"]);
session_destroy();
//Puis on le redirige vers la page de connexion
header('Location:index.php');
