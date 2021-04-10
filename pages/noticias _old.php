<?php 

if (!isset($url[2])) {
    $categoria = MySql::conectar()->prepare("SELECT * FROM `tb_site.categorias` WHERE slug = ?");
    $categoria->execute(array(@$url[1]));
    $categoria = $categoria->fetch();
    ?>

<section class="header-noticias">
    <div class="center">
		<h2><i class="far fa-newspaper" aria-hidden="true"></i></h2>
		<h2 style="font-size: 17px;">Acompanhe as últimas <b><h1>notícias</h1> do portal</b></h2>
	</div><!--center-->
</section>

<section class="container-portal">
	<div class="center">		
			<div class="sidebar">
				<div class="box-content-sidebar">
					<h3><i class="fa fa-search"></i> Realizar uma busca:</h3>
					<form method="post">
						<input type="text" name="parametro" placeholder="O que deseja procurar?" required>
						<input type="submit" name="buscar" value="Pesquisar!">
					</form>
				</div><!--box-content-sidebar-->	

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
						<input type="submit" name="acao" value="Cadastrar!">
					</form> <!--banner-principal-->
				</div><!--box-content-sidebar-->

				<div class="box-content-sidebar">
					<!-- Page Content -->
					<div class="container">
					<!-- Page Heading -->
					<h1 class="my-4">Ganhe dinheiro em casa fazendo Caseirinhos!</h1>
						<div class="row">
							<div class="col-lg-3 col-md-4 col-sm-6 mb-4">
								<div class="card h-100">
									<a href="https://go.hotmart.com/G26253346U?src=noticias" target="_blank"><img class="card-img-top" src="<?php echo INCLUDE_PATH ?>/images/caseirinhos.jpeg" alt="Bolos Caseirinhos da Marrara"></a>
									<a href="https://go.hotmart.com/G26253346U?src=noticias" target="_blank">
									<div class="card-body">
										<h4 class="card-title">Está afim de iniciar o negócio mais lucrativo da sua vida?</h4>
										<p class="card-text"> Com os Caseirinhos você vai conseguir, leia até o final que eu te mostro como.</p></h4>
										<input type="submit" name="buscar" value="Leia mais">
									</div></a>
								</div>
							</div>		
						</div>
						<!-- /.row -->
					</div>
					<!-- /.container -->
				</div><!--box-content-sidebar-->				
			</div><!--sidebar-->

			<div class="conteudo-portal">
					<div class="header-conteudo-portal">
						<?php
							$porPagina = 8;
							if(!isset($_POST['parametro'])){
								if (isset($_POST['google'])) {
									echo '<h2>Visualizando Pesquisa do Google</h2>';
								}elseif($categoria['nome'] == ''){
									echo '<h2>Visualizando todos os Posts</h2>';
								}else{
									echo '<h2>Visualizando Posts em <span>'.$categoria['nome'].'</span></h2>';
								}
							}else{
								echo '<h2><i class="fa fa-check"></i> Busca realizada com sucesso!</h2>';
							}

							$query = "SELECT * FROM `tb_site.noticias` ";
							if($categoria['nome'] != ''){
								$categoria['id'] = (int)$categoria['id'];
								$query.="WHERE categoria_id = $categoria[id]";
							}
							if(isset($_POST['parametro'])){
								if(strstr($query,'WHERE') !== false){
									$busca = $_POST['parametro'];
									$query.=" AND titulo LIKE '%$busca%'";
								}else{
									$busca = $_POST['parametro'];
									$query.=" WHERE titulo LIKE '%$busca%'";
								}
							}
							$query2 = "SELECT * FROM `tb_site.noticias` "; 
							if($categoria['nome'] != ''){
									$categoria['id'] = (int)$categoria['id'];
									$query2.="WHERE categoria_id = $categoria[id]";
							}
							if(isset($_POST['parametro'])){
								if(strstr($query2,'WHERE') !== false){
									$busca = $_POST['parametro'];
									$query2.=" AND titulo LIKE '%$busca%'";
								}else{
									$busca = $_POST['parametro'];
									$query2.=" WHERE titulo LIKE '%$busca%'";
								}
							}
							$totalPaginas = MySql::conectar()->prepare($query2);
							$totalPaginas->execute();
							$totalPaginas = ceil($totalPaginas->rowCount() / $porPagina);
							if(!isset($_POST['parametro'])){
								if(isset($_GET['pagina'])){
									$pagina = (int)$_GET['pagina'];
									if($pagina > $totalPaginas){
										$pagina = 1;
									}
									
									$queryPg = ($pagina - 1) * $porPagina;
									$query.=" ORDER BY order_id DESC LIMIT $queryPg,$porPagina";
								}else{
									$pagina = 1;
									$query.=" ORDER BY order_id DESC LIMIT 0,$porPagina";
								}
							}else{

								$query.=" ORDER BY order_id ASC";
							}
							$sql = MySql::conectar()->prepare($query);
							$sql->execute();
							$noticias = $sql->fetchAll();
						?>
						
						
					</div>
					<?php
					if (isset($_POST['google'])) {
						$q = urlencode($_POST['search']);
						$handle = curl_init();
					
						$url = 'https://www.googleapis.com/customsearch/v1?key=AIzaSyCqV9gGA5nMEyreJAjDSfr7P21qL2VRBEw&cx=3e2bee2173c7ed23a&q='.$q;
					
						// Set the url
						curl_setopt($handle, CURLOPT_URL, $url);
						// Set the result output to be a string.
						curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($handle, CURLOPT_SSL_VERIFYPEER , false);
						$output = curl_exec($handle);
						
						curl_close($handle);
					
						$resultado = json_decode($output);
						$totalNews = count($resultado->items);
						if ($totalNews == 0) {
							echo '<h2><i class="fa fa-check"></i>Sua busca não retornou resultados!</h2>';
						}else{
						for($i = 0; $i < $totalNews; $i++){
							?>
							<div class="box-single-conteudo">
								<h2><?php echo $resultado->items[$i]->htmlTitle; ?></h2>						
									<br>							
									<img src="<?php echo $resultado->items[$i]->pagemap->cse_image[0]->src; ?>" alt="capa">

									<p><?php echo $resultado->items[$i]->htmlSnippet; ?></p>
								
								<a href="<?php echo $resultado->items[$i]->link; ?>" target="_blank">Leia mais</a>
							</div><!--box-single-conteudo-->
						<?php }
						} 
					
					}else{
					
						foreach($noticias as $key=>$value){
						$sql = MySql::conectar()->prepare("SELECT `slug` FROM `tb_site.categorias` WHERE id = ?");
						$sql->execute(array($value['categoria_id']));
						$categoriaNome = $sql->fetch()['slug'];
					?>
					<div class="box-single-conteudo">
                        <h2><?php echo date('d/m/Y',strtotime($value['data'])) ?> - <?php echo $value['titulo']; ?></h2>						
							<p><?php echo $value['subtitulo']; ?></p>
							
							<img src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $value['capa']; ?>" alt="capa">
							
						
						<p><?php echo substr(strip_tags($value['conteudo']),0,400).'...'; ?></p>
						<a href="<?php echo INCLUDE_PATH; ?>noticias/<?php echo $categoriaNome; ?>/<?php echo $value['slug']; ?>">Leia mais</a>
					</div><!--box-single-conteudo-->
					<?php } 
					} ?>

					<div class="box-single-conteudo">
                        <h2>Ganhe dinheiro em casa fazendo Caseirinhos!</h2>						
							<p>Te aprensento aqui o mais novo curso de CASEIRINHOS DA MARRARA! Os caseirinhos estão super em alta e há uma grande procura na internet.</p>
							
							<img src="<?php echo INCLUDE_PATH ?>images/caseirinhos.jpeg" alt="capa">
							
						
						<p><?php echo substr(strip_tags("Marrara Bortoloti, tem 32 anos, é mãe, esposa, confeiteira e produtora do Curso Bolos de Sucesso com mais de 20 mil alunas em todo o Brasil e no mundo!
						A Confeitaria é realmente surpreendente, sempre cheia de novidades e oportunidades… E se Você quer começar um negócio próprio ou simplesmente preparar CASEIRINHOS Incríveis, diferenciados e especiais, essa apostila é para você!
						Bolos em geral são realmente um sucesso de vendas durante o ano todo e estão presentes nas mais diversas ocasiões. Então imagina poder comprar um caseirinho incrível cheio de cobertura? Pronto! Aqui esta a sua chance de lucrar muito com a produção e venda dos queridinhos do momento, que são os caseirinhos… e esse produto ainda é pouco divulgado no Brasil! Por isso não perca essa oportunidade incrível!"),0,400).'...'; ?></p>
						<a href="https://go.hotmart.com/G26253346U?src=noticias" target="_blank">Leia mais</a>
					</div><!--box-single-conteudo-->

					

					<div class="paginator">
						<?php
							if(!isset($_POST['parametro'])){
							for($i = 1; $i <= $totalPaginas; $i++){
								$catStr = ($categoria['nome'] != '') ? '/'.$categoria['slug'] : '';
								if($pagina == $i)
									echo '<a class="active-page" href="'.INCLUDE_PATH.'noticias'.$catStr.'?pagina='.$i.'">'.$i.'</a>';
								else
									echo '<a href="'.INCLUDE_PATH.'noticias'.$catStr.'?pagina='.$i.'">'.$i.'</a>';
							}
							}
						?>
						
					</div><!--paginator-->
			</div><!--conteudo-portal-->


			<div class="clear"></div>
	</div><!--center-->

</section><!--container-portal-->

<?php }else{ 
	include('noticia_single.php');
}
?>

