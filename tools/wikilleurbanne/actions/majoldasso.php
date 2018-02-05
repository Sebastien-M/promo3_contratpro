﻿<?php

$params = getAllParameters($this);

//Le chemin d'acces au csv d'import
$fichier = fopen("/home/wikilleuly/annuaire/assocs.csv", "r", "r");

error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

$i = 0;
$j = 0;
$en_tete = true;
//On parcourt le fichier d'import
$array_wikinames = array();
$array_alltags = array();
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
			$fiche = explode('#', $uneLigne);
				//Si l'association à un mail
				if (has_email($fiche))
				{
					array_push($array_alltags, intval($fiche[0]));
				}
	}
}

$array_allBDD = loadAllAssos();
$array_toDelete = array();

foreach($array_allBDD as $fiche)
{
	if (!in_array(intval($fiche['CODE_TIERS']), $array_alltags))
	{
		array_push($array_toDelete, $fiche['CODE_TIERS']);
	}
}
echo 'Assos à supprimé : '.count($array_toDelete);
foreach ($array_toDelete as $toD)
{
	$asso = getAssoTag($toD);

	$GLOBALS['wiki']->Query("delete from yeswiki_pages where tag='".$asso['tag']."' ");
	$GLOBALS['wiki']->Query("delete from yeswiki_links where from_tag='".$asso['tag']."' ");
	$GLOBALS['wiki']->Query("delete from yeswiki_acls where page_tag='".$asso['tag']."' ");
	$GLOBALS['wiki']->Query("delete from yeswiki_referrers where page_tag='".$asso['tag']."' ");
	$GLOBALS['wiki']->Query("DELETE FROM yeswiki_triples WHERE resource = '".$asso['tag']."'");
	$GLOBALS['wiki']->Query("DELETE FROM yeswiki_users WHERE name = '".$asso['tag']."'");
	delete_asso($toD);
}

//*/
function getAssoTag($code_tiers)
{
	return $GLOBALS['wiki']->LoadSingle('SELECT CODE_TIERS, tag FROM annuaire_assos WHERE CODE_TIERS = "'.$code_tiers.'"');
}

//Supprime une association dans la BDD et Bazar en fonction de song tag
function delete_asso($code_tiers)
{
	$GLOBALS['wiki']->Query('DELETE FROM annuaire_assos WHERE CODE_TIERS = "'.$code_tiers.'"');

	return true;
}

//Retourne un tableau des associations dans la BDD
function loadAllAssos()
{
	return $GLOBALS['wiki']->LoadAll('SELECT CODE_TIERS, tag FROM annuaire_assos');
}

//Verifie si un email est rattaché à l'asso
function has_email($fiche)
{
	$email = trim($fiche[9]);
	if  (!empty($email) && preg_match("/^.+?\@.+?\..+$/", $email))
		return true;
	else
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

	$valeur['bf_description'] = $body_bis->bf_description;
	$valeur['bf_champs_complementaires'] = $body_bis->bf_champs_complementaires;
	$valeur['id_typeannonce'] = '4';
	$valeur['id_fiche'] = $wiki_name;
	$valeur['createur'] = $wiki_name;
	$valeur['bf_latitude'] = $body_bis->bf_latitude;
	$valeur['bf_longitude'] = $body_bis->bf_longitude;
	$valeur['carte_google'] = $body_bis->carte_google;
	$valeur['categorie_fiche'] = '';
	$valeur['bf_code_postal'] = $fiche[6];
	$valeur['bf_adresse12'] = $fiche[4];
	$valeur['imagebf_image'] = $body_bis->imagebf_image;

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
			'".mysql_escape_string($wiki_name)."',
			'".mysql_escape_string($fiche[1])."',
			'".mysql_escape_string($fiche[2])."',
			'".mysql_escape_string($fiche[3])."',
			'".mysql_escape_string($fiche[4])."',
			'".mysql_escape_string($fiche[5])."',
			'".$fiche[6]."',
			'".mysql_escape_string($fiche[7])."',
			'".mysql_escape_string($fiche[8])."',
			'".mysql_escape_string($fiche[9])."',
			'".mysql_escape_string($fiche[10])."',
			'".$fiche[11]."',
			'".mysql_escape_string($fiche[12])."',
			'".$fiche[13]."',
			'".mysql_escape_string($fiche[14])."',
			'".mysql_escape_string($fiche[15])."',
			'".mysql_escape_string($fiche[16])."',
			'".mysql_escape_string($fiche[17])."',
			'".mysql_escape_string($fiche[18])."',
			'".mysql_escape_string($fiche[19])."');";

			return $sql;
}

//Retourne vrai si le tag est présent dans la BDD
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
			"name = '".mysql_escape_string($name)."', ".
			"email = '".mysql_escape_string($email)."', ".
			"password = md5('".mysql_escape_string($password)."')";
			$GLOBALS['wiki']->Query($query);
			//envoyer_lien_reset_password();
			echo 'Compte créé : '.$name.'  Pass : ' .$password.' Mail : '.$email.'<br >';
			return true;
	}
}
?>
