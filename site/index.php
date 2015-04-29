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

session_start();

$head = file_get_contents('view/html/head.html');
$navbar = file_get_contents('view/html/navbar.html');
$panier = file_get_contents('view/html/panier.html');
$main_content = file_get_contents('view/html/main_content.html');
//$modal_connect = file_get_contents('view/html/modal_connect.html');
$footer = file_get_contents('view/html/footer.html');

if (isset($_SESSION['username'])) {

    if ($_SESSION['username'] != "default") {

        //on remplace le bouton de connexion par celui de déconnexion
        $navbar = '<div id"navvbar">
                <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

                        <div class="container">
                            
                        <div class="collapse navbar-collapse navbar-ex1-collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="#product/all">Nos produits</a></li>
                                <li><a href="">'.$_SESSION["username"].'</a></li>
                                <li><a href="#panier">Mon panier</a></li>
                                <li> <button id="connect" name="connect" class="btn btn-primary" onclick="logout(event)"> Se Deconnecter </button></li>
                                <li>
                                    <div id = "searchbar" style="margin-top:2px;">
                                        <form class="navbar-form navbar-right inline-form">
                                            <div class="form-group" >
                                                <input type="search" class="input-sm form-control" placeholder="Recherche" onkeyup="searchBar(this.value)">
                                            </div>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </div><!--/.navbar-collapse -->
                            
                    </div><!--/.container -->
                        
                </nav>
            </div>';
    }
}


 echo('<!DOCTYPE html>
    <html>'. $head .'<body><div id="all_content">
    <div id="slider"></div>'

 . $navbar.
  $main_content.'</div>'
 . $footer .
 '</body>
    </html>');