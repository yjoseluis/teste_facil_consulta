<?php
/*
 *@autor: José Luis
 *@Teste Facil Consulta
 *@Controller
*/

class Controller
{	
	//Responsável por carregar uma view
	public function loadView($view, $data = array())
	{	
		if(file_exists(VIEWS_DIR.$view.EXT))
 		{	
 			extract($data);
 			require VIEWS_DIR.$view.EXT;
 		}
 		else
 		{
 			throw new Exception($view." não encontrada!");
 		}
	}

	//Responsável por carregar um model
	public function loadModel($model)
	{		
		if(file_exists(MODELS_DIR.$model.EXT))
 		{	
 			require MODELS_DIR.$model.EXT;
			return new $model();
 		}
 		else
 		{
 			throw new Exception($model." não encontrada!");
 		}
	}

	//Responsável por carregar um biblioteca
	public function loadLibrarie($library)
	{		
		if(file_exists(LIBRARY_DIR.$library.EXT))
 		{	
 			require LIBRARY_DIR.$library.EXT;
			return new $library();
 		}
 		else
 		{
 			throw new Exception($library." não encontrada!");
 		}
	}	   
}
