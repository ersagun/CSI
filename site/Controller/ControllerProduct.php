<?php


require_once '../model/Produit.php';

 class ControllerProduct{
     
//require_once("../Models/User.php");
//echo file_get_contents("../View/View.html");

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author ersagun
 * 
 * This class used when user ask data
 */

    /**
     * Tranform all musics in json to Ajax
     */
    public static function allProducts(){
       $tab=Produit::allProducts();
        echo json_encode($tab);
    }
    
    

    
    /**
     * Called when user search a sound via artist name or song name
     */
    public function searchProduit(){
        $tab=Produit::findByID($_GET['like']);
        echo json_encode($tab);
    }
    

    
    public function ajouterProduitSession(){
        session_start();
        if (!isset($_SESSION["user"])){
           $_SESSION["user"]="unknown";
        }
        
        $produit=Produit::findById($_POST['like']);
        $_SESSION["sessionProduct"][$_POST['like']]=  serialize($produit);
        echo json_encode($produit);
    }
    
    public function getProdSession(){
        session_start();
        if(isset($_SESSION["user"])){
        $produit=Session::searchProducts($_SESSION["sessionProduct"]);
        }else{
            $_SESSION["user"]="unknown";
            //session_start();
            //$_SESSION["user"]="unknown";
            //$produit=Session::searchProducts($_SESSION["sessionProduct"]);
        }
        
        echo json_encode($produit);
    }
    
 }