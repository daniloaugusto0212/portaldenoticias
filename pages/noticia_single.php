<?php
	$url = explode('/',$_GET['url']);
	

	$verifica_categoria = MySql::conectar()->prepare("SELECT * FROM `tb_site.categorias` WHERE slug = ?");
	$verifica_categoria->execute(array($url[1]));
	if($verifica_categoria->rowCount() == 0){
		Painel::redirect(INCLUDE_PATH.'noticias');
	}
	$categoria_info = $verifica_categoria->fetch();

	$post = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` WHERE slug = ? AND categoria_id = ?");
	$post->execute(array($url[2],$categoria_info['id']));
	if($post->rowCount() == 0){
		Painel::redirect(INCLUDE_PATH.'noticias');
	}

	//É POR QUE MINHA NOTICIA EXISTE
	$post = $post->fetch();

?>
<section class="noticia-single">
	<div class="center">
		<header>
			<h1><i class="fa fa-calendar"></i> <?php echo date('d/m/Y',strtotime($post['data'])) ?> - <?php echo $post['titulo'] ?></h1>
		</header>
		<div style="padding:50px;" >
			<?php echo $post['subtitulo']; ?>        
		</div>
		<div style="display: block;
    margin-left: auto;
    margin-right: auto;">
			<img src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $post['capa']; ?>" alt="capa">
		</div>
		<article>
			<?php echo $post['conteudo']; ?>
			<a href="<?php echo INCLUDE_PATH ?>">Voltar</a>
		</article>
	</div>
</section>