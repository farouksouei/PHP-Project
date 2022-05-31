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
  <?php include 'config/session.php' ?>
  <?php include 'templates/navbar.php' ?>
  <?php
  // Récupérer le contenu du formulaire d'inscription
  if (!empty($_POST)) {
    //récupération des informations du formulaire
    // la fonctio  trim() permet de supprimer les espaces avant et après un texte
    $model = test_input($_POST['modele']);
    $manifacturer = test_input($_POST['manifacturer']);
    $kilometrage = test_input($_POST['kilometrage']);
    $condition_voiture = test_input($_POST['condition_voiture']);
    $nombre_cylindre = test_input($_POST['nombre_cylindre']);
    $couple = test_input($_POST['couple']);
    $description = test_input($_POST['description']);
    $litre = test_input($_POST['litre']);
    $price = test_input($_POST['price']);
    $upic = $_FILES['file'];

    $upic_filename = $_FILES['file']['name'];
    $upic_filetmpname = $_FILES['file']['tmp_name'];
    $upic_filesize = $_FILES['file']['size'];
    $upic_file_error = $_FILES['file']['error'];
    $upic_filetype = $_FILES['file']['type'];

    $upic_fileext = explode('.', $upic_filename);
    $upic_file_ext = strtolower(end($upic_fileext));

    $upic_allowed = array('jpg', 'jpeg', 'png');
    //Remplissage des messages d'erreurs dans un tableau
    $errors = [];
    $valid = true;

    if (in_array($upic_file_ext, $upic_allowed)) {
      if ($upic_file_error === 0) {
        if ($upic_filesize < 500000) {
          $upic_file_newname = uniqid('', true) . '.' . $upic_file_ext;
          var_dump($upic_file_newname);
          $upic_file_destination = 'src/img/' . $upic_file_newname;
          move_uploaded_file($upic_filetmpname, $upic_file_destination);
        } else {
          array_push($errors, "Votre photo est trop lourde");
          $valid = false;
        }
      } else {
        array_push($errors, "Il y a eu une erreur lors de l'envoi de votre photo");
        $valid = false;
      }
    } else {
      array_push($errors, "Votre photo n'est pas au bon format");
      $valid = false;
    }


    if ($manifacturer == "") {    // Vérifier username
      array_push($errors, "Vous devez saisir un nom de constructeur");
      $valid = false;
    }

    if ($model == "") {    // Vérifier username
      array_push($errors, "Vous devez saisir un nom de modèle");
      $valid = false;
    }

    if ($kilometrage == "") {    // Vérifier username
      array_push($errors, "Vous devez saisir un kilométrage");
      $valid = false;
    } else if (!is_numeric($kilometrage)) {
      array_push($errors, "Le numero doit etre un numero !!");
      $valid = false;
    } else if ($kilometrage < 0) {
      array_push($errors, "Le numero doit etre positif !!");
      $valid = false;
    } else if ($kilometrage > 1000000) {
      array_push($errors, "Le numero doit etre inferieur a 1000000 !!");
      $valid = false;
    }

    if ($condition_voiture == "") {    // Vérifier username
      array_push($errors, "Vous devez saisir une condition de voiture");
      $valid = false;
    }

    if ($nombre_cylindre == "") {    // Vérifier username
      array_push($errors, "Vous devez saisir un nombre de cylindre");
      $valid = false;
    } else if (!is_numeric($nombre_cylindre)) {
      array_push($errors, "Le numero de cylindre doit etre un numero !!");
      $valid = false;
    } else if ($nombre_cylindre < 0) {
      array_push($errors, "Le numero de cylindre doit etre positif !!");
      $valid = false;
    } else if ($nombre_cylindre > 12) {
      array_push($errors, "Le numero de cylindre doit etre inferieur a 12 !!");
      $valid = false;
    }

    if ($couple == "") {    // Vérifier username
      array_push($errors, "Vous devez saisir un couple");
      $valid = false;
    } else if (!is_numeric($couple)) {
      array_push($errors, "Le numero de couple doit etre un numero !!");
      $valid = false;
    } else if ($couple < 0) {
      array_push($errors, "Le numero de couple doit etre positif !!");
      $valid = false;
    } else if ($couple > 2000) {
      array_push($errors, "Le numero de couple doit etre inferieur a 100 !!");
      $valid = false;
    }

    if ($description == "") {    // Vérifier username
      array_push($errors, "Vous devez saisir une description");
      $valid = false;
    }

    if ($litre == "") {    // Vérifier username
      array_push($errors, "Vous devez saisir un litre");
      $valid = false;
    } else if (!is_numeric($litre)) {
      array_push($errors, "Le numero de litre doit etre un numero !!");
      $valid = false;
    } else if ($litre < 0) {
      array_push($errors, "Le numero de litre doit etre positif !!");
      $valid = false;
    } else if ($litre > 10) {
      array_push($errors, "Le numero de litre doit etre inferieur a 100 !!");
      $valid = false;
    }

    if ($price == "") {    // Vérifier username
      array_push($errors, "Vous devez saisir un prix");
      $valid = false;
    } else if (!is_numeric($price)) {
      array_push($errors, "Le numero de prix doit etre un numero !!");
      $valid = false;
    } else if ($price < 0) {
      array_push($errors, "Le numero de prix doit etre positif !!");
      $valid = false;
    } else if ($price > 1000000) {
      array_push($errors, "Le numero de prix doit etre inferieur a 1000000 !!");
      $valid = false;
    }
    if ($valid) {
      $sql = "INSERT INTO annonce_voiture (id_user,manifacturer, modele, kilometrage, condition_voiture, nombre_cylindre, couple, description, litre, price, photo) VALUES (:id_user,:manifacturer, :model, :kilometrage, :condition_voiture, :nombre_cylindre,:couple, :description, :litre, :price, :pic_file_newname)";
      $stmt = $con->prepare($sql);
      $id_user = $connected_user['id'];
      $stmt->bindParam(':id_user', $id_user);
      $stmt->bindParam(':manifacturer', $manifacturer);
      $stmt->bindParam(':model', $model);
      $stmt->bindParam(':kilometrage', $kilometrage);
      $stmt->bindParam(':condition_voiture', $condition_voiture);
      $stmt->bindParam(':nombre_cylindre', $nombre_cylindre);
      $stmt->bindParam(':couple', $couple);
      $stmt->bindParam(':description', $description);
      $stmt->bindParam(':litre', $litre);
      $stmt->bindParam(':price', $price);
      $stmt->bindParam(':pic_file_newname', $upic_file_newname);
      if ($stmt->execute()) {
        // Redirection vers la page de connexion
        header('location: index.php');
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
      <form id="regiration_form" method="post" novalidate action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
        <h2 class="form-signin-heading">Inscription</h2>
        <div class="progress">
          <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <hr />
        <fieldset>
          <h2 class="form-signin-heading">Step 1: Information Generale Sur La vehicule :</h2>
          <hr>
          <div class="form-group">
            <label class="form-signin-heading" for="modele">Model</label>
            <input type="text" class="form-control" id="modele" name="modele" placeholder="Model">
          </div>
          <div class="form-group">
            <label class="form-signin-heading" for="manifacturer">Manifacturer</label>
            <input type="text" class="form-control" id="manifacturer" name="manifacturer" placeholder="manifacturer">
          </div>
          <div class="form-group">
            <label class="form-signin-heading" for="kilometrage">Kilometrage</label>
            <input type="text" class="form-control" id="email" name="kilometrage" placeholder="Kilometrage">
          </div>
          <div class="form-group">
            <label class="form-signin-heading" for="condition_voiture">Condition</label>
            <select class="form-control" id="condition_voiture" name="condition_voiture" placeholder="Condition">
              <option value="">--Select--</option>
              <option value="Neuf">Neuf</option>
              <option value="Occasion">Occasion</option>
            </select>
          </div>
          <input type="button" name="data[password]" class="mt-2 next btn btn-primary" value="Next" />
        </fieldset>
        <fieldset>
          <h2 class="form-signin-heading"> Step 2: Ajouter Une Photo !</h2>
          <hr>
          <div class="form-group">
            <label class="form-signin-heading" for="file">Upload Ta Voiture !</label>
            <input type="file" class="form-control" name="file" placeholder="Browse for Picture">
          </div>
          <input type="button" name="previous" class="mt-2 previous btn btn-default" value="Previous" />
          <input type="button" name="next" class="mt-2 next btn btn-primary" value="Next" />
        </fieldset>
        <fieldset>
          <h2 class="form-signin-heading">Step 3: Plus de Detail </h2>
          <hr>
          <div class="form-group">
            <label class="form-signin-heading" for="nombre_cylindre">Nombre Cylindre</label>
            <select class="form-control" id="nombre_cylindre" name="nombre_cylindre" placeholder="Nombre Cylindre">
              <option value="">--Select--</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="8">8</option>
              <option value="8">10</option>
              <option value="8">12</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-signin-heading" for="litre">Litre</label>
            <input type="text" class="form-control" name="litre" placeholder="Litre"></input>
          </div>
          <div class="form-group">
            <label class="form-signin-heading" for="couple">couple</label>
            <input type="text" class="form-control" name="couple" placeholder="couple"></input>
          </div>
          <div class="form-group">
            <label class="form-signin-heading" for="description">description</label>
            <textarea class="form-control" name="description" placeholder="description"></textarea>
          </div>
          <div class="form-group">
            <label class="form-signin-heading" for="price">Prix</label>
            <input type="text" class="form-control" name="price" placeholder="Prix"></input>
          </div>
          <input type="button" name="previous" class="mt-2 previous btn btn-default" value="Previous" />
          <button type="submit" class="btn btn-primary" name="btn-signup">
            <i class="lni lni-users"></i> Ajouter Voiture
          </button>
        </fieldset>
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