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
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
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
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categories
                    </a>
                    <form class="dropdown-menu">
                    <li><a class="dropdown-item text-center my-1"><button type="submit" class="btn" onchange="this.form.submit()" value="all" name="category-number">All categories</button></a></li>
                    <?php foreach ($categories as $row) { ?>
                        <li><a class="dropdown-item text-center  my-1"><button type="submit" class="btn" onchange="this.form.submit()" value="<?php print($row['Id_Categorie']) ?>" name="category-number"><?php print($row['Libelle']); ?></button></a></li>
                    <?php  } ?>   
                    </form>
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
    <?php if (isset($_SESSION['message-cart'])) {
        if ($_SESSION['message-cart'] != '') {  ?>
            <div class="alert alert-info text-center" role="alert">
                Product added to cart <a href="cart_view.php" class="btn btn-primary btn-sm">Click to see it now </a>
            </div>
    <?php }
    } ?>
    <section class="hero">
        <div class="hero-inner">
            <h1>Jardin</h1>
            <h2>Et tout ce que on a besoin pour l'entretenir!</h2>
            <a href="#all-products" class="btn">Explorer</a>
        </div>
    </section>
    <div class="container">
	<div class="row">
		<div class="col-md-12">
			<h2>Trending <b>Products</b></h2>
			<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="0">
			<!-- Carousel indicators -->
			<ol class="carousel-indicators">
				<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				<li data-target="#myCarousel" data-slide-to="1"></li>
				<li data-target="#myCarousel" data-slide-to="2"></li>
			</ol>   
			<!-- Wrapper for carousel items -->
			<div class="carousel-inner">
				<div class="carousel-item active">
					<div class="row">
                    <?php if ($ok) {
                    foreach ($products as $rowProduct) {  ?>	
                    <div class="col-sm-3">
							<div class="thumb-wrapper">
								<div class="img-box">
                                <img src="media/<?php print($rowProduct['Photo']); ?>" class="img-fluid" alt="">
								</div>
								<div class="thumb-content">
									<h4><?php print($rowProduct['Nom_court']); ?></h4>
									<p class="item-price"><span><?php print($rowProduct['Prix_Achat']); ?> €</span></p>
									<div class="star-rating">
										<ul class="list-inline">
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star-o"></i></li>
										</ul>
									</div>
									<a href="#" class="btn btn-primary">Add to Cart</a>
								</div>						
							</div>
						
                        </div>
                        <?php }  ?>
                <?php  }   ?> 
					</div>
				</div>
			</div>
			<!-- Carousel controls -->
			<a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
				<i class="fa fa-angle-left"></i>
			</a>
			<a class="carousel-control-next" href="#myCarousel" data-slide="next">
				<i class="fa fa-angle-right"></i>
			</a>
		</div>
		</div>
	</div>
</div>
    
    
    
    
    <section id="all-products" class="row">
        <div class="col">
            <h1 class="text-center text-light my-5">Produits</h1>
            <div class="row align-items-start">
                <?php if ($ok) {
                    foreach ($products as $rowProduct) {  ?>
                        <div class="col">
                            <div class="card my-2 rounded-0" style="width: 18rem;">
                                <img src="media/<?php print($rowProduct['Photo']); ?>" class="card-img-top" alt="photo of <?php print($rowProduct['Nom_court']); ?>">
                                <form class="card-body" method="POST" action="cart_populate.php">
                                    <h5 class="card-title"><?php print($rowProduct['Nom_court']); ?> </h5>
                                    <h5 class="card-title"><?php print($rowProduct['Prix_Achat']); ?> €</h5>
                                    <p class="card-text"><?php print($rowProduct['Nom_Long']); ?></p>
                                    <button type="submit" value="<?php print($rowProduct['Id_Produit']); ?>" name="product" class="btn btn-secondary rounded-0">Ajouter au panier</a>
                                </form>
                            </div>
                        </div>
                    <?php }  ?>
                <?php } else {  ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Oops. Pas des produits pour cette categorie!</strong>
                    </div>
                <?php } ?>

            </div>
        </div>

    </div>

    <?php $_SESSION['message-cart'] = ''; ?>
    <script src="scripts/script.js"></script>
</body>

</html>