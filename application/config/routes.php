<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route['default_controller'] = 'core/components';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['(.+)'] = 'core/components';
 
