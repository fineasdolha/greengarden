<?php

header('content-type:application/json');
require_once('connection.php');
$db = new DAO;
$db->connection();
$sql = 'SELECT `Id_Produit`,`Nom_Long` ,`Nom_court`, `Photo`, `Prix_Achat`,`Id_Fournisseur`,`Id_Categorie` FROM `t_d_produit`';
$products = $db->queryResults($sql);
$product = [];

foreach ($products as $row) {

        $item=array();
        $item['id'] = $row['Id_Produit'];
        $item['name'] = $row['Nom_court'];
        //$item['tva']= $row['Taux_TVA'];
        $item['name-long']= $row['Nom_Long'];
        $item['photo']=$row['Photo'];
        $item['price']=$row['Prix_Achat'];
        $item['category']=$row['Id_Categorie'];
    
   $product[] = $item;

}

$return = $product;
echo json_encode($return);