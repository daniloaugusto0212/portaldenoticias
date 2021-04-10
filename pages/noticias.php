<?php
if (isset($idCategoria)) {
	$getNews = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` WHERE categoria_id = ? ORDER BY id DESC LIMIT 9");
	$getNews->execute(array($idCategoria));
	$getNews = $getNews->fetchAll();
} else {
	$getNews = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` ORDER BY id DESC LIMIT 9");
	$getNews->execute();
	$getNews = $getNews->fetchAll();
}
?>

<section class="container-portal">
	<div class="center">		
		<div class="sidebar">
			<div class="box-content-sidebar">
				<h3><i class="fa fa-search"></i> Busca no <img style="width:25%;margin:0 0 -10px 6px" src="<?= INCLUDE_PATH ?>images/google.png" alt="Logo do Google"></h3>
				<form method="post">
					<input type="text" name="search" placeholder="O que deseja procurar?" required>
					<input type="hidden" name="busca">
					<input type="submit" name="google" value="Pesquisar!">
				</form>
			</div><!--box-content-sidebar-->
			
			<div class="box-content-sidebar">
				<form action="Formulario/enviar.php" class="form" method="post">
					<h2>Receba nossas notícias!</h2>
					<input type="email" name="email"  placeholder="Seu e-mail" required/>	
					<input type="hidden" name="language" value="<?= explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE'])[0] ?>">					
					<input type="submit" name="acao" value="Cadastrar!">
				</form> <!--banner-principal-->
			</div><!--box-content-sidebar-->

			<?php

			foreach ($getNews as $key => $value) {
				$getCategory = MySql::conectar()->prepare("SELECT * FROM `tb_site.categorias` WHERE id = ?");
				$getCategory->execute(array($value['categoria_id']));
				$getCategory = $getCategory->fetch()['slug'];
				?>
				<div class="box-content-sidebar">
					<!-- Page Content -->
					<div class="container">
					<!-- Page Heading -->
					<h1 class="my-4"><?= date('d/m/Y', strtotime($value['data'])) ?> - <?= $value['titulo'] ?></h1>
						<div class="row">
							<div class="col-lg-3 col-md-4 col-sm-6 mb-4">
								<div class="card h-100">
									<a class="box-single" href="<?= INCLUDE_PATH ?>noticias/<?= $getCategory ?>/<?= $value['slug'] ?>" ><img class="card-img-top" src="<?php echo INCLUDE_PATH_PAINEL ?>/uploads/<?= $value['capa'] ?>" alt="Bolos caseiros da Marrara"></a>
									<a class="box-single" href="<?= INCLUDE_PATH ?>noticias/<?= $getCategory ?>/<?= $value['slug'] ?>" >
									<div style="background: #fff;padding:5px; font-size:18px" class="card-body">
										<h4 class="card-title"><?= $value['subtitulo'] ?></h4>
										<p   class="card-text"> <?= substr(strip_tags($value['conteudo']), 0, 130) . '...' ?></p></h4>
										<input type="submit" name="buscar" value="Leia mais">
									</div></a>
								</div>
							</div>		
						</div>
						<!-- /.row -->
					</div>
					<!-- /.container -->
				</div><!--box-content-sidebar-->		

				<?php } ?>	
		</div><!--sidebar-->

		<div class="conteudo-portal">
			<div class="header-conteudo-portal">
				<?php
				if (isset($_POST['google'])) {
					echo '<h2><i class="fa fa-check" aria-hidden="true"></i> Visualizando Pesquisa do Google</h2>';
				} elseif (isset($url[1])) {
					echo '<h2><i class="fa fa-check" aria-hidden="true"></i> Visualizando notícias em ' . $url[1] . '</h2>';
				} else {
					echo '<h2><i class="fa fa-check" aria-hidden="true"></i> Visualizando notícias do Dia</span></h2>';
				}
				?>						
			</div>

			<?php

			$handle = curl_init();
			$today = date('d/m/Y');
			if (isset($_POST['google'])) {
				$search = urlencode($_POST['search']);
				$url = 'https://www.googleapis.com/customsearch/v1?key=AIzaSyCqV9gGA5nMEyreJAjDSfr7P21qL2VRBEw&cx=3e2bee2173c7ed23a&q=' . $search;
			} elseif (isset($url[1])) {
				$url = 'https://www.googleapis.com/customsearch/v1?key=AIzaSyCqV9gGA5nMEyreJAjDSfr7P21qL2VRBEw&cx=3e2bee2173c7ed23a&q=' . $url[1];
			} else {
				$url = 'https://www.googleapis.com/customsearch/v1?key=AIzaSyCqV9gGA5nMEyreJAjDSfr7P21qL2VRBEw&cx=3e2bee2173c7ed23a&q=' . $today;
			}
				
			// Set the url
			curl_setopt($handle, CURLOPT_URL, $url);
			// Set the result output to be a string.
			curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
			$output = curl_exec($handle);
			curl_close($handle);
				
			$resultado = json_decode($output);
			if (empty($resultado->items)) {
				echo '<h2><i class="fa fa-check"></i>Sua busca não retornou resultados!</h2>';
			} else {
				$totalNews = count($resultado->items);
				for ($i = 0; $i < $totalNews - 8; $i++) {
					?>
					<div class="box-single-conteudo">
						<h2><?php echo $resultado->items[$i]->htmlTitle; ?></h2>						
							<br>						
							<img src="<?php echo $resultado->items[$i]->pagemap->cse_image[0]->src; ?>" alt="Imagem capa da notícia">

							<p><?php echo $resultado->items[$i]->htmlSnippet; ?></p>
						
						<a class="box-single" href="<?php echo $resultado->items[$i]->link; ?>" target="_blank">Leia mais</a>
					</div><!--box-single-conteudo-->

				<?php } ?>

				<div class="box-single-conteudo">
					<h2 style="color:#ffcf00">CRIAÇÃO DE SITES E SISTEMAS WEB</h2>						
						<p>Somos uma agência especializada em Desenvolvimento de Sistemas Web, Criação de Sites, Portais, E-Commerce e soluções para web.</p>
						<br>
						<a href="https://sitedan.com.br" target="_blank" rel="external">
							<img src="<?php echo INCLUDE_PATH ?>images/sitedan.png" alt="Imagem capa sitedan criação de sites e sistemas web">
						</a>
					<br>	
					
					<p><?php echo substr(strip_tags("Somos uma agência especializada em Desenvolvimento de Sistemas Web, Criação de Sites, Portais, E-Commerce e soluções para web. Estamos comprometidos em transformar os desafios dos investidores em oportunidades, resolvendo-os da maneira mais eficiente e notável. Limpamos as bagunças, simplificando os processos para facilitar as coisas para nossos clientes. Nossos serviços de web design concentram-se na criação de sites bonitos e centrados no usuário que reforçam a nossa marca e aumentam seus resultados."),0,400).'...'; ?></p>
					<a class="box-single" href="https://sitedan.com.br" target="_blank" rel="external">Leia mais</a>
				</div><!--box-single-conteudo-->

				<?php
				for ($i = 2; $i < $totalNews - 5; $i++) {
					?>
					<div class="box-single-conteudo">
						<h2><?php echo $resultado->items[$i]->htmlTitle; ?></h2>						
							<br>						
							<img src="<?php echo $resultado->items[$i]->pagemap->cse_image[0]->src; ?>" alt="Imagem capa da notícia">

							<p><?php echo $resultado->items[$i]->htmlSnippet; ?></p>
						
						<a class="box-single" href="<?php echo $resultado->items[$i]->link; ?>" target="_blank">Leia mais</a>
					</div><!--box-single-conteudo-->	
			
				<?php } ?>

				<div class="box-single-conteudo">
					<h2 style="color:#2163B0">Uma das obrigações do MEI é fazer a Declaração Anual!</h2>						
						<p>Para isso, basta você declarar a sua renda anual, ou seja, tudo que ganhou no ano anterior com vendas e prestação de serviços.</p>
						<br>
						<a href="https://abrircnpjmei.com.br/declaracao" target="_blank" rel="external">
							<img src="<?php echo INCLUDE_PATH ?>images/cnpjmei.png" alt="Imagem empresa Abrir CPNJ Mei - Faça a declaração do MEI">
						</a>
					<br>	
					
					<p>O processo é OBRIGATÓRIO para todos os MEIs que abriram o CNPJ no ano anterior, independente do valor de faturamento. 
					Na hora de fazer a sua Declaração Anual, vale lembrar de algumas informações importantes!</p> 
					<p><?php echo substr(strip_tags("O prazo para envio da Declaração Anual se inicia em Janeiro e vai até Maio. Ou seja, você tem cinco meses para declarar a renda obtida no ano anterior; 
					O limite atual de faturamento para o MEI é de R$81 mil reais. O cálculo desse valor deve ser proporcional à quantidade de meses em que a sua empresa está aberta. Se você abriu seu CNPJ apenas no meio do ano, o seu limite de faturamento será menor; 
					A multa por atraso pode chegar a até R$50. Faça a sua Declaração o quanto antes para evitar maiores preocupações futuramente. 
					"),0,300).'...'; ?></p>
					<a class="box-single" href="https://abrircnpjmei.com.br/declaracao" target="_blank" rel="external">Leia mais</a>
				</div><!--box-single-conteudo-->

				<?php
				for ($i = 5; $i < $totalNews; $i++) {
					?>
					<div class="box-single-conteudo">
						<h2><?php echo $resultado->items[$i]->htmlTitle; ?></h2>						
							<br>						
							<img src="<?php echo $resultado->items[$i]->pagemap->cse_image[0]->src; ?>" alt="Imagem capa da notícia">

							<p><?php echo $resultado->items[$i]->htmlSnippet; ?></p>
						
						<a class="box-single" href="<?php echo $resultado->items[$i]->link; ?>" target="_blank">Leia mais</a>
					</div><!--box-single-conteudo-->	
			
				<?php } ?>

				<div class="box-single-conteudo">
					<h2 style="color:red">Ganhe dinheiro em casa fazendo bolos caseiros!</h2>						
						<p>Te aprensento aqui o mais novo curso de bolos caseiros DA MARRARA! Os bolos caseiros estão super em alta e há uma grande procura na internet.</p>
						<br>
						<a href="https://go.hotmart.com/Q25824879Q?src=noticias" target="_blank" rel="external">
							<img src="<?php echo INCLUDE_PATH ?>images/caseirinhos.jpeg" alt="Imagem da Marrara, curso de bolos caseiros">
						</a>
					<br>	
					
					<p><?php echo substr(strip_tags("Marrara Bortoloti, tem 32 anos, é mãe, esposa, confeiteira e produtora do Curso Bolos de Sucesso com mais de 20 mil alunas em todo o Brasil e no mundo!
					A Confeitaria é realmente surpreendente, sempre cheia de novidades e oportunidades… E se Você quer começar um negócio próprio ou simplesmente preparar bolos caseiros Incríveis, diferenciados e especiais, essa apostila é para você!
					Bolos em geral são realmente um sucesso de vendas durante o ano todo e estão presentes nas mais diversas ocasiões. Então imagina poder comprar um caseirinho incrível cheio de cobertura? Pronto! Aqui esta a sua chance de lucrar muito com a produção e venda dos queridinhos do momento, que são os bolos caseiros… e esse produto ainda é pouco divulgado no Brasil! Por isso não perca essa oportunidade incrível!"),0,400).'...'; ?></p>
					<a class="box-single" href="https://go.hotmart.com/Q25824879Q?src=noticias" target="_blank">Leia mais</a>
				</div><!--box-single-conteudo-->
			
			</div><!--conteudo-portal-->


			<div class="clear"></div>
	</div><!--center-->

</section><!--container-portal-->

<?php } ?>

