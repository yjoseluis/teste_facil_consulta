<?php 
/*
 *@autor: José Luis
 *@Teste Facil Consulta
 *@Response
*/

Class Response
{
    private $text;
    private $type;

    public function emit($type, $text)
    {
        $this->text  = $text;
        $this->type  = $type;

        return $this->generateMsg();
    }

    private function generateMsg()
    {
        return array('type' => $this->type, 'text' => $this->text);
    }
}
