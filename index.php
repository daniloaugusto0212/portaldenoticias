<?php include('config.php'); ?>
<?php Site::updateUsuarioOnline(); ?>
<?php Site::contador(); ?>
<?php
    $infoSite = MySql::conectar()->prepare("SELECT * FROM `tb_site.config`");
    $infoSite->execute();
    $infoSite = $infoSite->fetch();
?>

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
    <title><?php echo $infoSite['titulo']; ?></title>
    <link href="<?php echo INCLUDE_PATH; ?>estilo/css/all.css" rel="stylesheet"> <!--load all styles -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,700&display=swap" rel="stylesheet">
    <link href="<?php echo INCLUDE_PATH; ?>estilo/style.css" rel="stylesheet"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Danilo Augusto" >
    <meta name="keywords" content="noticias,portal de noticias, news, Últimas notícias do Brasil e do mundo, sobre política, economia, emprego, educação, saúde, meio ambiente, tecnologia, ciência, cultura e carros. "> <!--palavras chaves do site, colocar até 10-->
    <meta name="description" content="Notícias Now - Portal de notícias." > 
    
       
    <link rel="icon" href="<?php echo INCLUDE_PATH; ?>favicon.ico" type="image/x-icon"/>    
    <meta charset="UTF-8">   
    <meta http-equiv="X-UA-Compatible" content="ie=edge">    
</head>
<body>  
    <header>        
        <div class="center">            
            <div class="logo left"><a href="<?php echo INCLUDE_PATH; ?>" ><img src="<?php echo INCLUDE_PATH; ?>images/logo.png" alt="logo"></a></div><!--logo-->
            <nav class="desktop right">            
                <ul>
                <li><a title="home" href="<?php echo INCLUDE_PATH; ?>noticias/">home</a></li>
                <?php
                $categorias = MySql::conectar()->prepare("SELECT * FROM `tb_site.categorias` ORDER BY order_id ASC");
                $categorias->execute();
                $categorias = $categorias->fetchAll();
                foreach ($categorias as $key => $value) {
                
            ?>
                <li><a title="<php? echo $value['nome']; ?>" href="<?php echo INCLUDE_PATH; ?>noticias/<?php echo $value['nome']; ?>"><?php echo $value['nome']; ?></a></li>     
                <?php } ?>
                </ul> 
                         
            </nav>
            <nav class="mobile right">
                <div class="botao-menu-mobile"><i class="fas fa-bars"></i></div>
                <ul>
                <li><a title="home" href="<?php echo INCLUDE_PATH; ?>noticias/">Home</a></li>
                <?php
                $categorias = MySql::conectar()->prepare("SELECT * FROM `tb_site.categorias` ORDER BY order_id ASC");
                $categorias->execute();
                $categorias = $categorias->fetchAll();
                foreach ($categorias as $key => $value) {
                
            ?>
                <li><a title="<php? echo $value['nome']; ?>" href="<?php echo INCLUDE_PATH; ?>noticias/<?php echo $value['nome']; ?>"><?php echo $value['nome']; ?></a></li>     
                <?php } ?>                
                </ul>
                   
            </nav>
        <div class='clear'></div>
        </div><!--center-->

    </header>

    <div class="container-principal">
        <?php                        
            include('pages/noticias.php');
                
                    
    ?>
   
   </div><!--container-principal-->     
   <footer <?php if(isset($pagina404) && $pagina404 == true) echo 'class="fixed"';?>>
        <div class="center">
            <p>Todo os direitos reservados</p>
        </div><!--center-->
    </footer >
    <script data-ad-client="ca-pub-4705170629656649" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script src="<?php echo INCLUDE_PATH; ?>js/jquery.js"></script>
    <script src="<?php echo INCLUDE_PATH; ?>js/constants.js"></script>
    
    <script src="<?php echo INCLUDE_PATH; ?>js/scripts.js"></script>
  
    <script src="<?php echo INCLUDE_PATH; ?>js/slider.js"></script>

        
</body>

</html>



