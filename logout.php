<?php

	// On déconnecte l'utilisateur => Destruction de la session
  session_destroy();
  unset($_SESSION["user_session"]);

	//Puis on le redirige vers la page de connexion
  header('Location:index.php');
