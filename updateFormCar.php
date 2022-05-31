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
  $id = test_input($_GET['car_id']);
  $update = true;
  $sql = "SELECT * FROM annonce_voiture WHERE id=?";
  $reponse = $con->prepare($sql);
  $reponse->execute([$id]);
  $car = $reponse->fetch(PDO::FETCH_ASSOC);
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
      <form id="regiration_form" method="post" novalidate action="updateCar.php?id_car=<?php echo $car['id']; ?>" enctype="multipart/form-data">
        <h2 class="form-signin-heading">Mise A jour De la vehicule de <?php echo $connected_user['username']; ?></h2>
        <div class="progress">
          <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <hr />
        <fieldset>
          <h2 class="form-signin-heading">Step 1: Information Generale Sur La vehicule :</h2>
          <hr>
          <div class="form-group">
            <label class="form-signin-heading" for="modele">Model</label>
            <input type="text" class="form-control" id="modele" name="modele" placeholder="Model" value="<?php echo $car['modele']; ?>">
          </div>
          <div class="form-group">
            <label class="form-signin-heading" for="manifacturer">Manifacturer</label>
            <input type="text" class="form-control" id="manifacturer" name="manifacturer" placeholder="manifacturer" value="<?php echo $car['manifacturer']; ?>">
          </div>
          <div class="form-group">
            <label class="form-signin-heading" for="kilometrage">Kilometrage</label>
            <input type="text" class="form-control" id="email" name="kilometrage" placeholder="Kilometrage" value="<?php echo $car['kilometrage']; ?>">
          </div>
          <div class="form-group">
            <label class="form-signin-heading" for="condition_voiture">Condition</label>
            <select class="form-control" id="condition_voiture" name="condition_voiture" placeholder="Condition" value="<?php echo $car['condition_voiture']; ?>">
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
            <input type="file" class="form-control" name="file" placeholder="Browse for Picture" value="<?php echo $car['photo']; ?>">
          </div>
          <input type=" button" name="previous" class="mt-2 previous btn btn-default" value="Previous" />
          <input type="button" name="next" class="mt-2 next btn btn-primary" value="Next" />
        </fieldset>
        <fieldset>
          <h2 class="form-signin-heading">Step 3: Plus de Detail </h2>
          <hr>
          <div class="form-group">
            <label class="form-signin-heading" for="nombre_cylindre">Nombre Cylindre</label>
            <select class="form-control" id="nombre_cylindre" name="nombre_cylindre" placeholder="Nombre Cylindre" value="">
              <option value="<?php echo $car['nombre_cylindre']; ?>">--Select--</option>
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
            <input type="text" class="form-control" name="litre" placeholder="Litre" value="<?php echo $car['litre']; ?>"></input>
          </div>
          <div class="form-group">
            <label class="form-signin-heading" for="couple">couple</label>
            <input type="text" class="form-control" name="couple" placeholder="couple" value="<?php echo $car['couple']; ?>"></input>
          </div>
          <div class="form-group">
            <label class="form-signin-heading" for="description">description</label>
            <textarea class="form-control" name="description" placeholder="description" value="<?php echo $car['description']; ?>"></textarea>
          </div>
          <div class="form-group">
            <label class="form-signin-heading" for="price">Prix</label>
            <input type="text" class="form-control" name="price" placeholder="Prix" value="<?php echo $car['price']; ?>"></input>
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