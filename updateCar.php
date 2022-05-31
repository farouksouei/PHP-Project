<?php

include 'config/db.php';
include 'config/utilities.php';
include 'config/session.php';
$id_car = $_GET['id_car'];

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
  $sql = "UPDATE annonce_voiture SET id_user=:id_user,
                                      manifacturer=:manifacturer, 
                                      modele=:model, 
                                      kilometrage=:kilometrage, 
                                      condition_voiture=:condition_voiture, 
                                      nombre_cylindre=:nombre_cylindre, 
                                      couple=:couple, 
                                      description=:description, 
                                      litre=:litre, 
                                      price=:price,
                                      photo=:pic_file_newname WHERE id = :id_car";
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
  $stmt->bindParam(':id_car', $id_car);
  if ($stmt->execute()) {
    // Redirection vers la page de connexion
    header('location: Profil.php');
  }
}
