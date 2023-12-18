<?php
session_start();
require_once('connection.php');
$db = new DAO();
$db->connection();

$categories = $db->queryResults('SELECT * FROM `t_d_categorie` WHERE `Id_Categorie_Parent` IS null');
$ok = false;
if (isset($_GET['category-number']) && $_GET['category-number'] == 'all') {
    $products = $db->queryResults('SELECT `Id_Produit`,`Nom_Long` ,`Nom_court`, `Photo`, `Prix_Achat`,`Id_Fournisseur`,`Id_Categorie` FROM `t_d_produit`');
    $ok = true;
} else if (isset($_GET['category-number']) && $_GET['category-number'] != 'all') {
    $products = $db->queryResults('SELECT `Id_Produit`,`Nom_Long` ,`Nom_court`, `Photo`, `Prix_Achat`,`Id_Fournisseur`,`t_d_produit`.`Id_Categorie` 
    FROM `t_d_produit`
      JOIN `t_d_categorie` ON `t_d_categorie`.`Id_Categorie` = `t_d_produit`.`Id_Categorie`	
    WHERE `t_d_produit`.`Id_Categorie` = "' . $_GET['category-number'] . '" 
    OR `Id_Categorie_Parent` = "' . $_GET['category-number'] . '"');
    if (!empty($products)) {
        $ok = true;
    }
} else {
    $products = $db->queryResults('SELECT `Id_Produit`,`Nom_Long` ,`Nom_court`, `Photo`, `Prix_Achat`,`Id_Fournisseur`,`Id_Categorie` FROM `t_d_produit`');
    $ok = true;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link href="styles/style_management.css" rel="stylesheet" >
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    
</head>

<body>
<header>    
<nav class="navbar sticky-top navbar-expand-lg bg-body-tertiary bg-dark" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">greengarden</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Accueil</a>
                    </li>
                    <?php if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 2) { ?>
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Gestion
                    </a>
                    <form class="dropdown-menu" method="POST" action="management.php">
                    <li><a class="dropdown-item text-center my-1"><button type="submit" class="btn" onchange="this.form.submit()" value="orders" name="orders">Commandes</button></a></li>
                    <li><a class="dropdown-item text-center my-1"><button type="submit" class="btn" onchange="this.form.submit()" value="products" name="products">Produits</button></a></li>
                    <li><a class="dropdown-item text-center my-1"><button type="submit" class="btn" onchange="this.form.submit()" value="users" name="users">Utilisateurs</button></a></li>   
                    </form>
                    </li>
                    <?php  } ?>
                    <li class="nav-item dropdown d-flex">
                    <a class="nav-link dropdown-toggle me-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Mon compte
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="login.php">Connexion</a></li>
                        <li><a class="dropdown-item" href="register.php">Enregistrement</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php">Deconnexion</a></li>
                    </ul>
                    </li>

                    <!-- <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                     </form>     -->
                </ul>

            </div>

        </div>
    </nav>
    </header>
    <main>
    <?php if(isset($_POST['orders'])){$_SESSION['management']=$_POST['orders'];} elseif(isset($_POST['users'])){$_SESSION['management']=$_POST['users'];}elseif(isset($_POST['products'])){$_SESSION['management']=$_POST['products'];} ?>
    <h1 class="text-center text-white">Gestion <span id="gestion-span"><?php print($_SESSION['management']); ?></span></h1>                   
    <section class="container-fluid col-lg-10 p-3 table-dark shadow">    <table id="example" class="display table-dark" style="width:100%">
        <thead>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
    </table></section>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <span id="id-clicked"></span>
        <p id="details"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Modify</button>
      </div>
    </div>
  </div>
</div>
</main>
<script src="scripts/script_tables.js"></script>
</body>
</html>