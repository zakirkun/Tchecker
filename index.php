<?php
require_once 'def.php';
session_start();
/*if(isset($_SESSION['adm'])){

}*/
    if(!isset($_SESSION['logado'])){
        if(isset($_REQUEST['pot'])){
            $req = $_REQUEST['pot'];
                switch($req){
                    case 'login':
                        include_once PROC.'/login.php';
                        break;
                    default:
                        header("Location: ?pg=erro&erro=404");
                        break;
                }
        }
        else{
            include_once VIEW_DESLOGADO.'/header.php';
            $get = '';
            if(isset($_GET['pg'])){
                $get = $_GET['pg'];
            }
            switch($get){
                case 'index':
                    include_once VIEW_DESLOGADO.'/index.php';
                    break;
                case 'login':
                    include_once VIEW_DESLOGADO.'/index.php';
                    break;
                case 'erro':
                    include_once VIEW.'/error.php';
                    break;
                default:
                    include_once VIEW_DESLOGADO.'/index.php';
                    break;
            }
            include_once VIEW_DESLOGADO.'/footer.php';
        }
    }else{
        if(isset($_REQUEST['pot'])){
            $req = $_REQUEST['pot'];
            switch($req){
                case 'checkers':
                    include_once PROC.'/chk/index.php';
                    break;
                case 'deslogar';
                    include_once PROC.'/deslogar.php';
                    break;
                default:
                    include_once VIEW.'/error.php';
                    break;  
            }
        }else{
            $get = '';
            if(isset($_GET['pg'])){
                $get = $_GET['pg'];
            }
            include_once VIEW_LOGADO.'/header.php';
            switch($get){
                case 'index':
                    include_once VIEW_LOGADO.'/index.php';
                    break;
                case 'checkers':
                    include_once VIEW_LOGADO.'/chk/checkers.php';
                    break;
                case 'erro':
                    include_once VIEW.'/error.php';
                    break;
                default:
                    include_once VIEW_LOGADO.'/index.php';
                    break;
            }
            include_once VIEW_LOGADO.'/footer.php';
        }
    }