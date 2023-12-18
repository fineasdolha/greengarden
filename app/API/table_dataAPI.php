<?php
session_start();
header('content-type:application/json');
require_once('../connection.php');
$db = new DAO;
$db->connection();

if ($_SESSION['management'] == 'orders') {
    $sql = 'SELECT `Id_Commande`, `Num_Commande`, `Date_Commande`, `Libelle_Statut`, `Id_Client`, `Libelle_TypePaiement` 
                                                    FROM `t_d_commande`
                                                    JOIN `t_d_statut_commande`
                                                    JOIN  `t_d_type_paiement`
                                                    WHERE  `t_d_commande`.`Id_Statut` = `t_d_statut_commande`.`Id_Statut`
                                                    AND `t_d_commande`.`Id_TypePaiement` = `t_d_type_paiement`.`Id_TypePaiement`';
} elseif ($_SESSION['management'] == 'products') {
    $sql = 'SELECT `Id_Produit`, `Taux_TVA`, `Nom_court`, `Prix_Achat`, `Nom_Fournisseur`, `Libelle` 
    FROM `t_d_produit`
    JOIN `t_d_fournisseur`
    JOIN  `t_d_categorie`
    WHERE  `t_d_produit`.`Id_Fournisseur` = `t_d_fournisseur`.`Id_Fournisseur`
    AND `t_d_produit`.`Id_Categorie` = `t_d_categorie`.`Id_Categorie`';
} elseif ($_SESSION['management'] == 'users') {
}



$data = $db->queryResults($sql);
$formattedData = [];

foreach ($data as $row) {

    $item = array();
    $item["0"] = $row[0];
    $item["1"] = $row[1];
    $item["2"] = $row[2];
    $item["3"] = $row[3];
    $item["4"] = $row[4];
    $item["5"] = $row[5];

    $formattedData[] = $item;
}

$return = $formattedData;
echo json_encode($return);
