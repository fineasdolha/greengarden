<?php 
require_once('connection.php');
$db = new DAO();
$db->connection();
//$_GET['category'] = $_GET;
var_dump($_GET['category-number']);
return $_GET['category-number'];
header('location:index.php');
?>