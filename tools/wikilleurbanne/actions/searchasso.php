<link rel="stylesheet" href="tools/bazar/presentation/styles/moteur_recherche.css">
<?php
/*
textsearch.php
Copyright (c) 2002, Hendrik Mans <hendrik@mans.de>
Copyright 2002, 2003 David DELON
Copyright 2002  Patrick PAUL
Copyright 2004  Jean Christophe ANDR?
All rights reserved.
Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions
are met:
1. Redistributions of source code must retain the above copyright
notice, this list of conditions and the following disclaimer.
2. Redistributions in binary form must reproduce the above copyright
notice, this list of conditions and the following disclaimer in the
documentation and/or other materials provided with the distribution.
3. The name of the author may not be used to endorse or promote products
derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE AUTHOR ``AS IS'' AND ANY EXPRESS OR
IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES
OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT,
INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT
NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF
THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

// label ? afficher devant la zone de saisie
$label = $this->GetParameter('label', _t('WHAT_YOU_SEARCH').'&nbsp;: ');
// largeur de la zone de saisie
$size = $this->GetParameter('size', '40');
// texte du bouton
$button = $this->GetParameter('button', _t('SEARCH'));

// texte ? chercher
$phrase = $this->GetParameter('phrase', false);
// s?parateur entre les ?l?ments trouv?s
$separator = $this->GetParameter('separator', false);

// se souvenir si c'?tait :
// -- un param?tre de l'action : {{textsearch phrase="Test"}}
// -- ou du CGI http://example.org/wakka.php?wiki=RechercheTexte&phrase=Test
//
// r?cup?rer le param?tre de l'action
$paramPhrase = $phrase;
// ou, le cas ?ch?ant, r?cup?rer le param?tre du CGI
if (!$phrase && isset($_GET['phrase'])) $phrase = $_GET['phrase'];

// s'il y a un param?tre d'action "phrase", on affiche uniquement le r?sultat
// dans le cas contraire, pr?senter une zone de saisie
if (!$paramPhrase)
{
	echo $this->FormOpen('', '', 'get');
	echo '<div class="input-prepend input-append input-group input-group-lg barre_recherche">
      <input name="phrase" type="text" class="form-control" placeholder="'.(($label) ? $label : '').'" size="', $size, '" value="', htmlspecialchars($phrase, ENT_COMPAT, YW_CHARSET), '" >';
	  
	  echo '
      <span class="input-group-btn">
        <input type="submit" class="btn btn-primary btn-lg" value="', $button, '" />
      </span>
    </div><!-- /input-group --><br>';
	echo "\n", $this->FormClose();
}

if ($phrase)
{

	// on cherche sur le mot avec entit?s html, le mot encod? par le wiki, ou le mot encod? par bazar en json
	$search = $phrase.','.utf8_decode($phrase).','.substr(json_encode($phrase),1,-1);
	$search = wd_remove_accents($phrase);

	$results_prio = recherche_prio($search);
	$results_actus = baz_requete_recherche_fiches('', 'alphabetique', '3', '', 1, '', '', true, $search);
	$results_events = baz_requete_recherche_fiches('', 'alphabetique', '2', '', 1, '', '', true, $search);
	$results_lieux = baz_requete_recherche_fiches('', 'alphabetique', '6', '', 1, '', '', true, $search);
	$results_echanges = baz_requete_recherche_fiches('', 'alphabetique', '5', '', 1, '', '', true, $search);

	if ($results_prio || $results_actus || $results_events || $results_lieux || $results_echanges)
	{
	
		echo '<p><strong>'._t('SEARCH_RESULT_OF').' "', htmlspecialchars($phrase, ENT_COMPAT, YW_CHARSET), '"&nbsp;:</strong></p>', "\n";
		afficher_resultats($results_prio, 'Associations', $search);
		
		if ($results_actus AND $results_events)
			echo $GLOBALS['wiki']->Format('{{grid}}{{col size="6"}}');
	
		afficher_resultats($results_actus, 'Actualités', $search);
		
		if ($results_actus AND $results_events)
			echo $GLOBALS['wiki']->Format('{{end elem="col"}}{{col size="6"}}');
		
		afficher_resultats($results_events, 'Evénements', $search);
		
		if ($results_actus AND $results_events)
			echo $GLOBALS['wiki']->Format('{{end elem="col"}}{{end elem="grid"}}');
	
	
		if ($results_lieux AND $results_echanges)
			echo $GLOBALS['wiki']->Format('{{grid}}{{col size="6"}}');

		afficher_resultats($results_lieux, 'Lieux', $search);
		
		if ($results_lieux AND $results_echanges)
			echo $GLOBALS['wiki']->Format('{{end elem="col"}}{{col size="6"}}');
		afficher_resultats($results_echanges, 'Echanges', $search);
		
		if ($results_lieux AND $results_echanges)
			echo $GLOBALS['wiki']->Format('{{end elem="col"}}{{end elem="grid"}}');
	
	}
	else
	{
	    if (!$paramPhrase)
	    {
			echo "<div class=\"alert alert-info\">"._t('NO_RESULT_FOR')." \"", htmlspecialchars($phrase, ENT_COMPAT, YW_CHARSET), "\". :-(</div>\n";
	    }
	}
}

function wd_remove_accents($str, $charset='utf-8')
{
    $str = htmlentities($str, ENT_NOQUOTES, $charset);
    
    $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
    $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
    
    return $str;
}

function recherche_prio($search)
{
	$results_bazar = baz_requete_recherche_fiches('', 'alphabetique', '4', '', 1, '', '', true, $search);
	//echo 'Count Bazar : '.count($results_bazar);
	$results_annuaire = MoteurRecherche($search);
	//echo 'Count Annuaire : '.count($results_annuaire);
	return $results_bazar + $results_annuaire;
}

function afficher_resultats($results_array, $type, $phrase)
{	
	sort($results_array);
	if ($results_array)
	{		
		$classe_h3 = '';
		$class_ul = '';
		if ($type == 'Associations')
		{
			$type = 'Associations ▶';
			$classe_h3 = ' class="click-to-toggle" ';
			$classe_ul = ' ResultsAssos ';
		}

		echo '<h3 '.$classe_h3.' >'.$type.'</h3>';
		
		
		echo '<ul class="Recherche '.$classe_ul.'">';
		foreach ($results_array as $i => $page)
		{
				//Si c'est une fiche bazar
				if (isset($page['body']))
					$body_bis = json_decode($page['body']);
				else //Si ça vient de l'annuaire on cherche la fiche correspondante
				{
					$data_page = $GLOBALS['wiki']->LoadSingle('SELECT tag, body FROM yeswiki_pages WHERE tag = "'.$page['tag'].'" AND latest = "Y"');
					$body_bis = json_decode($data_page['body']);
				}
				echo '<li>';
				
				$link = $body_bis->id_fiche; 
					
				echo '<a href="'.$GLOBALS['wiki']->href('', $link).'">';	
				
				if (isset($body_bis) && !empty($body_bis->bf_titre))
					echo $body_bis->bf_titre;
				else 
					echo $page['tag'];										
				echo '</a>';
				echo '</li>';
		}
		echo '</ul>';		
	}
}

function MoteurRecherche($phrase)
{
	$phrase = mysqli_real_escape_string($GLOBALS['wiki']->dblink, $phrase);
	$request_annuaire_champs_prio = "
		SELECT tag FROM annuaire_assos 
		WHERE (MAIL IS NOT NULL OR MAIL != '') AND (
		tag LIKE '%".$phrase."%' OR  
		DESCRIPTIF LIKE '%".$phrase."%' OR
		SIGLE LIKE '%".$phrase."%' OR
		LIBELLE_CATEGORIE LIKE '%".$phrase."%' OR
		LIBELLE_SOUS_CATEGORIE LIKE '%".$phrase."%' OR
		LIBELLE_TIERS LIKE '%".$phrase."%'
		)";
	return $GLOBALS['wiki']->LoadAll($request_annuaire_champs_prio);
}

?>
<script type="text/javascript">
	var button = document.querySelector(".click-to-toggle");

	button.addEventListener('click', function (event) {
    var bloc_asso = document.querySelector('ul.Recherche.ResultsAssos');

    if (bloc_asso.style.display == "none") {
        bloc_asso.style.display = "block";

    } else {
        bloc_asso.style.display = "none";
    }
});
</script>