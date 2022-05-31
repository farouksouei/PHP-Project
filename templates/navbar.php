<?php
require 'config/db.php';
require 'config/session.php';
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><img src="src/img/LogoVer1.png" height="28px"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="ViewCars.php">Tout Les Voitures</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="ViewArticles.php">Tout Les Articles</a>
        </li>
        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li> -->

        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>
        <?php if (isset($_SESSION['user_session'])) {
          $sql = "SELECT * FROM users WHERE id = '$_SESSION[user_session]'";
          $reponse = $con->query($sql);
          $connected_user = $reponse->fetch(PDO::FETCH_ASSOC);
          echo '<li class="nav-item dropdown">';
          echo '<a class="mx-2 nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">';
          $profile_image = $connected_user['photo_de_profil'];
          echo '<img src="src/img/' . $profile_image . '" alt="photo de profil" class="mx-3 rounded-circle" width="30px" height="30px">';
          echo $connected_user['username'];
          echo "</a>";
          echo '<ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
          echo '<li><a class="dropdown-item" href="AddArticle.php">Ajouter Un Article</a></li>';
          echo '  <li><a class="dropdown-item" href="AddVoiture.php">Ajouter Une Voiture</a></li>';
          echo '  <li><a class="dropdown-item" href="Profil.php">Voir Mon Profil</a></li>';
          echo '<li><hr class="dropdown-divider"></li>';
          echo '<li><a class="dropdown-item" href="logout.php">Log Out</a></li>';
          echo '</ul>';
          echo '</li>';
        }
        echo "</ul>";

        echo '<form class="d-flex">';
        echo '<input class="form-control me-2" method="post" action="search.php" type="search" placeholder="Search" aria-label="Search">';
        echo '<button class="btn btn-outline-success" type="submit">Search</button>';
        echo '</form>';
        ?>
    </div>
  </div>
</nav>