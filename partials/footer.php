        <hr>
        <footer class="nav">
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
                <div class='clear'></div>
            </div><!--center-->
        </footer>
        <footer <?php if (isset($pagina404) && $pagina404 == true) {
            echo 'class="fixed"';
                }?>>
            <div class="center">
                <p>Todo os direitos reservados | Desenvolvido por <a href="https://sitedan.com.br" target="_blank">SiteDan</a></p>
            </div><!--center-->
        </footer >

        <a href="#" class="scrollToTop"><i style="color: #262726;" class="fa fa-2x fa-arrow-circle-up"></i></a>

        <script data-ad-client="ca-pub-4705170629656649" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
        crossorigin="anonymous"></script>
        <script src="<?= INCLUDE_PATH; ?>js/constants.js"></script>
        
        <script src="<?= INCLUDE_PATH; ?>js/scripts.js"></script>
    
        <script src="<?= INCLUDE_PATH; ?>js/slider.js"></script>
        <script src="<?= INCLUDE_PATH; ?>js/formularios.js"></script>
    </div><!--container-->
</body>

</html>