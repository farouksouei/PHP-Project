<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="icon-font/lineicons.css">
  <link rel="stylesheet" href="style/style.css">
  <title>Sun Motors</title>
</head>

<body>
  <?php include 'config/db.php'; ?>
  <?php include_once 'templates/navbar.php' ?>
  <?php include 'config/utilities.php';
  //select all the data from the table a
  $user_id = $connected_user['id'];
  $sql = "SELECT * FROM `annonce_voiture` WHERE `id_user` = '$user_id'";
  $sql_matriel = "SELECT * FROM `annonce_matriel` WHERE `id_user` = '$user_id'";
  // Envoyer la requête au serveur
  $reponse = $con->query($sql);
  $reponse_article = $con->query($sql_matriel);

  //redirect to the view car page with the id of the car when clicked on view

  $connected_user

  ?>

  <div class="container my-5">
    <div class="row p-4 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded-3 border shadow-lg">
      <div class="col-lg-7 p-3 p-lg-5 pt-lg-3">
        <h1 class="display-4 fw-bold lh-1"><strong>Account of: </strong><?php echo $connected_user['username']; ?></h1>
        <p class="lead"><strong>Email: </strong><?php echo $connected_user['email']; ?></p>
        <p class="lead"><strong>Date Creation: </strong><?php echo $connected_user['date_creation']; ?></p>
        <p class="lead"><strong>Numero: </strong><?php echo $connected_user['numero']; ?></p>
        <p class="lead"><strong>Location: </strong><?php echo $connected_user['location']; ?></p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3">
          <button type="button" class="btn btn-primary btn-lg px-4 me-md-2 fw-bold">Delete</button>
          <button type="button" class="btn btn-outline-secondary btn-lg px-4">Update</button>
        </div>
      </div>
      <div class="col-lg-4 offset-lg-1 p-0 overflow-hidden shadow-lg">
        <img class="rounded-lg-5" src="src/img/<?php echo $connected_user['photo_de_profil']; ?>" alt="" width="720">
      </div>
    </div>
  </div>
  <div class="album py-5 bg-light">
    <h1 class="text-center">- Tous Tes Voiture Disponibles Pour Vente -</h1>
    <div class="container">
      <!--  -->

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

        <?php while ($voiture = $reponse->fetch(PDO::FETCH_ASSOC)) : ?>
          <div class="col">
            <div class="card shadow-sm">
              <img class="bd-placeholder-img card-img-top" width="100%" height="225" src="src/img/<?php echo $voiture['photo']; ?>" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
              <title></title>
              <rect width="100%" height="100%" fill="#55595c" /><text x="50%" y="50%" fill="#eceeef" dy=".3em"> </text>
              </img>

              <div class="card-body">
                <p class="card-text"><strong>Modele:</strong> <?php echo $voiture['manifacturer']; ?> <?php echo $voiture['modele']; ?></p>
                <p class="card-text"><strong>Condition:</strong> <?php echo $voiture['condition_voiture']; ?></p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <a href="ViewArticle.php?car_id=<?php echo $voiture['id']; ?>" name="View" class="btn btn-sm btn-outline-secondary">View</a>
                    <a href="updateFormArticle.php?car_id=<?php echo $voiture['id']; ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                    <a href="deleteArticle.php?car_id=<?php echo $voiture['id']; ?>" class="btn btn-sm btn-outline-secondary">Delete</a>
                  </div>
                  <?php
                  $sql_voiture = "SELECT * FROM `users` WHERE id = $voiture[id_user]";
                  $reponse_voiture = $con->query($sql_voiture);
                  $user = $reponse_voiture->fetch(PDO::FETCH_ASSOC);
                  ?>
                  <p class="card-text"><strong>Vendeur:</strong> <?php echo $user['username']; ?></p>
                  <small class="text-muted"><?php echo $voiture['price']; ?> DT</small>
                </div>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
  </div>
  <div class="album py-5 bg-light">
    <h1 class="text-center">- Matriel Disponibles -</h1>
    <div class="container">
      <!--  -->

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

        <?php while ($matriel = $reponse_article->fetch(PDO::FETCH_ASSOC)) : ?>
          <div class="col">
            <div class="card shadow-sm">
              <img class="bd-placeholder-img card-img-top" width="100%" height="225" src="src/img/<?php echo $matriel['photo_matriel']; ?>" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
              <title></title>
              <rect width="100%" height="100%" fill="#55595c" /><text x="50%" y="50%" fill="#eceeef" dy=".3em"> </text>
              </img>

              <div class="card-body">
                <p class="card-text"><strong>Modele:</strong> <?php echo $matriel['type']; ?></p>
                <p class="card-text"><strong>Condition:</strong> <?php echo $matriel['condition_matriel']; ?></p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <a href="updateFormCar.php?car_id=<?php echo $voiture['id']; ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                    <a href="deleteCar.php?car_id=<?php echo $voiture['id']; ?>" class="btn btn-sm btn-outline-secondary">Delete</a>
                  </div>
                  <?php
                  $sql_matriel = "SELECT * FROM `users` WHERE id = $matriel[id_user]";
                  $reponse_matriel = $con->query($sql_matriel);
                  $user = $reponse_matriel->fetch(PDO::FETCH_ASSOC);
                  ?>
                  <p class="card-text"><strong>Vendeur:</strong> <?php echo $user['username']; ?></p>
                  <small class="text-muted"><?php echo $matriel['price']; ?> DT</small>
                </div>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
  </div>


</body>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="https://kit.fontawesome.com/19330062aa.js" crossorigin="anonymous"></script>

</html>