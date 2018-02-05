<?php

	$id_fiche = $this->GetParameter("fiche");
	$nom_page_modifiable = $id_fiche.'Contenu';
	
	if ($this->UserIsOwner())
	{
		echo '<a href="'.$this->href('', $nom_page_modifiable).'">Ajouter et modifier votre contenu personnalisé en cliquant ici.</a><br />';
	}
	
	if ($fiche = $this->LoadSingle('SELECT * FROM '.$this->config['table_prefix'].'pages WHERE latest="Y" AND tag="'.$nom_page_modifiable.'";'))
	{
		echo $GLOBALS['wiki']->Format('{{include page="'.$nom_page_modifiable.'" doubleclic="1"}}');
	}
	else
	{
		echo 'Cette association n\'a pas encore de contenu personnalisé.';
	}
	
?>