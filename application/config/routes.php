<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
| 	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['scaffolding_trigger'] = 'scaffolding';
|
| This route lets you set a "secret" word that will trigger the
| scaffolding feature for added security. Note: Scaffolding must be
| enabled in the controller in which you intend to use it.   The reserved 
| routes must come before any wildcard or regular expression routes.
|
*/
$route['default_controller'] = "main";
$route['scaffolding_trigger'] = "";

$route['dashboard/(:any)'] = "$1/admin_index";
$route['dashboard/(:any)/(:any)'] = "$1/$2";
$route['dashboard/(:any)/(:any)/(:any)'] = "$1/$2/$3";

$route['catalog/search'] = "catalog/search/";
$route['catalog/(:any)'] = "catalog/index/$1";
$route['catalog/(:any)/(:any)'] = "catalog/index/$1/$2";
$route['product/(:any)'] = "product/index/$1";
$route['articles/(:num)'] = "articles/index/$1";
$route['news/(:num)'] = "news/index/$1";
$route['faq/(:num)'] = "faq/index/$1";
$route['portfolio/(:num)'] = "portfolio/index/$1";
$route['gallery'] = "portfolio/index";
$route['gallery/(:num)'] = "portfolio/index/$1";
$route['gallery/view/(:any)'] = "portfolio/view/$1";

$route['admin/logout'] = "admin/logout";
$route['admin/validate_credentials'] = "admin/validate_credentials";

// ajax requests
$route['ajax/(:any)'] = "ajax/$1";



/* End of file routes.php */
/* Location: ./system/application/config/routes.php */