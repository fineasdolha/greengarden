<?php
session_start();
require_once('connection.php');
$db = new DAO();
$db->connection();

$categories = $db->queryResults('SELECT * FROM `t_d_categorie`');
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
</head>

<body>
    <nav class="navbar sticky-top bg-body-tertiary bg-dark" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">greengarden</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Log out</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>
    <?php if (isset($_SESSION['message-cart'])) {
        if ($_SESSION['message-cart'] != '') {  ?>
            <div class="alert alert-info text-center" role="alert">
                Product added to cart <a href="cart_view.php" class="btn btn-primary btn-sm">Click to see it now </a>
            </div>
    <?php }
    } ?>
    <div class="row">
        <div class="col-2 ms-2">
            <form>
                <h5 class="text-center my-2">Categories</h5>
                <nav id="navbar-example3" class="h-100 flex-column align-items-stretch pe-4 border-end">
                    <nav class="nav nav-pills flex-column">
                        <a class="nav-link text-center bg-light my-2"><button type="submit" class="btn" onchange="this.form.submit()" value="all" name="category-number">All categories</button></a>
                        <?php foreach ($categories as $row) { ?>
                            <a class="nav-link text-center bg-light my-2"><button type="submit" class="btn" onchange="this.form.submit()" value="<?php print($row['Id_Categorie']) ?>" name="category-number"><?php print($row['Libelle']); ?></button></a>
                        <?php  } ?>
                    </nav>
                </nav>
            </form>
        </div>

        <div class="col-8">
            <h5 class="text-center my-2">Products</h5>
            <div class="row align-items-start">
                <?php if ($ok) {
                    foreach ($products as $rowProduct) {  ?>
                        <div class="col-3">
                            <div class="card my-2" style="width: 18rem;">
                                <img src="media/<?php print($rowProduct['Photo']); ?>" class="card-img-top" alt="photo of <?php print($rowProduct['Nom_court']); ?>">
                                <form class="card-body" method="POST" action="cart_populate.php">
                                    <h5 class="card-title"><?php print($rowProduct['Nom_court']); ?> </h5>
                                    <h5 class="card-title"><?php print($rowProduct['Prix_Achat']); ?> €</h5>
                                    <p class="card-text"><?php print($rowProduct['Nom_Long']); ?></p>
                                    <button type="submit" value="<?php print($rowProduct['Id_Produit']); ?>" name="product" class="btn btn-primary">Add to cart</a>
                                </form>
                            </div>
                        </div>
                    <?php }  ?>
                <?php } else {  ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Sorry! No products in this category.</strong> We will do our best to bring more.
                    </div>
                <?php } ?>

            </div>
        </div>

    </div>

    <?php $_SESSION['message-cart'] = ''; ?>
    <script src="scripts/script.js"></script>
</body>

</html>