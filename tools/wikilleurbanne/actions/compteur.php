<link rel="stylesheet" href="tools/bazar/presentation/styles/compteur.css">
<?php

$results_assos = baz_requete_recherche_fiches('', 'alphabetique', '4', '', 1, '', '', true, '');
$nb_asso = count($results_assos);

$results_actus = baz_requete_recherche_fiches('', 'alphabetique', '3', '', 1, '', '', true, '');
$nb_actus = count($results_actus);

$results_events = baz_requete_recherche_fiches('', 'alphabetique', '2', '', 1, '', '', true, '');
$nb_events = count($results_events);

$results_echanges = baz_requete_recherche_fiches('', 'alphabetique', '5', '', 1, '', '', true, '');
$nb_echanges = count($results_echanges);


?>

<div class="BlocCompteur row-fluid row">
	
	<div class="span3 col-md-3  center">
		<a href="wakka.php?wiki=AnnuAire">
					<span class="nb_compteur"><img src="files/Design/picto/user.svg" height="100"><br>
					<?php echo $nb_asso; ?> associations </span>
		</a>
	</div>
	<div class="span3 col-md-3 center">
		<a href="wakka.php?wiki=AgendA">
				<span class="nb_compteur"><img src="files/Design/picto/placeholder.svg" height="100"><br>
				<?php echo $nb_events; ?> événements </span>
		</a>
	</div>
	<div class="span3 col-md-3 center">
		<a href="wakka.php?wiki=ActuAlites">
				<span class="nb_compteur"><img src="files/Design/picto/megaphone.svg" height="100"><br>
				<?php echo $nb_actus; ?> actualités </span>
		</a>
	</div>
	<div class="span3 col-md-3 center">
		<a href="wakka.php?wiki=EchanGes">
				<span class="nb_compteur"><img src="files/Design/picto/chat.svg" height="100"><br>
				<?php echo $nb_echanges; ?> échanges </span>
		</a>
	</div>
</div>
