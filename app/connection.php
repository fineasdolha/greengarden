<?php
class DAO {

	
	private $host="127.0.0.1";
	private $user="root";
	private $password="";
	private $database="greengarden";
	private $charset="utf8";

//instance courante de la connexion
private $connection;

//stockage de l'erreur éventuelle du serveur mysql
private $error;

public function __construct() {

}

/* méthode de connexion à la base de donnée */
public function connection() {
    
    try
    {
        // On se connecte à MySQL
        $this->connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database.';charset='.$this->charset, $this->user, $this->password);
        $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    }
    catch(Exception $e)
    {
        // En cas d'erreur, on affiche un message et on arrête tout
            $this->error='Erreur : '.$e->getMessage();
    }
}

public function disconnection() {
    $this->connection = null;
}

public function queryResults($sql){
$query = $this->connection ->prepare($sql);
$query->execute();
return $query->fetchAll();  

}

public function getUserInfo($useremail) {
         
    $sqluser = "SELECT * FROM `t_d_user` WHERE `Login`=?";
    $query = $this->connection->prepare($sqluser);
    $query->execute(array($useremail));
    $fetch = $query->fetchAll();
    return $fetch;
    
}

}


?>