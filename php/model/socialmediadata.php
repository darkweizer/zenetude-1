<?php
ini_set('display_errors', 1);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'db.php';
include_once '../model/accountmodel.php';

function addDataFacebook($email, $picture){
	$co = connect();
    $data = $co->query("SELECT * FROM Student WHERE student_instituteemail = '$email' OR student_personalemail = '$email'");
    $res = $data->fetch();

    if (count($res) != 0){

		$accountModel = new AccountModel();
		//echo "<script>alert('');</script>";
		$_SESSION['infoStudent'] = $res;
	    $id = $res['user_id'];
		$idstu = $res['student_id'];
		$pourlasess = $co->query("SELECT * FROM User WHERE user_id = $id");
		$lesdonnees = $pourlasess->fetch();

		$_SESSION['infoUser'] = $lesdonnees;
		$_SESSION['image'] = $picture;


						
        $trainingResult = $accountModel->getTrainingInformationsForUser('description', $_SESSION['infoUser']['user_id']);
        $_SESSION['infoTraining'] = $trainingResult;

        $co->query("UPDATE Student SET student_avatar = '$picture' WHERE `student_id` = $idstu");

		print_r($co->errorInfo());
		header('Location: index.php');
	}
}





function addDataGoogle($email, $picture){
	$co = connect();
    $data = $co->query("SELECT * FROM Student WHERE student_instituteemail = '$email' OR student_personalemail = '$email'");
    $res = $data->fetch();

    if (count($res) != 0){
		$accountModel = new AccountModel();
		$_SESSION['infoStudent'] = $res;
	    $id = $res['user_id'];
		$idstu = $res['student_id'];
		$pourlasess = $co->query("SELECT * FROM User WHERE user_id = $id");
		$lesdonnees = $pourlasess->fetch();

		$_SESSION['infoUser'] = $lesdonnees;
		$_SESSION['image'] = $picture;

        $trainingResult = $accountModel->getTrainingInformationsForUser('description', $_SESSION['infoUser']['user_id']);
        $_SESSION['infoTraining'] = $trainingResult;

        $co->query("UPDATE Student SET student_avatar = '$picture' WHERE `student_id` = $idstu");
		
		print_r($co->errorInfo());
		header('Location: index.php');
		
	}
	
}



function addDataTwitter($email, $picture){
	$co = connect();
    $data = $co->query("SELECT * FROM Student WHERE student_instituteemail = '$email' OR student_personalemail = '$email'");
    $res = $data->fetch();

    if (count($res) != 0){
		$accountModel = new AccountModel();
		$_SESSION['infoStudent'] = $res;
	    $id = $res['user_id'];
		$idstu = $res['student_id'];
		$pourlasess = $co->query("SELECT * FROM User WHERE user_id = $id");
		$lesdonnees = $pourlasess->fetch();

		$_SESSION['infoUser'] = $lesdonnees;
		$_SESSION['image'] = $picture;

		$trainingResult = $accountModel->getTrainingInformationsForUser('description', $_SESSION['infoUser']['user_id']);
         $_SESSION['infoTraining'] = $trainingResult;

        $co->query("UPDATE Student SET `student_avatar` = '$picture' WHERE `student_id` = $idstu");

		print_r($co->errorInfo());
		//header('Location: index.php');
		echo '<script>document.location.href="index.php"</script>';
	}

	
       
}