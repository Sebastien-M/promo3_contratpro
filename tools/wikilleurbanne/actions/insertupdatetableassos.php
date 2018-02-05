<?php
$params = getAllParameters($this);

error_reporting(E_ALL);

echo 'Update has been interrupted, please contact admin';

//*
//Le chemin d'acces au csv d'import
$fichier = fopen("/home/wikilleuly/annuaire/assocs.csv", "r", "r");
$GLOBALS['wiki']->dblink->set_charset("utf8");
// echo mysqli_character_set_name($GLOBALS['wiki']->dblink);
//error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
$i = 0;
$j = 0;
$en_tete = true;
//On parcourt le fichier d'import
$array_wikinames = array();
while (!feof($fichier))
{
	if ($en_tete)
	{
		$en_tete = false;
		$uneLigne =  utf8_encode(fgets($fichier, 2048));

	}
	else
	{
			$j++;
			$uneLigne =  iconv('ISO-8859-1', 'UTF-8', fgets($fichier, 2048));
			//$uneLigne = str_replace('’', '\'', fgets($fichier, 2048));
			$fiche = explode('#', $uneLigne);
			// echo $uneLigne.'<hr />';

				//Si l'association à un mail
				if (has_email($fiche))
				{
					//On génère le nom wiki correspondant à l'association de la ligne car utilisé comme index

					if ($data_page = $GLOBALS['wiki']->LoadSingle('SELECT tag FROM annuaire_assos WHERE CODE_TIERS = "'.$fiche[0].'"'))
					{
						$wiki_name = $data_page['tag'];
					}
					else
					{
						$wiki_name = genere_nom_wiki($fiche[1], 0);
						$name_available = false;
						$i = 0;
						while (!$name_available)
						{
							if (in_array($wiki_name, $array_wikinames) OR $GLOBALS['wiki']->LoadSingle('SELECT tag FROM annuaire_assos WHERE tag = "'.$wiki_name.'"'))
							{
								$wiki_name = genere_nom_wiki($wiki_name, $i);
								$i++;
							}
							else
								$name_available = true;
						}
					}

					array_push($array_wikinames, $wiki_name);

					$this->Query(import_csv_assos($fiche, $wiki_name));
					 
					//echo import_csv_assos($fiche, $wiki_name).'<br /><hr /><hr />';
					//*

					if (!has_compte_lie($wiki_name)) 	//Si pas de compte on le créé
					{
						if (!creation_compte($fiche, $wiki_name))
							echo 'Problème compte : '.$wiki_name.'<br />';
						

                        // echo '<span style="color: blue;">';
                        // echo "CREATION COMPTE $wiki_name <br /><span>";
					}

					if (!has_page_lie($wiki_name))  //Si pas de page on la créé
					{
						creation_page($fiche, $wiki_name);
						maj_droits_page($wiki_name);
						
						
                        // echo '<span style="color: red;">';
                        // echo "CREATION PAGE $wiki_name <br /><span>";
					}
					else //Sinon on met à jour les données
					{
						maj_page($fiche, $wiki_name);
                        // echo "Maj $wiki_name <br />";
					}

					//*//*
				}
	}
}

//*/

/*

sort($tab_name);
$p = 0;
echo '<div>';
foreach ($tab_name as $item_name)
{
	echo $item_name.'<br />';
	$p++;
}
echo '</div>';

echo "<hr />BDD<br />";
echo '<div>';
$resultat = $this->LoadAll('SELECT wiki_name FROM annuaire_assos;');
$u = 0;
foreach ($resultat as $item)
{
	echo $item['wiki_name'].'<br />';
	$u++;
}
echo '</div>';
echo '<hr />Il y a '.$u.' items dans la BDD et '.$p.' dans le csv';

//*/


//Verifie si un email est rattaché à l'asso
function has_email($fiche)
{
    if (isset($fiche[9]))
    {
        $email = trim($fiche[9]);
        if  (!empty($email) && preg_match("/^.+?\@.+?\..+$/", $email))
            return true;
        else
            return false;
    }
    return false;

}

//Créer la page / fiche de l'association
function creation_page($fiche, $wiki_name)
{
	$json_data = json_data_format($fiche, $wiki_name);
	//Sauvegarde BDD via fonction bazar
	$GLOBALS['wiki']->SavePage($wiki_name, $json_data, '', true);
	$GLOBALS['wiki']->InsertTriple($wiki_name,'http://outils-reseaux.org/_vocabulary/type',	'fiche_bazar','',	'');
}

