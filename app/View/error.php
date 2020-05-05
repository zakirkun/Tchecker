<h1>Página de erro</h1>
    <a href="?pg=index">clique para voltar</a><br>
    <?php 
        if(isset($_GET['erro'])){
            $erro = $_GET['erro'];
            echo "<h1>ERRO $erro </h1>";
        }
    ?>
