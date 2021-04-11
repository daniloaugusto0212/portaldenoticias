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
} elseif ($url[0] != '' && (!isset($url[1]))) {
    //Estamos em categorias
    $active = '';
    //Selecionar o id da categoria
    $infoCategoria = MySql::conectar()->prepare("SELECT id FROM `tb_site.categorias` WHERE slug = ? ");
    $infoCategoria->execute(array($url[0]));
    $infoCategoria = $infoCategoria->fetch();
    $idCategoria = $infoCategoria['id'];

    //Selecionar 10 t´titulos de notícias da categoria
    $infoTituloNoticia = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` WHERE categoria_id = ? LIMIT 10");
    $infoTituloNoticia->execute(array($idCategoria));
    $infoTituloNoticia = $infoTituloNoticia->fetchAll();
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
if (isset($_GET['page'])) {
    $contPage = (int)$_GET['page'];
    $indexStart = ($contPage - 1) * 16;
} else {
    $contPage = 1;
    $indexStart = 0;
}

?>

    <div class="container-principal">
        <?php
        if (isset($idCategoria)) {
            $getNews = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` WHERE categoria_id = ? ORDER BY id DESC LIMIT $indexStart, 16");
            $getNews->execute(array($idCategoria));
            $getNews = $getNews->fetchAll();

            $totalNews = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` WHERE categoria_id = ?");
            $totalNews->execute(array($idCategoria));
            $totalNews = $totalNews->rowCount();
        } else {
            $getNews = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` ORDER BY id DESC LIMIT $indexStart,16");
            $getNews->execute();
            $getNews = $getNews->fetchAll();

            $totalNews = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias`");
            $totalNews->execute();
            $totalNews = $totalNews->rowCount();
        }

        $totalPages = ceil($totalNews / 16);

        if (isset($url[2])) {
            include('pages/noticia_single.php');
        } else {
            include('pages/home.php');
        }
        ?>

   </div><!--container-principal-->  
   <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
        <li class="page-item">
                <a class="page-link" href="<?= INCLUDE_PATH ?>?page=<?= $contPage - 1 ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <?php
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($contPage == $i) {
                    $active = 'active';
                } else {
                    $active = '';
                }
                ?>
                <li class="page-item <?= $active ?>"><a class="page-link" href="<?= INCLUDE_PATH ?>?page=<?= $i ?>"><?= $i ?></a></li>
            <?php } ?>
            <li class="page-item">
                <a class="page-link" href="<?= INCLUDE_PATH ?>?page=<?= $contPage + 1 ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>
   <?php require 'partials/footer.php'; ?>

        




