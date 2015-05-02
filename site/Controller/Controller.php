<?php

/**
 * Le controleur qui va choisir quelle action executer
 * En fonction de ce qui est envoyé dans le $_GET, on appelle la bonne fonction
 *
 * @author Ersagun
 */
include_once 'ControllerProduct.php';
include_once 'ControllerUser.php';
include_once 'ControllerPanier.php';
include_once 'ControllerCommande.php';
include_once 'ControllerStats.php';
//demarage de la session utilisateur
session_start();

//si une action a été renseignée
if (count($_GET) > 0) {
    switch ($_GET['a']) {
        case 'supprimerIdPanier':
            ControllerPanier::supprimerIdPanier($_GET["like"],$_SESSION["username"], $_SESSION["pass"]);
            break;
        case 'cmdForm':
            ControllerCommande::cmdForm();
            break;
        case 'supprimerPanier':
            ControllerPanier::supprimerPanier($_SESSION["username"], $_SESSION["pass"]);
            break;
       case 'panier':
            ControllerPanier::showPanier();
            break;
        case 'etape1cmd': 
            ControllerCommande::etape1cmd();
            break;
           case 'etape2cmd': 
            ControllerCommande::etape2cmd($_GET["heure"],$_GET["total"],$_SESSION["username"], $_SESSION["pass"]);
            break;
        case 'ajouterPanier':
            ControllerPanier::ajouterProduitPanier($_GET["like"],$_GET["qte"],$_SESSION["username"], $_SESSION["pass"]);
            break;
        case 'products':
            ControllerProduct::allProducts();
            break;
        case 'search':
            ControllerProduct::search($_GET['like']);
            break;
        //si l'action est rechercher tout
        case 'sign-up':
           ControllerUser::displayForm();
            break;
        case 'sign-in':
           ControllerUser::displaySignIn();
            break;
         case 'stats':
           ControllerUser::displayStats();
            break;
        //si l'action est une creation
        case 'create':
            switch ($_GET['type']) {
                //creation d'une playlist
                case 'playlist':
                    ControllerPlaylist::newPlaylist($_GET['name']);
                    break;
                //insertion d'une chanson dans une playlist
                case 'playlistTrack':
                    ControllerPlaylistTracks::newPlatlistTrack($_GET['playlist_id'], $_GET['track_id']);
                    break;
            }
            break;
        //si l'action est une suppresion
        case 'delete':
            switch ($_GET['type']) {
                //suppression d'une playlist
                case 'playlist':
                    ControllerPlaylist::deletePlaylist($_GET['val']);
                    break;
                //suppression d'un titre d'une playlist
                case 'playlistTrack':
                    ControllerPlaylistTracks::deleteTrackFromPlaylist($_GET['playlist_id'], $_GET['track_id']);
                    break;
            }
            break;
    }
}


//pour les actions liées aux compter utilisateurs
if (count($_POST) > 0) {
    switch ($_POST['a']) {
        //connexion de l'utilisateur
        case 'connect':
            ControllerUser::connect($_POST['user'], md5($_POST['pass']));
            break;
        //déconnexion de l'utilisateur
        case 'logout':
            ControllerUser::logout();
            break;
        case 'showpanier':
            ControllerPanier::showPanier($_SESSION["username"],$_SESSION["pass"]);
            break;
        case 'showpanierid':
            ControllerPanier::showPanierId($_POST["id"],$_SESSION["username"],$_SESSION["pass"]);
            break;
        case 'showcommandes':
            ControllerCommande::showCommandes($_SESSION["username"],$_SESSION["pass"]);
            break;
        case 'subscribe':
            ControllerUser::subscribe($_POST['prenom'],$_POST['nom'],$_POST['codename'],$_POST['rue'], $_POST['ville'],$_POST['cp'],$_POST['voie'],md5($_POST['pass']), $_POST['email']);
            break;
            switch($_POST['type']){
                case 'display':
                    ControllerUser::displayFormSubscribe();
                    break;
                case 'insert':
                    ControllerUser::subscribe($_POST['prenom'],$_POST['nom'],$_POST['codename'],$_POST['rue'], $_POST['ville'],$_POST['cp'],$_POST['voie'],md5($_POST['pass']), $_POST['email']);
                    break;
            }
            break;
    }
 


}