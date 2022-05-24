<?php include 'config/db.php'; ?>
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
  <?php include_once 'templates/navbar.php' ?>
  <?php include 'config/utilities.php';
  echo 'test';
  echo $_SESSION["user_session"]; ?>
  <?php var_dump($_SESSION); ?>

</body>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.min.js"></script>

</html>