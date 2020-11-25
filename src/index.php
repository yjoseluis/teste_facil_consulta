<?php 
/*
 *@autor: José Luis
 *@Teste Facil Consulta
 *@Index
*/	

require 'config.php';

spl_autoload_register(function($class)
{
	if(file_exists(CONTROLLERS_DIR.$class.EXT))
	{
		include(CONTROLLERS_DIR.$class.EXT);
	}
	else if(file_exists(SYSTEM_DIR.$class.EXT))
	{
		include(SYSTEM_DIR.$class.EXT);
	}
	else
	{
		throw new Exception($class." não encontrada!");			
	}
});

$core = new Core();
$core->init();