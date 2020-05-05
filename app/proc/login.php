<?php
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    if($nome == "vinicius" && $senha == "123"){
        $_SESSION['logado'] = true;
        header("Location: ?pg=index");
    }else
        header("Location: ?pg=index&msg=dados incorretos"); 