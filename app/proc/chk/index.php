<?php

    switch($_POST['option']){
        case 'cardNumber':
            include_once 'card.php';
            break;
        case 'loginPass':
            include_once 'login.php';
            break;
        default:
            header("Location: ?&erro=$_POST[option]");
            break;
    }