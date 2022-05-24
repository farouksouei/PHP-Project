<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Sun Motors Register</title>
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="icon-font/lineicons.css">
  <link rel="stylesheet" href="css/style.css">
  <style type="text/css">
    #regiration_form fieldset:not(:first-of-type) {
      display: none;
    }
  </style>
</head>

<body>
  <?php include 'config/db.php' ?>
  <?php include 'config/utilities.php' ?>
  <?php
  // Récupérer le contenu du formulaire d'inscription
  if (!empty($_POST)) {
    //récupération des informations du formulaire
    // la fonctio  trim() permet de supprimer les espaces avant et après un texte
    $uname = test_input($_POST['username']);
    $umail = test_input($_POST['email']);
    $upass = test_input($_POST['password']);
    $unumero = test_input($_POST['numero']);
    $uaddress = test_input($_POST['address']);
    $upic = $_FILES['file'];

    $upic_filename = $_FILES['file']['name'];
    $upic_filetmpname = $_FILES['file']['tmp_name'];
    $upic_filesize = $_FILES['file']['size'];
    $upic_file_error = $_FILES['file']['error'];
    $upic_filetype = $_FILES['file']['type'];

    $upic_fileext = explode('.', $upic_filename);
    $upic_file_ext = strtolower(end($upic_fileext));

    $upic_allowed = array('jpg', 'jpeg', 'png');

    if (in_array($upic_file_ext, $upic_allowed)) {
      if ($upic_file_error === 0) {
        if ($upic_filesize < 50000) {
          $upic_file_newname = uniqid('', true) . '.' . $upic_file_ext;
          $upic_file_destination = 'src/img/' . $upic_file_newname;
          move_uploaded_file($upic_filetmpname, $upic_file_destination);
        } else {
          array_push($errors, "Votre photo est trop lourde");
        }
      } else {
        array_push($errors, "Il y a eu une erreur lors de l'envoi de votre photo");
      }
    } else {
      array_push($errors, "Votre photo n'est pas au bon format");
    }



    //Remplissage des messages d'erreurs dans un tableau
    $errors = [];
    $valid = true;

    if ($uname == "") {    // Vérifier username
      array_push($errors, "Vous devez saisir un nom d'utilisateur!");
      $valid = false;
    }

    if ($umail == "") {   // Vérifier email
      array_push($errors, "Vous devez saisir un email");
      $valid = false;
    } else if (!filter_var($umail, FILTER_VALIDATE_EMAIL)) {
      array_push($errors, "Vous devez saisir un email valide");
      $valid = false;
    }

    if ($upass == "") {    // Vérifier mot de passe
      array_push($errors, "Vous devez saisir un mot de passe");
      $valid = false;
    } else if (strlen($upass) < 6) {
      array_push($errors, "Le mot de passe doit avoir au moins 6 caractères");
      $valid = false;
    }
    if ($unumero == "") {    // Vérifier numero
      array_push($errors, "Vous devez saisir un numero");
      $valid = false;
    } else if (strlen($unumero) < 8) {
      array_push($errors, "Le numero doit avoir au moins 8 caractères");
      $valid = false;
    } else if (!is_numeric($unumero)) {
      array_push($errors, "Le numero doit etre un numero !!");
      $valid = false;
    }
    echo $unumero;

    if ($uaddress == "") {    // Vérifier address
      array_push($errors, "Vous devez saisir une adresse");
      $valid = false;
    }

    // Il n'y a pas d'erreurs
    // ON recherche si l'utilisateur existe déjà dans la base
    // La recherche se fait par username ou email
    if ($valid) {
      // Requête SQL
      $sql = "SELECT * FROM users
      WHERE username = :username OR email = :email";
      // Préparer la requête
      $stmt = $con->prepare($sql);
      // Lier les paramètres
      $stmt->bindParam(':username', $uname);
      $stmt->bindParam(':email', $umail);
      // Exécuter la requête
      $stmt->execute();
      // Récupérer le résultat
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      // Vérifier si l'utilisateur existe déjà
      if ($result) {
        if ($result['username'] == $uname) {
          array_push($errors, "Ce nom d'utilisateur existe déjà");
        }
        if ($result['email'] == $umail) {
          array_push($errors, "Cet email existe déjà");
        }
        echo $unumero;
      } else {

        //si l'utilisateur n'existe pas alors on l'enregistre dans la BD
        // On prépare la requête
        $sql = "INSERT INTO users (username, email, password, numero, location, photo_de_profil)
                            VALUES (:username, :email, :password, :numero, :address, :pic)";
        // Préparer la requête
        $stmt = $con->prepare($sql);
        // Lier les paramètres
        $stmt->bindParam(':username', $uname);
        $stmt->bindParam(':email', $umail);
        $stmt->bindParam(':password', $upass);
        $stmt->bindParam(':numero', $unumero);
        $stmt->bindParam(':address', $uaddress);
        $stmt->bindParam(':pic', $upic_file_newname);
        // Exécuter la requête
        if ($stmt->execute()) {
          // Redirection vers la page de connexion
          header('location: register.php');
        }
      }
    }
  }
  ?>
  <?php
  // S'il existe des messages d'erreurs, on les affiches
  if (!empty($errors)) {
    echo '<div class="alert alert-danger">';
    foreach ($errors as $error) {
      echo '<p><i class="lni lni-warning"></i> ' . $error . '</p>';
    }
    echo '</div>';
  }
  ?>
  <div class="signin-form">
    <div class="container">
      <form id="regiration_form" method="post" class="form-signin" novalidate action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
        <h2 class="form-signin-heading">Inscription</h2>
        <div class="progress">
          <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <hr />
        <fieldset>
          <h2 class="form-signin-heading">Step 1: Create your account</h2>
          <hr>
          <div class="form-group">
            <label class="form-signin-heading" for="username">Username</label>
            <input type="email" class="form-control" id="username" name="username" placeholder="Email">
          </div>
          <div class="form-group">
            <label class="form-signin-heading" for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
          </div>
          <div class="form-group">
            <label class="form-signin-heading" for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
          </div>
          <input type="button" name="data[password]" class="mt-2 next btn btn-primary" value="Next" />
        </fieldset>
        <fieldset>
          <h2 class="form-signin-heading"> Step 2: Add Personnel Details</h2>
          <hr>
          <div class="form-group">
            <label class="form-signin-heading" for="file">Upload your profile picture</label>
            <input type="file" class="form-control" name="file" placeholder="Browse for Picture">
          </div>
          <input type="button" name="previous" class="mt-2 previous btn btn-default" value="Previous" />
          <input type="button" name="next" class="mt-2 next btn btn-primary" value="Next" />
        </fieldset>
        <fieldset>
          <h2 class="form-signin-heading">Step 3: Contact Information</h2>
          <hr>
          <div class="form-group">
            <label class="form-signin-heading" for="numero">Mobile Number</label>
            <input type="text" class="form-control" id="numero" name="numero" placeholder="Mobile Number">
          </div>
          <div class="form-group">
            <label class="form-signin-heading" for="address">Address</label>
            <input type="text" class="form-control" name="address" placeholder="Communication Address"></input>
          </div>
          <input type="button" name="previous" class="mt-2 previous btn btn-default" value="Previous" />
          <button type="submit" class="btn btn-primary" name="btn-signup">
            <i class="lni lni-users"></i> S'inscrire
          </button>
        </fieldset>
        <label>Déjà inscrit ! <a href="index.php">Connexion</a></label>
      </form>
    </div>
  </div>
</body>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    var current = 1,
      current_step, next_step, steps;
    steps = $("fieldset").length;
    $(".next").click(function() {
      current_step = $(this).parent();
      next_step = $(this).parent().next();
      next_step.show();
      current_step.hide();
      setProgressBar(++current);
    });
    $(".previous").click(function() {
      current_step = $(this).parent();
      next_step = $(this).parent().prev();
      next_step.show();
      current_step.hide();
      setProgressBar(--current);
    });
    setProgressBar(current);
    // Change progress bar action
    function setProgressBar(curStep) {
      var percent = parseFloat(100 / steps) * curStep;
      percent = percent.toFixed();
      $(".progress-bar")
        .css("width", percent + "%")
        .html(percent + "%");
    }
  });
</script>

</html>