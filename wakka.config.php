<?php
// wakka.config.php cr&eacute;&eacute;e Tue Jul  5 12:23:49 2016
// ne changez pas la yeswiki_version manuellement !

$wakkaConfig = array (
  'wakka_version' => '0.1.1',
  'wikini_version' => '0.5.0',
  'yeswiki_version' => 'Cercopitheque',
  'yeswiki_release' => '2016.01.25',
  'debug' => 'yes',
  'mysql_host' => '127.0.0.1',
  'mysql_database' => 'wikilleulyywbdd',
  'mysql_user' => 'WikiAdmin',
  'mysql_password' => 'villeurbanne',
  'table_prefix' => 'yeswiki_',
  'base_url' => 'http://localhost:8080/promo3_contratpro/?',
  'rewrite_mode' => '0',
  'meta_keywords' => 'association villeurbanne',
  'meta_description' => 'Le site des associations villeurbannaises',
  'action_path' => 'actions',
  'handler_path' => 'handlers',
  'header_action' => 'header',
  'footer_action' => 'footer',
  'navigation_links' => 'DerniersChangements :: DerniersCommentaires :: ParametresUtilisateur',
  'referrers_purge_time' => 24,
  'pages_purge_time' => 90,
  'default_write_acl' => '%',
  'default_read_acl' => '*',
  'default_comment_acl' => '@admins',
  'preview_before_save' => 0,
  'allow_raw_html' => '1',
  'root_page' => 'PagePrincipale',
  'wakka_name' => 'Wikilleurbanne',
  'default_language' => 'fr',
  'favorite_theme' => 'bootstrap',
  'favorite_squelette' => '1col.tpl.html',
  'favorite_style' => 'wikilleurbanne.css',
);
?>