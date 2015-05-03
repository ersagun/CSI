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
    
    
        public static function search($ab){
        $tab=  Produit::findProduitCategorieLike($ab); 
        echo json_encode($tab);
    }
    
 }