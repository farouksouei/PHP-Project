<?php
session_start();
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Login : Atelier 4</title>
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="icon-font/lineicons.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <?php include 'config/db.php' ?>
  <?php include 'config/utilities.php' ?>
  <?php
  // Récupérer le contenu du formulaire
  if (!empty($_POST)) {
    $uname = test_input($_POST['uname_email']);
    $umail = test_input($_POST['uname_email']);
    $upass = test_input($_POST['password']);

    // On essaie de connecter l'utilisateur
    // On vérifie si le login/email avec le mot de passe existe ou non dans la BD
    // On prépare la requête SQL
    $sql = "SELECT * FROM users
                WHERE username = '$uname'
                OR email = '$umail' LIMIT 1"; // LIMIT 1 c'est à dire récupérer une seule ligne

    // Envoyer la requête au serveur
    $reponse = $con->query($sql);

    // On récupère le résultat
    $user = $reponse->fetch(PDO::FETCH_ASSOC);

    // On vérifie sont mot de passe saisie avec celui enregistré dans la base de données
    if ($upass == $user['password']) {
      // Si le mot de passe existe
      // alors on lui crée une session
      $_SESSION["user_session"] = $user['id'];

      // Redirection
      header('Location:index.php');
    } else {
      // Si les informations sont erronées
      $error = "Informations erronnées !";
    }
  }
  ?>
  <div class="signin-form">
    <div class="container">
      <form class="form-signin" method="post" id="login-form">
        <h2 class="form-signin-heading">Connexion</h2>
        <hr>
        <div id="error">
          <?php
          //Si la variable $error existe on l'affiche
          if (isset($error)) {
          ?>
            <div class="alert alert-danger">
              <i class="lni lni-warning"></i> <?php echo $error ?>
            </div>
          <?php
          }
          ?>
        </div>
        <div class="row mb-1">
          <input type="text" class="form-control" name="uname_email" placeholder="Login ou E-mail" required />
          <span id="check-e"></span>
        </div>
        <div class="row mb-3">
          <input type="password" class="form-control" name="password" placeholder="mot de passe" />
        </div>
        <div class="row mb-1">
          <button type="submit" name="btn-login" class="btn btn-primary">
            <i class="lni lni-enter"></i> Connexion
          </button>
        </div>
        <br>
        <label>Vous n'avez pas un compte ! <a href="sign-up.php">Inscription</a></label>
      </form>

    </div>
  </div>
</body>

</html>