<?php

$route['custom'] = array();
$route['custom']['/s/:dt'] = array('BlogController', 'single','id'=>'s');
$route['custom']['/d/:dt'] = array('BlogController', 'diary_one','id'=>'d');
$route['custom']['/admin/edit/:dt'] = array('AdminController', 'edit','id'=>'e');
$route['custom']['/p/:x'] = array('BlogController', 'p','id'=>'p');
$route['custom']['/tag/:x'] = array('BlogController', 'tag','id'=>'t');

$route['get']['/'] = array('BlogController', 'index');
$route['*']['catchall']['/p'] = array('BlogController', 'p');
$route['*']['catchall']['/a'] = array('BlogController', 'archives');
$route['*']['catchall']['/s'] = array('BlogController', 'single','id'=>'s');
$route['*']['catchall']['/d'] = array('BlogController', 'diary_one','id'=>'d');
$route['*']['catchall']['/rss/:category/:pindex'] = array('BlogController', 'rss');
$route['get']['/page/:pindex'] = array('BlogController', 'page', 'match'=> array(
                                            'pindex'=>'/^\d+$/'
                                         ));
$route['get']['/diary/:pindex'] = array('BlogController', 'diary', 'match'=> array(
                                            'pindex'=>'/^\d+$/'
                                         ));
$route['*']['catchall']['/category/:category/:pindex'] = array('BlogController', 'category');
$route['*']['catchall']['/tag'] = array('BlogController', 'tag');
$route['*']['/search'] = array('BlogController', 'search');
$route['*']['/comment'] = array('BlogController', 'comment');
$route['*']['/profile'] = array('BlogController', 'profile');
$route['*']['/diary'] = array('BlogController', 'diary');
$route['*']['/admin/comments/:filter'] = array('AdminController', 'comments');
$route['autoroute_alias']['/admin'] = 'AdminController';
$route['autoroute_alias']['/rest'] = 'RestController';
//$route['*']['/welcome'] = array('MainController', 'index');
$route['*']['/error'] = array('ErrorController', 'index');


//---------- Delete if not needed ------------
//$admin = array('admin'=>'1234');

//view the logs and profiles XML, filename = db.profile, log, trace.log, profile
//$route['*']['/debug/:filename'] = array('MainController', 'debug', 'authName'=>'DooPHP Admin', 'auth'=>$admin, 'authFail'=>'Unauthorized!');

//show all urls in app
//$route['*']['/allurl'] = array('MainController', 'allurl', 'authName'=>'DooPHP Admin', 'auth'=>$admin, 'authFail'=>'Unauthorized!');

//generate routes file. This replace the current routes.conf.php. Use with the sitemap tool.
//$route['post']['/gen_sitemap'] = array('MainController', 'gen_sitemap', 'authName'=>'DooPHP Admin', 'auth'=>$admin, 'authFail'=>'Unauthorized!');

//generate routes & controllers. Use with the sitemap tool.
//$route['post']['/gen_sitemap_controller'] = array('MainController', 'gen_sitemap_controller', 'authName'=>'DooPHP Admin', 'auth'=>$admin, 'authFail'=>'Unauthorized!');

//generate Controllers automatically
//$route['*']['/gen_site'] = array('MainController', 'gen_site', 'authName'=>'DooPHP Admin', 'auth'=>$admin, 'authFail'=>'Unauthorized!');

//generate Models automatically
//$route['*']['/gen_model'] = array('MainController', 'gen_model', 'authName'=>'DooPHP Admin', 'auth'=>$admin, 'authFail'=>'Unauthorized!');
//$route['*']['/deldir'] = array('MainController', 'deldir', 'authName'=>'DooPHP Admin', 'auth'=>$admin, 'authFail'=>'Unauthorized!');


?>