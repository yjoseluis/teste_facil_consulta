<?php 
/*
 *@autor: José Luis
 *@Teste Facil Consulta
 *@Core
*/	

class Core
{ 	
	//Responsável fazer as rotas do sistema. No lugar de usar medico.php é usado somente medico, assim acessando diretamente o controller
	public function init()
	{
		$url = '/';
		$params = array();

		if(isset($_GET['url']))
		{
			$url .= $_GET['url'];
		}

		if(!empty($url) && $url != '/')
		{
			$url = explode('/', $url);
			array_shift($url);

			$controller = ucfirst($url[0]).'Controller';

			if(file_exists(CONTROLLERS_DIR.$controller.EXT))
			{
				array_shift($url);
				
				if(isset($url[0]) && !empty($url[0]))
				{
					$action = $url[0];

					if(method_exists($controller, $action))
					{
						array_shift($url);
					}
					else
					{
						throw new Exception("Método ".$action." não encontrado no controller ".$controller);
					}						
				}
				else
				{
					$action = 'index';
				}

				if(count($url) > 0)
				{
					$params = $url;
				}
			}
			else
			{
				throw new Exception($controller." não encontrado!");
			}
		}
		else
		{
			$controller = DEFAULT_CONTROLLER.'Controller';
			$action     = 'index';
		}

		$c = new  $controller();
		call_user_func_array(array($c, $action), $params);
	}
}