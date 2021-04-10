<?php

    session_start();
    date_default_timezone_set('America/Sao_Paulo');
   $autoload = function ($class) {
    if ($class == 'Email') {
        include_once('classes/phpmailer/PHPMailerAutoload.php');
    }
        include('classes/' . $class . '.php');
   };

    spl_autoload_register($autoload);


    //Servidor hostinger
    define('INCLUDE_PATH', 'http://localhost/portaldenoticias/');

    define('INCLUDE_PATH_PAINEL', INCLUDE_PATH . 'painel/');
    //Conectar com o banco de dados
    define('HOST', 'localhost');
    define('USER', 'root');
    define('PASSWORD', '');
    define('DATABASE', 'portal_noticias');

    define('BASE_DIR_PAINEL', __DIR__ . '/painel');

    //Contantes para painel de controle
    define('NOME_EMPRESA', 'Notícias Now Notícias');
    define("GOOGLE_URL", "https://www.googleapis.com/customsearch/v1?key=AIzaSyCqV9gGA5nMEyreJAjDSfr7P21qL2VRBEw&cx=3e2bee2173c7ed23a&q=");


    //Funções do painel
    function pegaCargo($indice)
    {

        return Painel::$cargos[$indice];
    }

    function selecionadoMenu($par)
    {
        $url = explode('/', @$_GET['url'])[0];
        if ($url == $par) {
            echo 'class="menu-active"';
        }
    }

    function verificaPermissaoMenu($permissao)
    {
        if ($_SESSION['cargo'] >= $permissao) {
            return;
        } else {
            echo 'style="display:none;"';
        }
    }

    function verificaPermissaoPagina($permissao)
    {
        if ($_SESSION['cargo'] >= $permissao) {
            return;
        } else {
            include('painel/pages/permissao_negada.php');
            die();
        }
    }

    function recoverPost($post)
    {
        if (isset($_POST[$post])) {
            echo $_POST[$post];
        }
    }
