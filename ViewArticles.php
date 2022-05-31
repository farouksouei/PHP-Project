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
  $sql_article = "SELECT * FROM `annonce_matriel`  ORDER BY id DESC";
  // Envoyer la requête au serveur
  $reponse_article = $con->query($sql_article);

  //redirect to the view car page with the id of the car when clicked on view



  ?>


  <div class="album py-5 bg-light">
    <h1 class="text-center">- Tous Matriel Disponibles -</h1>
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
                    <a href="ViewArticle.php?matriel_id=<?php echo $matriel['id']; ?>" name="View" class="btn btn-sm btn-outline-secondary">View</a>
                    <a href="" class="btn btn-sm btn-outline-secondary">Edit</a>
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