<!DOCTYPE html>
<html lang="pt-br">
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-160703328-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-160703328-2');
</script>
    <meta name="author" content="Danilo Augusto" >  
    <meta name="keywords" content="<?php
    for ($i = 0; $i < $c; $i++) {
        print($keywords[$i]);
        if ($c > $i + 1) {
            print(', ');
        } else {
            print('.');
        }
    }?>"> 
    
    <meta name="description" content=" Aqui você encontra as notícias mais quentes do momento.">   
    <meta name="robots" content="index, follow" />
    <meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
    <meta name="bingbot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
    <link rel="canonical" href="<?= INCLUDE_PATH ?>" />     
    <meta property="og:locale" content="pt_BR" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Notícias Now - O seu portal de notícias." />
    <meta property="og:description" content=" Aqui você encontra as notícias mais quentes do momento." />
    <meta property="og:url" content="<?= INCLUDE_PATH ?>" />
    <meta property="og:site_name" content="Notícias Now - O seu portal de notícias." />
    <meta property="article:modified_time" content="2020-09-01T00:04:51+00:00" />
    <meta property="og:image" content="<?= INCLUDE_PATH; ?>images/bg-content.jpg" />
    <meta name="twitter:card" content="summary" />   
    <meta name="twitter: description" 
    content = "Aqui você encontra as notícias mais quentes do momento."> 
    <meta name="twitter: title" content = "Notícias Now - O seu portal de notícias.">
    <meta name="twitter: image" content = "<?= INCLUDE_PATH; ?>images/bg-content.jpg">
    <meta name="twitter: site" content = "@danilodansol">    

    <?php $urlTitle = isset($url[1]) ? 'Notícias sobre ' . $url[1] : 'O seu portal de notícias' ?>

    <title><?= $infoSite['titulo']; ?> | <?= ucfirst($urlTitle) ?></title>
    <link href="<?= INCLUDE_PATH; ?>estilo/css/all.css" rel="stylesheet"> <!--load all styles -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,700&display=swap" rel="stylesheet">
    <link href="<?= INCLUDE_PATH; ?>estilo/style.css" rel="stylesheet"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= INCLUDE_PATH; ?>favicon.ico" type="image/x-icon"/>
     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta charset="UTF-8">   
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <div class="background-news"></div>
    <div class="container">
        <header>        
            <div class="center">            
                <div class="logo left">
                    <a href="<?= INCLUDE_PATH; ?>" >
                        <img src="<?= INCLUDE_PATH; ?>images/logo-new.png" alt="Logomarca do portal de notícias - Notícias Now">
                    </a>
                </div><!--logo-->
                <nav aria-label="Navegação" class="desktop right">            
                    <ul>
                        <li><a <?= $active ?> title="home" href="<?= INCLUDE_PATH; ?>">home</a></li>
                        <?php
                        $categorias = MySql::conectar()->prepare("SELECT * FROM `tb_site.categorias`
                        ORDER BY order_id ASC");
                        $categorias->execute();
                        $categorias = $categorias->fetchAll();
                        foreach ($categorias as $key => $value) {
                            ?>
                        <li><a <?php if (!empty(explode('/', @$_GET['url'])[1])) {
                                        echo selecionadoMenu($value['nome']);
                            } ?> title="Veja notícias sobre <?= $value['nome']; ?>" href="<?= INCLUDE_PATH; ?><?= $value['slug']; ?>"><?= $value['nome']; ?></a>
                        </li>     
                        <?php } ?>
                    </ul>    
                </nav>
                <nav aria-label="Navegação" class="mobile right">
                    <div class="botao-menu-mobile"><em class="fas fa-bars"></em></div>
                    <ul>
                        <li><a <?= $active ?> title="home" href="<?= INCLUDE_PATH; ?>">Home</a></li>
                        <?php
                        $categorias = MySql::conectar()->prepare("SELECT * FROM `tb_site.categorias`
                        ORDER BY order_id ASC");
                        $categorias->execute();
                        $categorias = $categorias->fetchAll();
                        foreach ($categorias as $key => $value) {
                            ?>
                        <li><a <?php if (!empty(explode('/', @$_GET['url'])[1])) {
                                        echo selecionadoMenu($value['nome']);
                            } ?> title="Veja notícias sobre <?= $value['nome']; ?>" href="<?= INCLUDE_PATH; ?><?= $value['slug']; ?>"><?= $value['nome']; ?></a>
                        </li>     
                        <?php } ?>                
                    </ul>
                </nav>
                <div class='clear'></div>
            </div><!--center-->
        </header>

        <section class="header-noticias">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="box-content-sidebar">
                            <h3><i class="fa fa-search"></i> Busca no <img style="width:18%;margin:0 0 -10px 6px" src="<?= INCLUDE_PATH ?>images/google.png" alt="Logo do Google"></h3>
                            <form method="post">
                                <input type="text" name="search" placeholder="O que deseja procurar?" required>
                                <input type="hidden" name="busca">
                                <input type="submit" name="google" value="Pesquisar!">
                            </form>
                        </div><!--box-content-sidebar-->
                    </div>
                    <div class="col-md-4">
                        <div class="title">
                            <h2><i class="far fa-newspaper" aria-hidden="true"></i></h2>
                            <h2 style="font-size: 17px;">Acompanhe as últimas <b><h1>notícias</h1> do portal</b></h2>
                        </div>
                    </div>
                
                    <div class="col-md-4">
                        <div class="box-content-sidebar">
                            <form action="Formulario/enviar.php" class="form" method="post">
                                <h3>Receba nossas notícias!</h3>
                                <input type="email" name="email"  placeholder="Seu e-mail" required/>
                                <input type="hidden" name="language" value="<?= explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE'])[0] ?>">
                                <input type="submit" name="acao" value="Cadastrar!">
                            </form> <!--banner-principal-->
                        </div><!--box-content-sidebar-->
                    </div>
                </div>
            </div>
        </section>