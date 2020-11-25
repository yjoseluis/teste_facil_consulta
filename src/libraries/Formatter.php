<?php 
/*
 *@autor: José Luis
 *@Teste Facil Consulta
 *@Formatter
*/  


class Formatter
{
    public function datetime_db($data, $hora)
    {   
        if(!empty($data) && !empty($hora))
        {
            $data = explode("/", $data);
            $hora = explode(":", $hora);

            $data_time_formated = $data[2].'-'.$data[1].'-'.$data[0].' '.$hora[0].':'.$hora[1];
            return  $data_time_formated;
        }    
    }

    public function db_datetime($dataTime)
    {   
        if(!empty($dataTime))
        {   
            $data_time = explode(" ", $dataTime);
            $data = explode("-", $data_time[0]);
            $time = explode(":", $data_time[1]);

            $data_time_formated = $data[2].'/'.$data[1].'/'.$data[0].' '.$time[0].':'.$time[1];
            return  $data_time_formated;
        }    
    }
}   