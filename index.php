<?php include('config.php');
Site::updateUsuarioOnline();
Site::contador();
$infoSite = MySql::conectar()->prepare("SELECT * FROM `tb_site.config`");
$infoSite->execute();
$infoSite = $infoSite->fetch();

$url = @explode('/', $_GET['url']);
$keywords = [];
if ($url[0] == '') {
    //Estamos na Home
    $active = 'class="menu-active"';
    $keywords[0] = "noticias,portal de noticias, news, Últimas notícias do Brasil e do mundo, sobre política, economia, emprego, educação, saúde, meio ambiente, tecnologia, ciência, cultura e carros.";
} elseif ($url[1] != '' && (!isset($url[2]))) {
    //Estamos em categorias
    $active = '';
    //Selecionar o id da categoria
    $infoCategoria = MySql::conectar()->prepare("SELECT id FROM `tb_site.categorias` WHERE slug = ? ");
    $infoCategoria->execute(array($url[1]));
    $infoCategoria = $infoCategoria->fetch();
    $idCategoria = $infoCategoria['id'];

    //Selecionar 10 t´titulos de notícias da categoria
    $infoTituloNoticia = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` WHERE categoria_id = ? LIMIT 10");
    $infoTituloNoticia->execute(array($idCategoria));
    $infoTituloNoticia = $infoTituloNoticia->fetchAll();
    // print_r($infoTituloNoticia[3]['titulo']);
    $i = 0;
    foreach ($infoTituloNoticia as $key => $value) {
        $keywords[$i] = $value['titulo'];
        $i++;
    }
} elseif (isset($url[2])) {
    $active = 'class="menu-active"';
} else {
    //Estamos na notícia
    $infoNoticia = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` WHERE slug = ?");
    $infoNoticia->execute(array($url[2]));
    $infoNoticia = $infoNoticia->fetch();
    $keywords[0] = $infoNoticia['titulo'];
}
$c = count($keywords);

require 'partials/header.php';

?>

    <div class="container-principal">
        <?php
        if (isset($idCategoria)) {
            $getNews = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` WHERE categoria_id = ? ORDER BY id DESC LIMIT 16");
            $getNews->execute(array($idCategoria));
            $getNews = $getNews->fetchAll();
        } else {
            $getNews = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` ORDER BY id DESC LIMIT 16");
            $getNews->execute();
            $getNews = $getNews->fetchAll();
        }

        if (isset($url[2])) {
            include('pages/noticia_single.php');
        } else {
            include('pages/noticias_new.php');
        }
        ?>

   </div><!--container-principal-->  

   <?php require 'partials/footer.php'; ?>

        




