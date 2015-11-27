<?php
	class AccountModel {
		public  function getData($param) {
            $db = connect();
            $request = $db->prepare('SELECT :param FROM users WHERE user_instituteemail = :mail');
            $request->execute(array('param' => $param, 'mail' => $_POST['mail']));
            $result = $request->fetchAll();
            return $result;
        }

        public function getUserpassword() {
            $db = connect();
            $request = $db->prepare('SELECT * FROM users WHERE user_instituteemail = :mail AND user_password = :pass');
            $request->execute(array('mail' => $_POST['mail'], 'pass' => $_POST['pass']));
            $result = $request->fetchAll();
            return $result;
        }

		public function recoverPassword() {
			$accountView = new AccountView();

            $string = "";
			$chaine = "abcdefghijklmnpqrstuvwxy";
			srand((double)microtime()*1000000);
			for($i=0; $i<10; ++$i) {
				$string .= $chaine[rand()%strlen($chaine)];	
		        }

            $db = connect();

            $request = $db->prepare('UPDATE users SET user_password = :password WHERE user_instituteemail = :mail');
			$request->execute(array('password' => sha1($string), 'mail' => $_POST['mail']));
			$body = "
				<h1>Réinitialisation du mot de passe</h1>
				<hr />
				<p>Bonjour, votre mot de passe a été réinitialisé.</p>
				<p>Votre nouveau mot de passe est : <a href='http://139.124.187.191/cedric/web/index.html'>$string</a></p>
				<hr />
				<p>Ce message à été généré automatiquement. Merci de ne pas y répondre.</p>
			";

			$mailer = new PHPMailer();
		        $mailer->IsSMTP();
		        $mailer->SMTPDebug = 0;
		        $mailer->SMTPAuth = true;
		        $mailer->SMTPSecure = 'ssl';
		        $mailer->Host = "smtp.gmail.com";
		        $mailer->Port = 465;
		        $mailer->IsHTML(true);
			$mailer->charSet = "UTF-8"; 	
		        $mailer->Username = "cedric.vigne11@gmail.com";
		        $mailer->Password = "paxwwwww";
		        $mailer->SetFrom("cedric.vigne11@gmail.com");
		        $mailer->AddAddress($_POST['mail'] ,utf8_encode(""));
		        $mailer->Subject ="Subject: =?UTF-8?B?".base64_encode("Réinitialisation du mot de passe | Zenetude")."?=";
		        $mailer->Body = $body;
		        if(!$mailer->Send())
                    $accountView->showEMessage(2);
		        else
                    $accountView->showEMessage(3);
		}

        public function addUser() {
            $db = connect();

            $request = $db->prepare('INSERT INTO users (user_password, user_instituteemail) VALUES (:password, :mail)');
            $request->execute(array('password' => $_POST['passe'], 'mail' => $_POST['mail']));
        }
	}

