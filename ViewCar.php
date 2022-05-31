<?php include_once 'config/utilities.php'; ?>
<?php include_once 'config/db.php'; ?>
<?php include_once 'config/session.php' ?>
<!DOCTYPE html>
<html lang="en">
<?php
//get car id
$car_id = $_GET['car_id'];


$sql = "SELECT * FROM `annonce_voiture`
      WHERE id = $car_id";
// Préparer la requête
$stmt = $con->prepare($sql);
// Lier les paramètres

// Exécuter la requête
$stmt->execute();

$car = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="icon-font/lineicons.css">
  <link rel="stylesheet" href="style/style.css">
  <title>View Article</title>
</head>


<body>
  <?php include_once 'templates/navbar.php'; ?>
  <div class="container col-xxl-8 px-4 py-5">
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
      <div class="col-10 col-sm-8 col-lg-6">
        <img src="src/img/<?php echo $car['photo']; ?>" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
      </div>
      <div class="col-lg-6">
        <h1 class="display-5 fw-bold lh-1 mb-3"><strong>Modele:</strong> <?php echo $car['manifacturer']; ?> <?php echo $car['modele']; ?></h1>
        <h4 class="lead">Condition: <?php echo $car['condition_voiture']; ?></h4>
        <h4 class="lead">Kilometrage: <?php echo $car['kilometrage']; ?> kilometre</h4>
        <h4 class="lead">Nombre de cylyindre: <?php echo $car['nombre_cylindre']; ?> en V</h4>
        <h4 class="lead">couple: <?php echo $car['couple']; ?> kwh</h4>
        <h2 class="lead">Prix: <?php echo $car['price']; ?> DT</h2>
        <p class="lead">Description: <?php echo $car['description']; ?></p>
        <?php
        $sql_voiture = "SELECT * FROM `users` WHERE id = $car[id_user]";
        $reponse_voiture = $con->query($sql_voiture);
        $user = $reponse_voiture->fetch(PDO::FETCH_ASSOC);
        ?>
        <p class="lead">Propriétaire: <?php echo $user['username']; ?></p>
        <p class="lead">Email: <?php echo $user['email']; ?></p>
        <p class="lead">Telephone: +216<?php echo $user['numero']; ?></p>
        <p class="lead">Adresse: <?php echo $user['location']; ?></p>
      </div>
    </div>
  </div>
</body>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="https://kit.fontawesome.com/19330062aa.js" crossorigin="anonymous"></script>

</html>