<?php 
/*
 *@autor: José Luis
 *@Teste Facil Consulta
 *@Pagination
*/

class Pagination
{   
    private $links;

    public function links()
    {
        return $this->links;
    }

    public function paginate($total_posts, $page_limit, $current_page_num)
    {
        $total_page = ceil($total_posts / $page_limit);
        $next_page = $current_page_num+1; 
        $prev_page = $current_page_num-1; 
        
        $this->links .= '<ul class="pagination justify-content-end">';

        if($current_page_num > 1)
        {
           $this->links .= '<li class="page-item"><a class="page-link" href="'.$prev_page.'" tabindex="-1">Anterior</a></li>';           
        }

        for($i = 1; $i <= $total_page; $i++)
        {

            if($i == $current_page_num){
                $this->links .= '<li class="page-item active"><a class="page-link" href="'.$i.'"">'.$i.'</a></li>'; 
            }else{
                $this->links .= '<li class="page-item"><a class="page-link" href="'.$i.'"">'.$i.'</a></li>'; 
            }
            
        }

        if($total_page+1 != $next_page)
        {
           $this->links .= '<li class="page-item"><a class="page-link" href="'.$next_page.'">Proximo</a></li>';    
        }
    }
}