<?php

$results = baz_requete_recherche_fiches('', 'alphabetique', '4', '', 1, '', '', true, '');

$fiches['fiches'] = array();

foreach ($results as $fiche) 
{
        if (isset($fiche['body'])) 
		{
            $fiche = json_decode($fiche['body'], true);
			$json_data = json_decode($fiche['body'], true);

			
			$fiche2 = json_encode($json_data, true);

			
		
			
            if (YW_CHARSET != 'UTF-8') 
			{
                $fiche = array_map('utf8_decode', $fiche);
				echo var_dump($fiche);
				// echo var_dump($fiche);
				// $body = json_encode($fiche);
				
				//Sauvegarde BDD via fonction bazar
				// $this->SavePage($fiche['id_fiche'], $body, '', true);
            }
        }
       // $this->DeleteOrphanedPage($fiche['id_fiche']);	
		
}


?>