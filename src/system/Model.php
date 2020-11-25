<?php
/*
 *@autor: José Luis
 *@Teste Facil Consulta
 *@Model
*/

class Model extends Database
{	
	public function __Construct()
    {
        parent::__construct();
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
