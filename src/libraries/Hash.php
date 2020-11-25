<?php 
/*
 *@autor: José Luis
 *@Teste Facil Consulta
 *@Hash
*/  

class Hash
{
    private $keyword;

    public function crypt($keyword)
    {
        $this->keyword = $keyword;
        return $this->createHash();
    }

    private function createHash()
    {
        $md5 = md5($this->keyword);

        $md5_2 = md5($md5);
        $sha = sha1($md5_2);

        return base64_encode($sha);
    }

    public function compare($senha1, $senha2)
    {
        if($this->crypt($senha1) == $senha2)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
