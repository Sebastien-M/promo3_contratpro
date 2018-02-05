<?php

$fiches_actus = baz_requete_recherche_fiches('', 'alphabetique', '3', '', 1, '', '10', true, '');

$nb_fiches_extraites = 10; //On affiche les 10 dernieres images des actus
$nb_fiches_extraites = count($fiches_actus) - $nb_fiches_extraites;

$fiches = array_reverse(array_slice($fiches_actus, $nb_fiches_extraites), true); 

if (count($fiches)>0) : $first = true; ?>
	<link rel="stylesheet" href="tools/bazar/presentation/styles/slider_photo_actu.css">
	
    <div id="carousel-bazar10" class="carousel slide  bloc_slider_photo" data-ride="carousel">
      <!-- Indicators -->
 

      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
      <?php
    foreach ($fiches as $fiche): ?> 
			<?php 
				$data_fiche = json_decode($fiche['body']);
				if (!empty($data_fiche->imagebf_image) OR ($data_fiche->imagebf_image != '')) :		
					$src = 'files/'.$data_fiche->imagebf_image;	
			?>
			<div class="item<?php echo ($first ? ' active' : ''); ?> bazar-entry photo_slider"
			<?php echo $fiche['html_data'];?>>  
			<?php $first = false; ?>
			
			
			<img style="max-width: 100%; margin: 0 auto;" src="<?php echo $src; ?>">
			<?php echo '<a href="wakka.php?wiki='.$data_fiche->id_fiche.'"><h6 style="text-align: right;">'.$data_fiche->bf_titre.'</h6></a>'; ?>
			
			</div>      
    <?php endif; endforeach; ?>
      </div>

      <!-- Controls -->
      <a class="left carousel-control" href="#carousel-bazar10" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#carousel-bazar10" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div> <!-- /#carousel-bazar -->
    <?php 
endif;
