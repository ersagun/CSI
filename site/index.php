<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of index
 *
 * @author ersagun
 */

header('Content-Type: charset=utf-8'); 

//$session_start = session_start();
//$_SESSION["user"]="unknown";
//include 'lunch_autoload.php' ;
$head = file_get_contents('view/html/head.html');
$navbar = file_get_contents('view/html/navbar.html');
$panier = file_get_contents('view/html/panier.html');
$main_content = file_get_contents('view/html/main_content.html');
$footer = file_get_contents('view/html/footer.html');
 echo('<!DOCTYPE html>
    <html>'. $head .'<body><div id="all_content">
    <div id="slider"></div>'

 . $navbar
 . $main_content .$panier.' </div>'
 . $footer .
 '</body>
    </html>');