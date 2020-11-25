<?php
/*
 *@autor: José Luis
 *@Teste Facil Consulta
 *@Config
*/

date_default_timezone_set("America/Sao_Paulo");

//Constantes de Sistema
define('BASE_URL', 'http://localhost/facil/src/');

define('CONTROLLERS_DIR', './controller/');
define('LIBRARY_DIR', './libraries/');
define('MODELS_DIR', './model/');
define('VIEWS_DIR', './view/');
define('SYSTEM_DIR', './system/');
define('EXT', '.php');
define('ASSETS', BASE_URL.'./model/');

//Constantes de Configuração
define('DEFAULT_CONTROLLER', 'medico');

//Constante de configuração do limite de registros por página
define('PER_PAGE', 5);