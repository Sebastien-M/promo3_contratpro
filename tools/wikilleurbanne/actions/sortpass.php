<?php 

$data = $GLOBALS['wiki']->LoadAll("SELECT name, email FROM `yeswiki_users` WHERE name NOT LIKE 'MaisonDeLaCultureChinoiseDeLyon' AND name NOT LIKE 'LanomadinE' AND name NOT LIKE 'MaisonDeLInitiativeDeLEngagementDuTro' AND name NOT LIKE 'HendiAssociation' AND name NOT LIKE 'WikiAdmin' AND name NOT LIKE 'VillE' AND name NOT LIKE 'AssociationGratteSel' AND name NOT LIKE 'SiSiLesFemmesExistent' AND name NOT LIKE 'GaiaCheminsDeFemmes' AND name NOT LIKE 'FraterniteTogolaiseNovissi' AND name NOT LIKE 'FranceBenevolatLyonRhone' ORDER BY `yeswiki_users`.`password` ASC");
$nb_fiche = count($data);
$i = 0;
foreach($data as $fiche)
{
	$pass_hash = substr(rand(), 0, 10);
	$name = $fiche['name'];
	$query_update = "UPDATE `yeswiki_users` SET `password` = md5('".$pass_hash."') WHERE `name` = '".$name."'";
	if ($GLOBALS['wiki']->query($query_update))
	{
		$i++;
		echo '"'.$fiche['name'].'";"'.$fiche['email'].'";"'.$pass_hash.'";<br />';
	}
		
}

echo 'Total : '.$i.' / '.$nb_fiche.'<hr />';

?>