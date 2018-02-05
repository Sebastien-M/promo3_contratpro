<?php

$UserIsConnected = $GLOBALS['wiki']->GetUser();

if ($UserIsConnected)
{
	$data_texte = 'Compte';
}
else
{
	$data_texte = "Connexion";
}

echo '<a href="'.$this->href('', 'ParametresUtilisateur').'">'.$data_texte.'</a>';

?>