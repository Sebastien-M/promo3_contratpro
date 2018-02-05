<?php

$results = baz_requete_recherche_fiches($params['query'], 'alphabetique', '4', '', 1, '', '', true, '');

$fiches['fiches'] = array();

foreach ($results as $fiche) 
{
        if (isset($fiche['body'])) 
		{
            $fiche = json_decode($fiche['body'], true);
            if (YW_CHARSET != 'UTF-8') 
			{
                $fiche = array_map('utf8_decode', $fiche);
            }
        }
       // $this->DeleteOrphanedPage($fiche['id_fiche']);	
		
}


?>