<?php 
session_start();
require_once('connection.php');
$db = new DAO();
$db->connection();

if(ISSET($_POST['login'])){
    if($_POST['email'] != "" || $_POST['password'] != ""){
        $useremail = $_POST['email'];
        $password = $_POST['password'];
        
    }
        $fetchuser = $db -> getUserInfo($useremail);
        if($fetchuser){   
            if(password_verify($password, $fetchuser[0]['Password']) && $fetchuser[0]['Login']===$useremail){
                $fetchuser = $db -> getUserInfo($useremail);
                $_SESSION['id_user'] = $fetchuser[0]['Id_User'];
                $_SESSION['login'] = $fetchuser[0]['Login'];
                $_SESSION['user_type'] = $fetchuser[0]['Id_UserType'];
                $_SESSION['id_user'] = $fetchuser[0]['Id_User'];
                if ($_SESSION['user_type'] == '2'){
                    header('location:index.php');
                }
            } 
        } 
}else print 'account not existing';

?>