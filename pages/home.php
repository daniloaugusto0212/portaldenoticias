<section class="main  text-center">
    <div class="header-conteudo-portal ">
        <?php
        if (isset($_POST['google'])) {
            echo '<h2><i class="fa fa-check" aria-hidden="true"></i> Visualizando Pesquisa do <strong>Google</strong></h2>';
        } elseif (!empty($url[0])) {
            echo '<h2><i class="fa fa-check" aria-hidden="true"></i> Visualizando notícias em <strong>' . strtoupper($url[0]) . '</strong></h2>';
        } else {
            echo '<h2><i class="fa fa-check" aria-hidden="true"></i> Visualizando notícias do <strong>Dia</strong></span></h2>';
        }
        ?>
    </div>
    <br>
    
    <?php
    $handle = curl_init();
    $today = date('d/m/Y');
    if (isset($_POST['google'])) {
        $search = urlencode($_POST['search']);
        $urlGoogle = GOOGLE_URL . $search;
    } elseif (!empty($url[0])) {
        $urlGoogle = GOOGLE_URL . $url[0];
    } else {
        $urlGoogle = GOOGLE_URL . $today;
    }
    // Set the url
    curl_setopt($handle, CURLOPT_URL, $urlGoogle);
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
        ?>
        <div class="row">
            <?php
            for ($i = 0; $i < $totalNews - 4; $i++) {
                ?>
                <div class="col-lg-4 col-md-6 mt-4">
                    <div class="box-single-conteudo border container h-100 pb-0">
                        <h2 class="h-15 header-title"><?= $resultado->items[$i]->htmlTitle; ?></h2>
                        <div class="link-divider" style="clear:both;"></div><br>
                        <img class="h-25" src="<?= $resultado->items[$i]->pagemap->cse_image[0]->src; ?>" alt="Imagem capa da notícia"><br>
                        <div class="link-divider" style="clear:both;"></div>
                        <p class="align-middle pt-3"><?= $resultado->items[$i]->htmlSnippet; ?></p>
                        <div class="link-divider" style="clear:both;"></div>
                        <div class="h-15 ">
                            <a class="box-single" href="<?= $resultado->items[$i]->link; ?>" target="_blank">Leia mais</a>
                        </div>
                    </div><!--box-single-conteudo-->
                </div>
            <?php } ?>
        </div>

        <div class="box-single-conteudo border mt-5 p-5">
            <h2 style="color:#ffcf00">CRIAÇÃO DE SITES E SISTEMAS WEB</h2>
            <p>Somos uma agência especializada em Desenvolvimento de Sistemas Web, Criação de Sites, Portais, E-Commerce e soluções para web.</p>
            <br>
            <a href="https://sitedan.com.br" target="_blank" rel="external">
                <img src="<?= INCLUDE_PATH ?>images/sitedan.png" alt="Imagem capa sitedan criação de sites e sistemas web">
            </a>
            <br>
            <p><?= substr(strip_tags("Somos uma agência especializada em Desenvolvimento de Sistemas Web, Criação de Sites, Portais, E-Commerce e soluções para web. Estamos comprometidos em transformar os desafios dos investidores em oportunidades, resolvendo-os da maneira mais eficiente e notável. Limpamos as bagunças, simplificando os processos para facilitar as coisas para nossos clientes. Nossos serviços de web design concentram-se na criação de sites bonitos e centrados no usuário que reforçam a nossa marca e aumentam seus resultados."), 0, 400) . '...'; ?></p>
            <a class="box-single" href="https://sitedan.com.br" target="_blank" rel="external">Leia mais</a>
        </div><!--box-single-conteudo-->

        <div class="row">
            <?php
            for ($i = 6; $i < $totalNews; $i++) {
                if (empty($resultado->items[$i]->pagemap->cse_image[0]->src)) {
                    $imgCapa = INCLUDE_PATH . '/images/no-image.png';
                } else {
                    $imgCapa = $resultado->items[$i]->pagemap->cse_image[0]->src;
                }
                ?>
                <div class="col-lg-3 col-md-6 mt-4">
                    <div class="box-single-conteudo border container h-100 pb-0">
                        <h2 class="h-15 header-title"><?= $resultado->items[$i]->htmlTitle; ?></h2>
                        <div class="link-divider" style="clear:both;"></div><br>
                        <img class="h-25" src="<?= $resultado->items[$i]->pagemap->cse_image[0]->src; ?>" alt="Imagem capa da notícia"><br>
                        <div class="link-divider" style="clear:both;"></div>
                        <p class=" h-35 align-middle pt-3"><?= $resultado->items[$i]->htmlSnippet; ?></p>
                        <div class="link-divider" style="clear:both;"></div>
                        <div class="h-15 "><a class="box-single" href="<?= $resultado->items[$i]->link; ?>" target="_blank">Leia mais</a></div>
                    </div><!--box-single-conteudo-->
                </div>
                <!-- /.col-md-4 -->
            <?php } ?>
        </div>
        <!-- /.row -->

        <div class="box-single-conteudo border mt-5 p-5">
            <h2 style="color:#2163B0">Uma das obrigações do MEI é fazer a Declaração Anual!</h2>
            <p>Para isso, basta você declarar a sua renda anual, ou seja, tudo que ganhou no ano anterior com vendas e prestação de serviços.</p>
            <br>
            <a href="https://abrircnpjmei.com.br/declaracao" target="_blank" rel="external">
                <img src="<?= INCLUDE_PATH ?>images/cnpjmei.png" alt="Imagem empresa Abrir CPNJ Mei - Faça a declaração do MEI">
            </a>
            <br>
            <p>O processo é OBRIGATÓRIO para todos os MEIs que abriram o CNPJ no ano anterior, independente do valor de faturamento. 
            Na hora de fazer a sua Declaração Anual, vale lembrar de algumas informações importantes!</p> 
            <p><?= substr(strip_tags("O prazo para envio da Declaração Anual se inicia em Janeiro e vai até Maio. Ou seja, você tem cinco meses para declarar a renda obtida no ano anterior; 
            O limite atual de faturamento para o MEI é de R$81 mil reais. O cálculo desse valor deve ser proporcional à quantidade de meses em que a sua empresa está aberta. Se você abriu seu CNPJ apenas no meio do ano, o seu limite de faturamento será menor; 
            A multa por atraso pode chegar a até R$50. Faça a sua Declaração o quanto antes para evitar maiores preocupações futuramente. 
            "), 0, 300) . '...'; ?></p>
            <a class="box-single" href="https://abrircnpjmei.com.br/declaracao" target="_blank" rel="external">Leia mais</a>
        </div><!--box-single-conteudo-->


    <?php } ?>
        <div class="header-conteudo-portal text-center mt-5">
            <?php
            if (isset($_POST['google'])) {
                echo '<h2><i class="fa fa-check" aria-hidden="true"></i> PRINCIPAIS NOTÍCIAS DO PORTAL</span></h2>';
            } elseif (!empty($url[0])) {
                echo '<h2><i class="fa fa-check" aria-hidden="true"></i> Visualizando notícias em <strong>' . strtoupper($url[0]) . '</strong></h2>';
            } else {
                echo '<h2><i class="fa fa-check" aria-hidden="true"></i> PRINCIPAIS NOTÍCIAS DO PORTAL</span></h2>';
            }
            ?>
        </div>
        <br>
        <div class="row">
            <?php
            $cont = 0;
            foreach ($getNews as $key => $value) {
                $getCategory = MySql::conectar()->prepare("SELECT * FROM `tb_site.categorias` WHERE id = ?");
                $getCategory->execute(array($value['categoria_id']));
                $getCategory = $getCategory->fetch()['slug'];
                $cont++;
                if ($cont == 9) {
                    ?>
                    <div class="col-md-12">
                        <div class="box-single-conteudo border mt-5 p-5">
                            <h2 style="color:red">Ganhe dinheiro em casa fazendo bolos caseiros!</h2>                       
                            <p>Te apresento aqui o mais novo curso de bolos caseiros DA MARRARA! Os bolos caseiros estão super em alta e há uma grande procura na internet.</p>
                            <br>
                            <a href="https://go.hotmart.com/R42589866K?src=noticias" target="_blank" rel="external">
                                <img src="<?= INCLUDE_PATH ?>images/caseirinhos.jpeg" alt="Imagem da Marrara, curso de bolos caseiros">
                            </a>
                            <br>    
                            
                            <p><?= substr(strip_tags("Marrara Bortoloti, tem 32 anos, é mãe, esposa, confeiteira e produtora do Curso Bolos de Sucesso com mais de 20 mil alunas em todo o Brasil e no mundo!
                            Esse Curso/Apostila foi criada para você empreender e aprender de maneira fácil, rápida e profissional a produzir e vender Bolos tipo Vulcão e Piscina! Nele você terá receitas de massas, recheios, calda para molhar o bolo, os processos de montagem e decoração, dicas de vendas e delivery, tudo passo a passo e muito mais. Temos o intuito de te guiar de forma realista para você realmente lucrar com este negócio de Bolos Vulcão e Piscina e mudar sua vida. Você ainda receberá BÔNUS de alto valor, sendo uma apostila com receitas de salgados, que vão deixar seus clientes surpresos com tanta variedade e também um guia com dicas valiosas para você realmente iniciar o seu próprio negócio e vender muito."), 0, 400) . '...'; ?></p>
                            <a class="box-single" href="https://go.hotmart.com/R42589866K?src=noticias" target="_blank">Leia mais</a>
                        </div><!--box-single-conteudo-->
                    </div>
                    <?php
                }
                if ($cont % 16 == 0) {
                    echo '<div id="more' . $cont . '"></div>';
                }
                ?>
                <div class="col-lg-3 col-md-6 mt-4">
                    <div class="box-single-conteudo border container h-100 pb-0">
                        <h2 class="h-15 header-title"><strong><?= substr(strip_tags($value['titulo']), 0, 45) . '...'  ?></strong></h2>
                        <div class="link-divider" style="clear:both;"></div><br>
                        <img class="h-25" src="<?= INCLUDE_PATH_PAINEL ?>/uploads/<?= $value['capa'] ?>" alt="Imagem capa da notícia"><br>
                        <div class="link-divider" style="clear:both;"></div>
                        <p class=" h-35 align-middle pt-5"><?= substr(strip_tags($value['conteudo']), 0, 130) . '...' ?></p>
                        <div class="link-divider" style="clear:both;"></div>
                        <div class="h-15 "><a class="box-single" href="<?= INCLUDE_PATH ?><?= $getCategory ?>/<?= $value['slug'] ?>">Leia mais</a></div>
                    </div><!--box-single-conteudo-->
                </div>
            <?php } ?>
        </div>
    </section><!--container-portal-->
    <?php
    if ($totalNewsDb < $limit) {
            echo '<div class="alert alert-dark text-center" role="alert">
                    Não há mais notícias para exibir! Selecione outra categoria.
                </div>';
    } else {
        ?>
        <div class="pagination justify-content-center mb-5 mt-3" id="more">
            <form action="<?= INCLUDE_PATH . $url[0] ?>#more<?= $limit ?>" method="get">
                <input type="submit" class="btn btn-block btn-primary" name="moreNews" value="Mostrar mais resultados">
                <input type="hidden" name="quant" value="<?= $contPage ?>">
            </form>
        </div>
    <?php } ?>
   </div><!--container-principal--> 

