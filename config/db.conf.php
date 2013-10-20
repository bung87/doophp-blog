<?php

//$dbmap['Posts']['belongs_to']['Users'] = array('foreign_key'=>'post_author');
//$dbmap['Food']['has_many']['Article'] = array('foreign_key'=>'food_id');
//$dbmap['Food']['has_one']['Recipe'] = array('foreign_key'=>'food_id');
//$dbmap['Food']['has_many']['Ingredient'] = array('foreign_key'=>'food_id', 'through'=>'food_has_ingredient');
$dbmap['TermTaxonomy']['belongs_to']['Terms'] = array('foreign_key'=>'term_id');
$dbmap['Terms']['has_one']['TermTaxonomy'] = array('foreign_key'=>'term_id');

//$dbconfig[ Environment or connection name] = array(Host, Database, User, Password, DB Driver, Make Persistent Connection?);
/**
 * Database settings are case sensitive.
 * To set collation and charset of the db connection, use the key 'collate' and 'charset'
 * array('localhost', 'database', 'root', '1234', 'mysql', true, 'collate'=>'utf8_unicode_ci', 'charset'=>'utf8'); 
 */

$dbconfig['dev'] = array('localhost', 'database', 'user', 'pass', 'mysql', true,'collate'=>'utf8_general_ci', 'charset'=>'utf8');
$dbconfig['prod'] = array('localhost', 'database', 'user', 'pass', 'mysql', false,'collate'=>'utf8_general_ci', 'charset'=>'utf8');

?>