<?php
ini_set('display_errors', '1');

/* INCLUSION OF LIBRARY FILEs*/
	require_once( '../Facebook/FacebookSession.php');
	require_once( '../Facebook/FacebookRequest.php' );
	require_once( '../Facebook/FacebookResponse.php' );
	require_once( '../Facebook/FacebookSDKException.php' );
	require_once( '../Facebook/FacebookRequestException.php' );
	require_once( '../Facebook/FacebookRedirectLoginHelper.php');
	require_once( '../Facebook/FacebookAuthorizationException.php' );
	require_once( '../Facebook/GraphObject.php' );
	require_once( '../Facebook/GraphUser.php' );
	require_once( '../Facebook/GraphSessionInfo.php' );
	require_once( '../Facebook/Entities/AccessToken.php');
	require_once( '../Facebook/HttpClients/FacebookCurl.php' );
	require_once( '../Facebook/HttpClients/FacebookHttpable.php');
	require_once( '../Facebook/HttpClients/FacebookCurlHttpClient.php');
/* USE NAMESPACES */

	use Facebook\FacebookSession;
	use Facebook\FacebookRedirectLoginHelper;
	use Facebook\FacebookRequest;
	use Facebook\FacebookResponse;
	use Facebook\FacebookSDKException;
	use Facebook\FacebookRequestException;
	use Facebook\FacebookAuthorizationException;
	use Facebook\GraphObject;
	use Facebook\GraphUser;
	use Facebook\GraphSessionInfo;
	use Facebook\HttpClients\FacebookHttpable;
	use Facebook\HttpClients\FacebookCurlHttpClient;
	use Facebook\HttpClients\FacebookCurl;
/*PROCESS*/

if(!isset($_SESSION['sess'])){
	//1.Start Session
	 session_start();
	//2.Use app id,secret and redirect url
	 //$app_id = '1207370725956552';
	$app_id = '918372571582116';
	 //$app_secret = '1b83b246d8f61a10d05879a692494c63';
$app_secret = 'd7e65bcc1b115416ac34c8eeab42f0e2';
	 $redirect_url='http://localhost/zenetude-1/maquette/facebookconnection.php';

	 //3.Initialize application, create helper object and get fb sess
	 FacebookSession::setDefaultApplication($app_id,$app_secret);
	 $helper = new FacebookRedirectLoginHelper($redirect_url);
	 $sess = $helper->getSessionFromRedirect();
	 $_SESSION['sess'] = $sess;
	 header('Location: '.$helper->getLoginUrl().'');

	//4. if fb sess exists echo name
	 //	if(isset($sess)){
	//if(isset($_SESSION['sess']))
}else{
            //create request object,execute and capture response
            $request = new FacebookRequest($_SESSION['sess'], 'GET', '/me');
            // from response get graph object
            $response = $request->execute();
            $graph = $response->getGraphObject(GraphUser::className());

            // use graph object methods to get user details
            $_SESSION['nom'] = $graph->getFirstName();
	    $_SESSION['prenom'] = $graph->getName();
	    $_SESSION['datedenaissance'] = $graph->getBirthday();

	    header('Location: index-connecte.php');

        }
	//else{
            //else echo login
            //echo '<a href='.$helper->getLoginUrl().'>Login with facebook</a>';
        //}
