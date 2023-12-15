<?php 
session_start();
require_once('connection.php');
$db = new DAO();
$db->connection();

$productToAdd = $db-> queryResults('SELECT * FROM t_d_produit WHERE `Id_Produit` = "'.$_POST['product'].'"');
$_SESSION['"'.$productToAdd[0]['Id_Produit'].'"'] = $productToAdd;
$_SESSION['message-cart']=true;

header('location:index.php');
?>