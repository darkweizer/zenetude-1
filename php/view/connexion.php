<?php
/**
 * Created by PhpStorm.
 * User: m15026768
 * Date: 23/11/2015
 * Time: 14:55
 */
ini_set('display_errors', 1);
session_start();

include_once( '../model/db.php');
include_once('../controller/AccountController.php');
include_once('../model/AccountModel.php');
include_once('AccountView.php');
ini_set('display_errors', 1);
$accountController = new AccountController();
$accountController->controlConnection();

//require_once 'db.php';


/*if (count($_POST) > 0){
    $pseudo = $_POST['pseudo'];
    $mdp = $_POST['pass'];

    $co = connect();
    $result = $co->query("SELECT * FROM User WHERE `user_instituteemail` = '$pseudo' AND `user_password` = '$mdp'");
    if ($result->rowCount() != 0){
        $data = $result->fetch(PDO::FETCH_OBJ);
        session_start();
        $_SESSION['nom'] = $data->user_name;
	$_SESSION['prenom'] = $data->user_firstname;
	$_SESSION['email'] = $data->user_instituteemail;
	
        header('Location: index-connecte.php');

    }else{
        header('Location: index.php?erreur=1');

    }

}*/

