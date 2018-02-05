<?php
include_once 'tools/contact/libs/contact.functions.php';

$results = baz_requete_recherche_fiches($params['query'], 'alphabetique', '4', '', 1, '', '', true, '');

$fiches['fiches'] = array();

foreach ($results as $fiche) 
{
        if (isset($fiche['body'])) 
		{
            $fiche = json_decode($fiche['body'], true);
            if (YW_CHARSET != 'UTF-8') 
			{
                $fiche = array_map('utf8_decode', $fiche);
            }
        }
        $fiches['fiches'][$fiche['id_fiche']] = $fiche;			
		
}

// echo var_dump($fiches['fiches']);

/*
		$name = trim('JeanMichel15');
		$email = trim('numerique@cco-villeurbanne.org');
		$password = substr(rand(), 0, 12);
		$confpassword = $password;

		// check if name is WikkiName style
		if (!$this->IsWikiName($name)) $error = _t('USERNAME_MUST_BE_WIKINAME').".";
		else if (!$email) $error = _t('YOU_MUST_SPECIFY_AN_EMAIL').".";
		else if (!preg_match("/^.+?\@.+?\..+$/", $email)) $error = _t('THIS_IS_NOT_A_VALID_EMAIL').".";
		else if ($confpassword != $password) $error = _t('PASSWORDS_NOT_IDENTICAL').".";
		else if (preg_match("/ /", $password)) $error = _t('NO_SPACES_IN_PASSWORD').".";
		else if (strlen($password) < 5) $error = _t('PASSWORD_TOO_SHORT').". "._t('PASSWORD_SHOULD_HAVE_5_CHARS_MINIMUM').".";
		else
		{	
			$query = "insert into ".$this->config["table_prefix"]."users set ".
				"signuptime = now(), ".
				"name = '".mysql_escape_string($name)."', ".
				"email = '".mysql_escape_string($email)."', ".
				"password = md5('".mysql_escape_string($password)."')";
					
			$in_debug = true;

			if (!$in_debug)
			{
				echo 'Utilisateur '.$name.' créé! Pass : '.$password.'<hr />';
				$this->Query($query);
			}
				
		
			
			$mail_envoi = 'nepasrepondre@wikilleurbanne.fr';
			$mail_reception = $email;
			$nom_compte = $name;
			$pass_compte = $password;
			$object_mail = 'Création de compte sur Wikilleurbanne';
			$texte_mail = 'Bonjour, un compte sur la plate-forme Wikilleurbanne vient de vous être attribué pour votre association. Le nom de compte est : <strong>'.$name.'</strong> et le mot de passe généré est : <strong>'.$password.'</strong><br />Attention à changer votre mot de passe une fois votre compte connecté. Test bvlabla accent aigüu';
			
			$userID = $nom_compte;
			
			global $wiki;

			$existingUser = $wiki->LoadUser($userID);
			
			echo var_dump($existingUser);
			
			$expFormat = mktime(date("H"), date("i"), date("s"), date("m"), date("d") + 3, date("Y"));
			$expDate = date("Y-m-d H:i:s", $expFormat);
			$key = md5($userID . '_' . $existingUser['email'] . rand(0, 10000) . $expDate . PW_SALT);
			$res = $wiki->InsertTriple($userID, 'http://outils-reseaux.org/_vocabulary/key', $key);
			$passwordLink = $wiki->Href()."&a=recover&email=" . $key . "&u=" . urlencode(base64_encode($userID));
			$message = "Cher $userID,\r\n";
			$message .= "Cliquez sur le lien suivant pour reinitialiser votre mot de passe:\r\n";
			$message .= "-----------------------\r\n";
			$message .= "$passwordLink\r\n";
			$message .= "-----------------------\r\n";
			$message .= "Merci\r\n";
			$domain = $wiki->Href();
			$domain = parse_url($domain);
			$domain = $domain["host"];
			$subject = "Mot de passe perdu pour ".$domain;

			send_mail($mail_envoi, $mail_envoi, $mail_reception, $subject, $message);


		}		
*/				

//*
$i = 0;
foreach ($fiches['fiches'] as $compte)
{
	$i++;
	if ($i <= 1)
	{
		echo var_dump($compte);
		echo $compte['bf_code_categorie'].'<br />';
		echo $compte['bf_code_sous_categorie'].'<br />';
		 $compte['bf_code_categorie'] = strval(intval($compte['bf_code_categorie']));
		 $compte['bf_code_sous_categorie'] = strval(intval($compte['bf_code_sous_categorie']));
		 echo var_dump($compte);
		// baz_mise_a_jour_fiche($compte);
		echo '<hr />';
	}

}
//*/


