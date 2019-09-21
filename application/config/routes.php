<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//General:
$route['404_override']              = 'user_app/page_not_found';
$route['translate_uri_dashes']      = FALSE;
$route['default_controller']        = "intents/in_public_ui";

//Trainer Intents/Entities:
$route['entities/(:num)']           = "entities/en_train/$1";
$route['entities']                  = "entities/en_train/0";
$route['intents/(:num)']            = "intents/in_train/$1";
$route['intents']                   = "intents/in_train/0";

$route['(:num)_(:num)']             = "intents/in_public_ui/$2/$1"; //Public Intent Landing Page
$route['(:num)']                    = "intents/in_public_ui/$1"; //Public Intent Landing Page
$route['completion_rates']          = "intents/in_completion_rates";

//Users:
$route['signin']                    = "user_app/signin";
$route['(:num)_(:num)/signin']      = "user_app/signin/$2/$1";
$route['(:num)/signin']             = "user_app/signin/$1";
$route['resetpassword/(:num)']      = "user_app/signin_reset_password_ui/$1";
$route['magiclogin/(:num)']         = "user_app/singin_magic_link_login/$1";

$route['signout']                   = "user_app/signout";
$route['myaccount']                 = "user_app/myaccount";
$route['actionplan']                = "user_app/actionplan/0";
$route['actionplan/delete']         = "user_app/actionplan_delete";
$route['actionplan/delete/(:num)']  = "user_app/actionplan_delete/$1";
$route['actionplan/next']           = "user_app/actionplan/next";
$route['actionplan/(:num)']         = "user_app/actionplan/$1";

$route['dashboard']                 = "trainer_app/dashboard";