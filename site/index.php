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
$ss="  <input type=\"hidden\" id=\"hdnSession\" data-value=\"default\" />";
$head = file_get_contents('view/html/head.html');
$navbar = file_get_contents('view/html/navbar.html');
$panier = file_get_contents('view/html/panier.html');
$main_content = file_get_contents('view/html/main_content.html');
//$modal_connect = file_get_contents('view/html/modal_connect.html');
$footer = file_get_contents('view/html/footer.html');
$userRappel='';

if (isset($_SESSION['username'] )) {
    
     if ($_SESSION['username'] != "default" && $_SESSION['username'] == "ersagun") {
        $ss="  <input type=\"hidden\" id=\"hdnSession\" data-value=\"".$_SESSION["username"]."\" />";
        $navbar='<div id="navvbar-on">
                <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                        <img id = "lg" class = "img-responsive" src = "view/images/logo/basket.png" alt="logo">
                        <div class="container">
                            
                        <div class="collapse navbar-collapse navbar-ex1-collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li id="linom"><p> Bonjour '.$_SESSION['username'].'</p></li>
                                <li><a href="#product/all">Nos produits</a></li>
                                <li id="monPanier"><a href="#panier">Mon panier</a></li>
                               
                                <li id="lisignup"></li>
                                <li id="lisignin"></li>
                                <li>
                                    <div id = "searchbar" style="margin-top:2px;">
                                        <form class="navbar-form navbar-right inline-form">
                                            <div class="form-group" >
                                                <input type="search" class="input-sm form-control" placeholder="Recherche" onkeyup="searchBar(this.value)">
                                            </div>
                                        </form>
                                    </div>
                                </li>
                                 <li id="lideco"><button id="connect" name="connect" class="btn btn-primary" onclick="logout(event)"> Se Deconnecter </button></li>
                            </ul>
                        </div><!--/.navbar-collapse -->
                            
                    </div><!--/.container -->
                        
                </nav>
            </div>';
    }

    if ($_SESSION['username'] == "ersagun") {
        $ss="  <input type=\"hidden\" id=\"hdnSession\" data-value=\"".$_SESSION["username"]."\" />";
        $navbar='<div id="navvbar-on">
                <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                        <img id = "lg" class = "img-responsive" src = "view/images/logo/basket.png" alt="logo">
                        <div class="container">
                            
                        <div class="collapse navbar-collapse navbar-ex1-collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li id="linom"><p> Bonjour '.$_SESSION['username'].'</p></li>
                                <li><a href="#generation">Generations</a></li>
                                <li id="monPanier"><a href="#statistiques">Statistiques</a></li>
                               
                                <li id="lisignup"></li>
                                <li id="lisignin"></li>
                                <li>
                                    <div id = "searchbar" style="margin-top:2px;">
                                        <form class="navbar-form navbar-right inline-form">
                                            <div class="form-group" >
                                                <input type="search" class="input-sm form-control" placeholder="Recherche" onkeyup="searchBar(this.value)">
                                            </div>
                                        </form>
                                    </div>
                                </li>
                                 <li id="lideco"><button id="connect" name="connect" class="btn btn-primary" onclick="logout(event)"> Se Deconnecter </button></li>
                            </ul>
                        </div><!--/.navbar-collapse -->
                            
                    </div><!--/.container -->
                        
                </nav>
            </div>';
    }
}


 echo('<!DOCTYPE html>
    <html>'. $head .'<body><div id="all_content">'.$ss.
    '<div id="slider"></div>
        <div ="navb">'
         .$navbar.''
        .'</div>'.$userRappel.$main_content.''
    . '</div>'
 . $footer .
 '</body>
     <div id="ses">
    </html></div>');