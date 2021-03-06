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
} elseif (isset($url[0])) {
    //Estamos em categorias
    $active = '';
    //Selecionar o id da categoria
    $infoCategoria = MySql::conectar()->prepare("SELECT id FROM `tb_site.categorias` WHERE slug = ? ");
    $infoCategoria->execute(array($url[0]));
    $infoCategoria = $infoCategoria->fetch();
    if (empty($infoCategoria)) {
        include('partials/header.php');
        echo '<br><br><br><br><br><br>';
        die(include('pages/404.php'));
    } else {
        $idCategoria = $infoCategoria['id'];
    }

    //Selecionar 10 t´titulos de notícias da categoria
    $infoTituloNoticia = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` WHERE categoria_id = ? LIMIT 10");
    $infoTituloNoticia->execute(array($idCategoria));
    $infoTituloNoticia = $infoTituloNoticia->fetchAll();
    $i = 0;
    foreach ($infoTituloNoticia as $key => $value) {
        $keywords[$i] = $value['titulo'];
        $i++;
    }
} elseif (isset($url[1])) {
    $active = 'class="menu-active"';
} else {
    //Estamos na notícia
    $infoNoticia = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` WHERE slug = ?");
    $infoNoticia->execute(array($url[1]));
    $infoNoticia = $infoNoticia->fetch();
    $keywords[0] = $infoNoticia['titulo'];
}
$c = count($keywords);

require 'partials/header.php';
$contPage = 1;
if (isset($_GET['moreNews'])) {
    $contPage += $_GET['quant'];
    $limit = $contPage * 16;
} else {
    $limit = 16;
}

?>

    <div class="container-principal">
        <?php
        if (isset($idCategoria)) {
            $getNews = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` WHERE categoria_id = ? ORDER BY id DESC LIMIT $limit");
            $getNews->execute(array($idCategoria));
            $getNews = $getNews->fetchAll();

            $totalNewsDb = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` WHERE categoria_id = ?");
            $totalNewsDb->execute(array($idCategoria));
            $totalNewsDb = $totalNewsDb->rowCount();
        } else {
            $getNews = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` ORDER BY id DESC LIMIT $limit");
            $getNews->execute();
            $getNews = $getNews->fetchAll();

            $totalNews = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias`");
            $totalNews->execute();
            $totalNews = $totalNews->fetchAll();
            $totalNewsDb = 0;
            foreach ($totalNews as $key => $value) {
                $totalNewsDb += 1;
            }
        }

        $totalPages = ceil($totalNewsDb / 16);

        if (isset($url[1])) {
            include('pages/noticia.php');
        } else {
            include('pages/home.php');
        }

        require 'partials/footer.php'; ?>

        