//Formate les données pour renvoyer un json
function json_data_format($fiche, $wiki_name)
{
	$valeur['bf_titre'] = $fiche[1];
	$valeur['bf_sigle'] = $fiche[2];
	$valeur['listeListeCategorieasso'] = intval($fiche[11]);
	$valeur['listeListeSousCategorie'] = intval($fiche[13]);

	$data_page = $GLOBALS['wiki']->LoadSingle('SELECT tag, body FROM yeswiki_pages WHERE tag = "'.$wiki_name.'" AND latest = "Y"');



	$body_bis = json_decode($data_page['body']);

	$valeur['bf_description'] = strval($body_bis->bf_description);
	$valeur['bf_champs_complementaires'] = strval($body_bis->bf_champs_complementaires);
	$valeur['id_typeannonce'] = '4';
	$valeur['id_fiche'] = $wiki_name;
	$valeur['createur'] = $wiki_name;
	$valeur['bf_latitude'] = strval($body_bis->bf_latitude);
	$valeur['bf_longitude'] = strval($body_bis->bf_longitude);
	$valeur['carte_google'] = $body_bis->carte_google;
	$valeur['categorie_fiche'] = '';
	$valeur['bf_code_postal'] = $fiche[6];
	$valeur['bf_adresse12'] = $fiche[4];
	$valeur['imagebf_image'] = strval($body_bis->imagebf_image);

	$datecreation = $GLOBALS['wiki']->LoadSingle('SELECT MIN(time) as firsttime FROM '.BAZ_PREFIXE.	"pages WHERE tag='".$valeur['id_fiche']."'");
	$valeur['date_creation_fiche'] = $datecreation['firsttime'] ? $datecreation['firsttime'] : date('Y-m-d H:i:s', time());

	$valeur['statut_fiche'] = '1';
	$valeur['date_maj_fiche'] =  date('Y-m-d H:i:s', time());

	$json_data = json_encode($valeur);


	$data_user = $GLOBALS['wiki']->LoadSingle('SELECT name, email FROM yeswiki_users WHERE name = "'.$wiki_name.'"');

	if ($data_user['email'] != $fiche['9'])
	{
		$GLOBALS['wiki']->Query("UPDATE ".$GLOBALS['wiki']->config['table_prefix']."users SET email = '".$fiche['9']."' WHERE name = '".$wiki_name."'");
	}

	return $json_data;
}

//Met à jour la page
function maj_page($fiche, $wiki_name)
{
	$json_data = json_data_format($fiche, $wiki_name);
	$GLOBALS['wiki']->SavePage($wiki_name, $json_data, '', true);
	maj_droits_page($wiki_name);
}

//Met à jour les droits classique de la page
function maj_droits_page($wiki_name)
{
	$droits_lire = '*';
	$droits_ecrire = '%';
	$droits_comment = '+';

	$GLOBALS['wiki']->Query("UPDATE ".$GLOBALS['wiki']->config['table_prefix']."acls SET list='" . $droits_lire . "' WHERE privilege='read' and page_tag='" . $wiki_name . "'");
	$GLOBALS['wiki']->Query("UPDATE ".$GLOBALS['wiki']->config['table_prefix']."acls SET list='" . $droits_ecrire . "' WHERE privilege='write' and page_tag='" . $wiki_name . "'");
	$GLOBALS['wiki']->Query("UPDATE ".$GLOBALS['wiki']->config['table_prefix']."acls SET list='". $droits_comment . "' WHERE privilege='comment' and page_tag='" . $wiki_name . "'");
	$GLOBALS['wiki']->Query("UPDATE ".$GLOBALS['wiki']->config['table_prefix']."pages SET owner = '".$wiki_name."' WHERE tag = '".$wiki_name."' AND latest = 'Y' LIMIT 1");

}

