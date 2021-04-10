<?php
	$url = explode('/', $_GET['url']);
	

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
			<img src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $post['capa']; ?>" alt="Imagem de capa da notícia">
		</div>
		<article>
			<?php echo $post['conteudo']; ?>
			
		</article>

		<div class="box-single-conteudo w50 left propaganda">
			<h2 style="color:#ffcf00">CRIAÇÃO DE SITES E SISTEMAS WEB</h2>						
				<p>Somos uma agência especializada em Desenvolvimento de Sistemas Web, Criação de Sites, Portais, E-Commerce e soluções para web.</p>
				<br>
				<a href="https://sitedan.com.br" target="_blank" rel="external">
					<img src="<?php echo INCLUDE_PATH ?>images/sitedan.png" alt="Imagem capa sitedan criação de sites e sistemas web">
				</a>
			<br>	
			
			<p><?php echo substr(strip_tags("Somos uma agência especializada em Desenvolvimento de Sistemas Web, Criação de Sites, Portais, E-Commerce e soluções para web. Estamos comprometidos em transformar os desafios dos investidores em oportunidades, resolvendo-os da maneira mais eficiente e notável. Limpamos as bagunças, simplificando os processos para facilitar as coisas para nossos clientes. Nossos serviços de web design concentram-se na criação de sites bonitos e centrados no usuário que reforçam a nossa marca e aumentam seus resultados."),0,300).'...'; ?></p>
			<a class="box-single" href="https://sitedan.com.br" target="_blank" rel="external">Leia mais</a>
		</div><!--box-single-conteudo-->
		
		<div class="box-single-conteudo w50 left propaganda">
			<h2 style="color:#2163B0">DECLARAÇÃO ANUAL DO MEI</h2>						
				<p>Para isso, basta você declarar a sua renda anual, ou seja, tudo que ganhou no ano anterior com vendas e prestação de serviços.</p>
				<br>
				<a href="https://abrircnpjmei.com.br/declaracao" target="_blank" rel="external">
					<img src="<?php echo INCLUDE_PATH ?>images/cnpjmei.png" alt="Imagem empresa Abrir CPNJ Mei - Faça a declaração do MEI">
				</a>
			<br>	
			
			<p></p> 
			<p><?php echo substr(strip_tags("O processo é OBRIGATÓRIO para todos os MEIs que abriram o CNPJ no ano anterior, independente do valor de faturamento. 
			Na hora de fazer a sua Declaração Anual, vale lembrar de algumas informações importantes!. O prazo para envio da Declaração Anual se inicia em Janeiro e vai até Maio. Ou seja, você tem cinco meses para declarar a renda obtida no ano anterior; 
			O limite atual de faturamento para o MEI é de R$81 mil reais. O cálculo desse valor deve ser proporcional à quantidade de meses em que a sua empresa está aberta. Se você abriu seu CNPJ apenas no meio do ano, o seu limite de faturamento será menor; 
			A multa por atraso pode chegar a até R$50. Faça a sua Declaração o quanto antes para evitar maiores preocupações futuramente. 
			"),0,400).'...'; ?></p>
			<a class="box-single" href="https://abrircnpjmei.com.br/declaracao" target="_blank" rel="external">Leia mais</a>
		</div><!--box-single-conteudo-->
		<div class="clear"></div>

		<a class="btn" href="<?php echo INCLUDE_PATH ?>"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Voltar</a>
	</div>
</section>