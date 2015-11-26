<?php

    error_reporting(E_ALL);
    require 'vendor/autoload.php';
    require 'PHPMailer/PHPMailerAutoload.php';

    function toJSON($app, $content) {
        $response = $app->response;
        $response['Content-Type'] = 'application/json';
        $response->body( json_encode($content) );
    };



        


      
    // $mysqli = new mysqli("mysql-maquetteprojet.alwaysdata.net", "114038_equipe1", "123456", "maquetteprojet_zenetude");
    //     if ($mysqli->connect_errno)
    //     {
    //         echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    //     }
    
    //     if ($result = $mysqli->query("SELECT user_instituteemail FROM user")) {
            
    //     for ($tablearesultat = array (); $row = $result->fetch_assoc(); $tablearesultat[] = $row);
        
    //     echo $tablearesultat;
    
//}

    function sendReminder($first_name, $last_name) {
                    //Create a new PHPMailer instance
                $mail = new PHPMailer;

                //Set who the message is to be sent from
                $mail->setFrom('Zenetude', 'First Last');

                //Set an alternative reply-to address
                /*$mail->addReplyTo('replyto@example.com', 'First Last');*/



                $db = new PDO('mysql:host=mysql-dylan.prudhomme.alwaysdata.net; dbname=99389_maquetteprojet_zenetude', '99389', '1234');         
            
                $request = $db -> prepare('SELECT user_instituteemail FROM User WHERE user_firstname = "' . $first_name . '" AND user_name = "' . $last_name . '"');
		var_dump($request);
		echo "</br>";
                $request -> execute();
                $results = $request -> fetchAll();
		var_dump($results);
		echo "</br>";
                echo $first_name , $last_name;
		echo "</br>";
                foreach ($results as $result) {

                    $mailbd = $result[0];
                    echo $mailbd;
                //Set who the message is to be sent to
                $mail->addAddress($mailbd, $first_name . ' ' . $last_name);

                //Set the subject line
                $mail->Subject = 'PHPMailer mail() test';

                //Read an HTML message body from an external file, convert referenced images to embedded,
                //convert HTML into a basic plain-text alternative body
                $mail->isHTML(true);

                //Replace the plain text body with one created manually
                //$mail->Body = file_get_contents('examples/contents.html');
                $mail->Body = "TEST DE BG MEK";
                //Attach an image file
                //$mail->addAttachment('examples/images/phpmailer_mini.png');

                //send the message, check for errors

                if (!$mail->send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                } else {
                    echo "Message sent!";
                }
            }
        }

    $app = new \Slim\Slim(array(
        'debug' => true
    ));

    $app->get('/', function () {
        ?>
        <a href="reminder">Reminder</a><br/>
        <?php
    });

    //Set default timezone
    date_default_timezone_set('Europe/Paris');

    //Function take back data from agenda ADE
    $app->get('/reminder', function () use ($app) {
        $ch = curl_init();

        //Number of day the data come from
        $nbDays = 12;
        //Agenda's URL where data come from
        $source = 'http://ade-consult.pp.univ-amu.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?resources=6445&projectId=8&startDay=' . date('d', time() + $nbDays * 24 * 60 * 60 /*+14 jours*/ ) . '&startMonth=' . date('m', time() + $nbDays * 24 * 60 * 60) . '&startYear=' . date('Y', time() + $nbDays * 24 * 60 * 60) . '&endDay=' . date('d', time() + $nbDays * 24 * 60 * 60) . '&endMonth=' . date('m', time() + $nbDays * 24 * 60 * 60) . '&endYear=' . date('Y', time() + $nbDays * 24 * 60 * 60) . '';
        curl_setopt($ch, CURLOPT_URL, $source);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec ($ch);
        curl_close ($ch);
        //echo $data;
        $lines = explode(PHP_EOL, $data);

        for ($i = 5; $i < count($lines); ++$i)
        {
             //echo $i . " " . $lines[$i] . "</br>";
             if (strstr($lines[$i], "BEGIN:VEVENT"))
             {
                // Skip useless lines
                ++$i;

                // date and hour of the beginning class
                ++$i;
                $date = substr($lines[$i], 8, 8);
                $hour_start = substr($lines[$i], 17, 2);
                $min_start = substr($lines[$i], 19, 2);
                $d = date_create_from_format('Ymd', $date);
                echo $d->format('d/m/Y') . ' ' . $hour_start . ':' . $min_start . "</br>";

                // date and hour of the beginning class
                ++$i;
                $hour_end = substr($lines[$i], 15, 2);
                $min_end = substr($lines[$i], 17, 2);
                echo $d->format('d/m/Y') . ' ' . $hour_end . ':' . $min_end . "</br>";

                // Subjects
                ++$i;                                                                                                
                $subject = substr($lines[$i], 8);
                echo utf8_decode($subject) . "</br>";

                // Room
                ++$i;                                                                                               
                $room = substr($lines[$i], 9);
                echo $room . "</br>";
                
                // Teacher's first name and last name
                ++$i;
                $full_description  = $lines[$i]; 
                $first_last_name = explode('\n', $full_description);

                //Decode of the utf-8 encode
                $parameter = utf8_decode($first_last_name[2]);

                //Test of existing name
                $first_carac = substr($first_last_name[2], 0, 1);

                // If name doesn't exist, print nothing
                if ($first_carac == "(") {
                    echo '';
                }
                // Else save first name and last name
                else {
                    echo $parameter ."</br>";
                    $full_name = explode(' ', $parameter);
                    // $last_name = strtolower($full_name[0]) . "</br>";
                    // $first_name = strtolower($full_name[1]) . "</br>";
                    echo 'yolo';
                    sendReminder('dylan', 'prudhomme');

                }
           }
        }
    });

    $app->run();
