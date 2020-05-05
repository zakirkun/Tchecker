<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="app/tools/css/index.css">
    <script src="app/tools/js/jquery.js"></script>
    <title>Space Checkers</title>
    <script>
  
    </script>
    <style>
        header{
            padding:20px;
        }
    </style>
</head>
<body>
<header style="" class="container" style="background-color: white">
    <div><a class="alink" href="?pot=deslogar">deslogar</a>
    <a href="?pg=index"> index</a>
    </div>
</header>
<?php
    if(isset($_GET['erro'])){
        echo "
        <div id='erros'>
            erro: $_GET[erro]
        </div>
        ";
    }
?>
