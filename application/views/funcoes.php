<?php 
function carrega_pagina(){
    (isset($_GET['p'])) ? $pagina = $_GET['p'] : $pagina = 'home';
    if(file_exists('page_'.$pagina.'.php')):
        require_once('page_'.$pagina.'.php');
else:
        require_once('page_home.php');
    endif;
}

function gera_titulos(){
    (isset($_GET['p'])) ? $pagina = $_GET['p'] : $pagina = 'home';
    switch ($pagina):
        case 'home':
            $titulo = 'home - desenvolvimento web';
            break;

        case 'fale_conosco':
            $titulo = 'contato - desenvolvimento web';
            break;

        case 'estrutura_curricular':
            $titulo = 'estrutura - desenvolvimento web';
            break;
        
        default:
        $titulo = 'home - desenvolviemnto web';
            
            break;
    endswitch;
    return $titulo;
}