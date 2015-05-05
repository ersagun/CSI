<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../model/Compte.php';
include_once '../model/Compose.php';
include_once '../model/Client.php';
/**
 * Description of ControllerPanier
 *
 * @author Ersagun
 */
class ControllerPanier {
    //put your code here
    
    public static function showPanier($u,$mdp){
        $id= Client::VerifierMdpId($u, $mdp);
        $table= Compose::findByPanierID($id);
        echo json_encode($table);
         
    }
    
    public static function showPanierId($id,$u,$mdp){
        if(Client::VerifierMdp($u, $mdp)){
            $table= Compose::findByPanierID($id);
             echo json_encode($table);   
        }     
    }
    
    public static function getReduct($u,$mdp){
        if(Client::VerifierMdp($u, $mdp)){
            $id= Client::VerifierMdpId($u, $mdp);
            $red=Reduction::findByClientId($id);
            echo json_encode($red);  
            
        }
    }
    
    
    public static function ajouterProduitPanier($id,$qte,$user,$mdp){
        $dernier_p=Client::VerifierMdpId($user,$mdp);
        //echo($dernier_p);
        $val=Compose::insertProd($dernier_p, $qte, $id);
        Compose::updateComp($qte,$id,$dernier_p);
        $prod=Produit::findByID($id);
        echo $id;
    }
    /**
        public static function ajouterProduitPanierPromo($id,$qte,$val,$user,$mdp){
        $dernier_p=Client::VerifierMdpId($user,$mdp);
        $val=Compose::insertProd($dernier_p, $qte, $id);
        Compose::updateComp($qte,$id,$dernier_p,$val);
        $prod=Produit::findByID($id);
        echo $id;
    } **/
    
    public static function supprimerIdPanier($a,$user,$mdp){
        $client=Client::VerifierMdpId($user,$mdp);
        Compose::supprimerContenuPanierId($client, $a);
        echo $a+" deleted";
    }
    
        public static function supprimerPanier($user,$mdp){
        $client=Client::VerifierMdpId($user,$mdp);
        Compose::supprimerContenuPanier($client);
        echo $a+" deleted";
    }
}
