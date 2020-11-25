<?php
/*
 *@autor: José Luis
 *@Teste Facil Consulta
 *@Database
*/

include('./model/config-banco-dados.php');

class Database
{	
	protected $conn;

    public function __construct()
    {	
        if(DB_NAME != '' && DB_USER != '' && DB_PASS != '' && DB_HOST != '')
        {
            if (is_null($this->conn)) 
            {
                $this->conn = new PDO
                (
                    'mysql:host='.DB_HOST.';
                    port=3306;
                    dbname='.DB_NAME.'', 
                    DB_USER, 
                    DB_PASS
                );

                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->exec('set names utf8');
            }
            
            return $this->conn;
        }
        else
        {
            throw new Exception('Revise suas configurações de Banco de Dados no arquivo config.php na raiz do seu projeto!');
        }
    }	   
}
