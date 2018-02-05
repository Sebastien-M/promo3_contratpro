<?php

//Affiche les informations supplementaires sur l'association
function afficher_infos_description($data_description, $data_complementaires)
{
	echo '<div class="description">'.$data_description.'</div><br />';
	echo '<div class="txtsup">'.$data_complementaires.'</div></div>';
}

//Affiche les bazarliste correspondantes
function afficher_bazarlistes($fiche)
{
	echo $GLOBALS['wiki']->Format('{{grid}}');

	//Actus
	echo $GLOBALS['wiki']->Format('{{col size="4"}}');
	echo $GLOBALS['wiki']->Format('{{bazarliste idtypeannonce="3" query="createur='.$fiche['createur'].'"  ordre="desc" champ="date_creation_fiche" template="liste_actu.tpl.html" pagination="5"}}');
	echo $GLOBALS['wiki']->Format('{{end elem="col"}}');

	//Echanges
	echo $GLOBALS['wiki']->Format('{{col size="4"}}');
	echo $GLOBALS['wiki']->Format('{{bazarliste id="5" query="createur='.$fiche['createur'].'" pagination="5" champ="date_creation_fiche" template="liste_bourse_echange.tpl.html"}}');
	echo $GLOBALS['wiki']->Format('{{end elem="col"}}');

	//Agenda
	echo $GLOBALS['wiki']->Format('{{col size="4"}}');
	echo $GLOBALS['wiki']->Format('{{bazarliste idtypeannonce="2" query="createur='.$fiche['createur'].'" ordre="desc" champ="bf_date_debut_evenement" template="liste_agenda_asso.tpl.html"  pagination="10" }}');
	echo $GLOBALS['wiki']->Format('{{end elem="col"}}');

	echo $GLOBALS['wiki']->Format('{{end elem="grid"}}');
}

//Retourne un tableau contenant les données de l'association dans la BDD
function get_data_asso($id_fiche)
{
	$data_asso = $GLOBALS['wiki']->LoadSingle("SELECT * FROM annuaire_assos WHERE tag = '".$id_fiche."' LIMIT 1");
	return $data_asso;
}

//Créé et affiche le div contenant l'image et les informations administratives de l'asspo
function afficher_bloc_info($fiche, $data_asso, $solo = false)
{
	if (isset($fiche['imagebf_image']) && $fiche['imagebf_image']!='')
	{
		echo '<div style="width: 100%; margin: auto; margin-bottom: 1em; margin-top: 4px; text-align: center;">';
		echo '<img style="max-width: 100%;" src="files/'.$fiche['imagebf_image'].'" />';
		echo '</div>';
	}


	echo '<div class="BlocInfoStructure">';


		if (!empty($data_asso["SIGLE"] ))
		{
			show('<h2 style="text-align: center;">'.utf8_encode($data_asso["SIGLE"]).'</h2><hr />', '');
		}
		else
		{
			show('<h2 style="text-align: center;">'.utf8_encode($data_asso["LIBELLE_TIERS"]).'</h2><hr />', '');
		}
		if (!empty($data_asso["DESCRIPTIF"] ))
		{
			$data_b = utf8_encode($data_asso['DESCRIPTIF']);
			show('<h4 style="text-align: left;">Objet : '.$data_b.'</h4><hr />', '');
		}

		if (!empty($data_asso["LIBELLE_CATEGORIE"]))
		{
			show('<h4><strong>Catégorie : </strong>'.utf8_encode($data_asso["LIBELLE_CATEGORIE"]).'</h4>', '');
		}
		if (!empty($data_asso["LIBELLE_SOUS_CATEGORIE"]))
		{
			show('<h4><strong>Sous-catégorie : </strong>'.utf8_encode($data_asso["LIBELLE_SOUS_CATEGORIE"]).'</h4><hr />', '');
		}
		//Affichage Adresse
		if (!empty($data_asso["RUE1"]) AND $data_asso['RUE1'] != '')
		{
			echo '<p>';
			if (!empty($data_asso["RUE2"])  AND $data_asso['RUE2'] != '')
				echo '<i class="glyphicon glyphicon-home home" ></i> <strong>SIEGE SOCIAL</strong><br />' . utf8_encode($data_asso["RUE1"]) . '<br />' . utf8_encode($data_asso["RUE2"]) . '';
			else
				echo '<i class="glyphicon glyphicon-home home" ></i> <strong>SIEGE SOCIAL</strong><br />' . utf8_encode($data_asso["RUE1"]) . '';

			//Affichage code Postal et ville
			if (!empty($data_asso["CP"]) AND !empty($data_asso["VILLE"])  AND $data_asso['VILLE'] != ''  AND $data_asso['CP'] != '')
			{
				echo '<br />'.utf8_encode($data_asso["CP"]) . ' '.utf8_encode($data_asso['VILLE']).'';
			}
			echo '</p>';
		}

		//Affichage téléphone
		if (!empty(utf8_encode($data_asso["TELEPHONE"])) AND $data_asso['TELEPHONE'] != '')
		{
			show('<i class="glyphicon glyphicon-earphone earphone" ></i> ' . utf8_encode($data_asso["TELEPHONE"]) . '', '');
		}
		//Affichage mail
		if (!empty($data_asso["MAIL"]) AND $data_asso['MAIL'] != '')
		{
			show('<i class="glyphicon glyphicon-envelope envelope" ></i> <a href="mailto:' . utf8_encode($data_asso["MAIL"]) . '">'.utf8_encode($data_asso["MAIL"]).'</a>', '');
		}
		//Affichage site internet
		if (!empty($data_asso["SITE_INTERNET"]) AND $data_asso['SITE_INTERNET'] != '')
		{
			show('<i class="glyphicon glyphicon-globe globe" ></i> <a target="_blank" href="http://' . utf8_encode($data_asso["SITE_INTERNET"]) . '">' . utf8_encode($data_asso["SITE_INTERNET"]) . '</a>', '');
		}
		if (!empty($data_asso["SITE"]) AND $data_asso['SITE'] != '')
		{
			show('<i class="glyphicon glyphicon-map-marker map-marker" ></i>  <strong>ACCUEIL DU PUBLIC</strong><br />'.utf8_encode($data_asso["SITE"]) . '', '');
		}
		//Affichage Adresse site
		if (!empty($data_asso["ADRESSE_SITE"]) AND $data_asso['ADRESSE_SITE'] != '')
		{
			show(utf8_encode($data_asso["ADRESSE_SITE"]) . '', '');
		}
		//Affichage Public visé
		if (!empty($data_asso["PUBLIC_VISE"]) AND $data_asso['PUBLIC_VISE'] != '')
		{
			show(utf8_encode('<i class="glyphicon glyphicon-user icon-user"></i> <strong>PUBLIC VISE</strong><br />'.$data_asso["PUBLIC_VISE"]) . '', '');
		}
		//Affichage ouverture
		if (!empty($data_asso["OUVERTURE"]) AND $data_asso['OUVERTURE'] != '')
		{
			show('<i class="glyphicon glyphicon-time time" ></i> ' . utf8_encode($data_asso["OUVERTURE"]) . '', '');
		}
		//Affichage permanence
		if (!empty($data_asso["PERMANENCE"]) AND $data_asso['PERMANENCE'] != '')
		{
			show('<i class="glyphicon glyphicon-time time" ></i> ' . utf8_encode($data_asso["PERMANENCE"]) . '', '');
		}

	echo '</div>';
}

?>
