<?php 
	include_once('pageview.php');
    include_once('../controller/pagecontroller.php');
    include_once('../model/db.php');
    include_once('accountview.php');

    $pageController = new PageController();
    $pageView = new PageView();
    $accountView = new AccountView();
    $db = connect();

 if (isset($_POST['student_update']) ) //SI LE FORMULAIRE A ETE ENVOYE
{
	$rf = $pageController-> controlGestion();
	$pageController -> uploadPhoto();
	$pageController -> uploadTrombi();
	$pageController -> modifyPassword();

	$user_id=$_POST['user_id'];
	$user_name=$_POST['user_name'];
	$user_firstname=$_POST['user_firstname'];
	$user_civility=$_POST['user_civility'];
	if(!$rf){
	    $student_personalemail=$_POST['student_personalemail'];
	    $student_phone=$_POST['student_phone'];
	    $student_mobile=$_POST['student_mobile'];
	    $student_address1=$_POST['student_address1'];
	    $student_address2=$_POST['student_address2'];
	    $student_zipcode=$_POST['student_zipcode'];
	    $student_city=$_POST['student_city'];
	    $student_country=$_POST['student_country'];
	    $student_nationality=$_POST['student_nationality'];
	    $student_birthday=$_POST['student_birthday'];
	    $student_birtharea=$_POST['student_birtharea'];
	    $student_birthcountry=$_POST['student_birthcountry'];
	    $student_status=$_POST['student_status'];
	    $student_educationallevel=$_POST['student_educationallevel'];
	    $student_origin=$_POST['student_origin'];
	    $student_birthcity=$_POST['student_birthcity'];
	    $student_comment=$_POST['student_comment'];
	    $student_group=$_POST['student_group'];
	    $training_description=$_POST['training_description'];
	    $student_educationallevel=$_POST['student_educationallevel'];
	    $student_grantholder=$_POST['student_grantholder'];

	    $request = $db->prepare('SELECT training_id FROM Training WHERE description = "'.$training_description.'"');
	    $request->execute();
	    $result3 = $request->fetchAll();
	    $training_id = $result3[0][0];
	}
	if(!$rf)
	    $values = array($user_name,
	                    $user_firstname,
	                    $user_civility,
	                    $student_personalemail,
	                    $student_phone,
	                    $student_mobile,
	                    $student_address1,
	                    $student_address2,
	                    $student_zipcode,
	                    $student_city,
	                    $student_country,
	                    $student_nationality,
	                    $student_birthday,
	                    $student_birtharea,
	                    $student_birthcountry,
	                    $student_status,
	                    $student_educationallevel,
	                    $student_origin,
	                    $student_birthcity,
	                    $student_comment,
	                    $student_group,
	                    $training_id,
	                    $student_educationallevel,
	                    $student_grantholder
	                    );
	else
	    $values = array($user_name,
	                    $user_firstname,
	                    $user_civility);

	    foreach ($values as $key => $value) {
	        if (empty($value)) {
	            $values[$key] = null;
	        } else {
	            $values[$key] = $value;
	        }
	    }

	if(!$rf)
	    $update = $db->query("UPDATE Student SET 
	    student_personalemail = '$values[3]',
	    student_phone = '$values[4]',
	    student_mobile = '$values[5]',
	    student_address1 = '$values[6]',
	    student_address2 = '$values[7]',
	    student_zipcode = '$values[8]',
	    student_city = '$values[9]',
	    student_country = '$values[10]',
	    student_nationality = '$values[11]',
	    student_birthdate = '$values[12]',
	    student_birtharea = '$values[13]',
	    student_birthcountry = '$values[14]',
	    student_status = '$values[15]',
	    student_educationallevel = '$values[16]',
	    student_origin = '$values[17]',
	    student_comment = '$values[18]',
	    student_group = '$values[19]',
	    student_birthcity = '$values[20]',
	    training_id = '$values[21]',
	    student_educationallevel = '$values[22]',
	    student_grantholder = '$values[23]'
	    WHERE user_id='$idUser'");

	$update2 = $db->query("UPDATE User SET
	user_name = '$values[0]',
	user_firstname = '$values[1]',
	user_civility = '$values[2]'
	WHERE user_id='$idUser'");

	if(!$rf){
	    $_SESSION['infoStudent']['student_personalemail'] = $values[3];
	    $_SESSION['infoStudent']['student_phone'] = $values[4];
	    $_SESSION['infoStudent']['student_mobile'] = $values[5];
	    $_SESSION['infoStudent']['student_address1'] = $values[6];
	    $_SESSION['infoStudent']['student_address2'] = $values[7];
	    $_SESSION['infoStudent']['student_zipcode'] = $values[8];
	    $_SESSION['infoStudent']['student_city'] = $values[9];
	    $_SESSION['infoStudent']['student_country'] = $values[10];
	    $_SESSION['infoStudent']['student_nationality'] = $values[11];
	    $_SESSION['infoStudent']['student_birthdate'] = $values[12];
	    $_SESSION['infoStudent']['student_birtharea'] = $values[13];
	    $_SESSION['infoStudent']['student_birthcountry'] = $values[14];
	    $_SESSION['infoStudent']['student_status'] = $values[15];
	    $_SESSION['infoStudent']['student_educationallevel'] = $values[16];
	    $_SESSION['infoStudent']['student_origin'] = $values[17];
	    $_SESSION['infoStudent']['student_comment'] = $values[18];
	    $_SESSION['infoStudent']['student_group'] = $values[19];
	    $_SESSION['infoStudent']['student_birthcity'] = $values[20];
	    $_SESSION['infoStudent']['training_id'] = $values[21];
	    $_SESSION['infoStudent']['student_educationallevel'] = $values[22];
	    $_SESSION['infoStudent']['student_grantholder'] = $values[23];
	}
	$_SESSION['infoUser']['user_name'] = $values[0];
	$_SESSION['infoUser']['user_firstname'] = $values[1];
	$_SESSION['infoUser']['user_civility'] = $values[2];

	$accountView -> showMessage(null,"ok","profil.php");
	//header('Location: profil.php');
	}