//Genère la requête d'import
function import_csv_assos($fiche, $wiki_name)
{
	if ($fiche[9] == '')
		$fiche[9] = NULL;
			//Requête pour mettre à jour la table d'annuaire des associations
			$sql = "
			REPLACE INTO annuaire_assos
			(CODE_TIERS, tag, LIBELLE_TIERS, SIGLE, DESCRIPTIF, RUE1, RUE2, CP, VILLE, TELEPHONE, MAIL, SITE_INTERNET, CODE_CATEGORIE, LIBELLE_CATEGORIE, CODE_SOUS_CATEGORIE, LIBELLE_SOUS_CATEGORIE, SITE, ADRESSE_SITE, OUVERTURE, PERMANENCE, PUBLIC_VISE)
			VALUES
			('".$fiche[0]."',
			'".mysqli_real_escape_string($GLOBALS['wiki']->dblink, $wiki_name)."',
			'".mysqli_real_escape_string($GLOBALS['wiki']->dblink, $fiche[1])."',
			'".mysqli_real_escape_string($GLOBALS['wiki']->dblink,$fiche[2])."',
			'".mysqli_real_escape_string($GLOBALS['wiki']->dblink,$fiche[3])."',
			'".mysqli_real_escape_string($GLOBALS['wiki']->dblink,$fiche[4])."',
			'".mysqli_real_escape_string($GLOBALS['wiki']->dblink,$fiche[5])."',
			'".$fiche[6]."',
			'".mysqli_real_escape_string($GLOBALS['wiki']->dblink,$fiche[7])."',
			'".mysqli_real_escape_string($GLOBALS['wiki']->dblink,$fiche[8])."',
			'".mysqli_real_escape_string($GLOBALS['wiki']->dblink,$fiche[9])."',
			'".mysqli_real_escape_string($GLOBALS['wiki']->dblink,$fiche[10])."',
			'".$fiche[11]."',
			'".mysqli_real_escape_string($GLOBALS['wiki']->dblink,$fiche[12])."',
			'".$fiche[13]."',
			'".mysqli_real_escape_string($GLOBALS['wiki']->dblink,$fiche[14])."',
			'".mysqli_real_escape_string($GLOBALS['wiki']->dblink,$fiche[15])."',
			'".mysqli_real_escape_string($GLOBALS['wiki']->dblink,$fiche[16])."',
			'".mysqli_real_escape_string($GLOBALS['wiki']->dblink,$fiche[17])."',
			'".mysqli_real_escape_string($GLOBALS['wiki']->dblink,$fiche[18])."',
			'".mysqli_real_escape_string($GLOBALS['wiki']->dblink,$fiche[19])."');";

			return $sql;
}


function asso_dans_bdd($wiki_name)
{
	if (($GLOBALS['wiki']->query('SELECT CODE_TIERS FROM annuaire_assos WHERE tag = "'.$wiki_name.'";')))
		return true;
	else
		return false;
}

//L'asso a-t-elle un compte?
function has_compte_lie($wiki_name)
{
	if (($GLOBALS['wiki']->LoadSingle('SELECT name FROM '.$GLOBALS['wiki']->config['table_prefix'].'users WHERE name = "'.$wiki_name.'";')))
		return true;
	else
		return false;
}

//L'asso a t-elle une page déjà liée?
function has_page_lie($wiki_name)
{
	if (($GLOBALS['wiki']->LoadSingle('SELECT tag FROM '.$GLOBALS['wiki']->config['table_prefix'].'pages WHERE tag = "'.$wiki_name.'" AND latest = "Y" LIMIT 1;')))
		return true;
	else
		return false;
}

//Insertion du compte dans la BDD,
function creation_compte($fiche, $wiki_name)
{
	$name = trim($wiki_name);
	$email = trim($fiche[9]);
	$password = substr(rand(), 0, 12);
	$confpassword = $password;

	if (!$email)
		return;
	else if (!preg_match("/^.+?\@.+?\..+$/", $email))
		return;
	else if ($confpassword != $password)
		return;
	else if (preg_match("/ /", $password))
		return;
	else if (strlen($password) < 5)
		return;
	else
	{
		$query = "insert into ".$GLOBALS['wiki']->config["table_prefix"]."users set ".
			"signuptime = now(), ".
			"name = '".mysqli_real_escape_string($GLOBALS['wiki']->dblink,$name)."', ".
			"email = '".mysqli_real_escape_string($GLOBALS['wiki']->dblink,$email)."', ".
			"password = md5('".mysqli_real_escape_string($GLOBALS['wiki']->dblink,$password)."')";
			$GLOBALS['wiki']->Query($query);
			//envoyer_lien_reset_password();
			echo 'Compte créé : '.$name.'  Pass : ' .$password.' Mail : '.$email.'<br >';
			return true;
	}
}
?>
