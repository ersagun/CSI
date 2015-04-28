<?php

/**
 * Le controleur qui va choisir quelle action executer
 * En fonction de ce qui est envoyé dans le $_GET, on appelle la bonne fonction
 *
 * @author Ersagun
 */
include_once 'ControllerProduct.php';
include_once 'ControllerUser.php';

//demarage de la session utilisateur
session_start();

 $action=  array (
     'Products'=>'allProducts',
     'displayForm'=>'displayForm',
            'ajouterPanier' => 'ajouterPanier',
            'voirProduits' => 'voirProduits',
            'signIn' => 'signIn',
                'search'=>'search',
                'insertUser'=>'insertUser',
                'ajouterProduitSession'=>'ajouterProduitSession',
                'getProdSession'=>'getProdSession',
        );
 
        
        if(isset($_REQUEST["a"])) { // si $param contient

            if (array_key_exists($_REQUEST["a"], $action)){
                $a = $action[$_REQUEST["a"]];

                return ControllerProduct::$a($_REQUEST);

            }else{

                return "404 !";
            }
        }else{

           //return defautPage();
        }
   



/**

//si une action a été renseignée
if (count($_GET) > 0) {
    switch ($_GET['a']) {
        //si cette action est search
        case 'search':
            //on choisi l'action en fonction du type renseigné
            switch ($_GET['type']) {
                //recherche d'une chanson par son titre
                case 'trackTitle' :
                    ControllerTrack::searchByTitle($_GET['val']);
                    break;
                //recherche d'un artiste par son nom
                case 'artistName' :
                    ControllerArtist::searchByName($_GET['val']);
                    break;
                //recherche d'un artiste par son ID
                case 'artistID' :
                    ControllerArtist::searchById($_GET['val']);
                    break;
                //recherche des chansons d'un artiste
                case 'trackArtist' :
                    ControllerTrack::searchByArtist($_GET['val']);
                    break;
                //recherche les chanson d'une playlist pour l'affichage
                case 'playlistTracksDisplay':
                    ControllerPlaylistTracks::searchByPlaylistId($_GET['val'], 'display');
                    break;
                //recherche les chanson d'une playlist pour les traiter
                case 'playlistTracksJSON' :
                    ControllerPlaylistTracks::searchByPlaylistId($_GET['val'], 'json');
                    break;
                //recherche une chanson par son ID
                case 'trackID':
                    ControllerTrack::searchById($_GET['val']);
                    break;
                //recherche d'une playlist pour remplir la popup de confirmation de suppression
                case 'playlistForDelete':
                    ControllerPlaylist::searchById($_GET['val']);
                    break;
                //génère les boutons qui vont permettra l'ajout d'un titre à une playlist
                case 'playlistTrackModal':
                    ControllerPlaylistTracks::insertTrackInPlaylistDisplay($_GET['val']);
                    break;
            }
            break;
        //si l'action est rechercher tout
        case 'all':
            switch ($_GET['type']) {
                //on recherche tous les artistes
                case 'artist':
                    ControllerArtist::searchAll();
                    break;
                //on recherche toutes les chansons
                case 'track':
                    ControllerTrack::searchAll();
                    break;
                //recherche de toutes les playlists
                case 'playlist':
                    ControllerPlaylist::searchAll($_GET['purpose']);
                    break;
            }
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
        case 'subscribe':
            switch($_POST['type']){
                case 'display':
                    ControllerUser::displayFormSubscribe();
                    break;
                case 'insert':
                    ControllerUser::subscribe($_POST['username'], md5($_POST['password']), $_POST['email']);
                    break;
            }
            break;
    }
 **/


