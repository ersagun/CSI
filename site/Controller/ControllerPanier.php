<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../model/Compte.php';
include_once '../model/Compose.php';
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
    
    public static function ajouterProduitPanier($id,$qte,$user,$mdp){
        $client=Client::VerifierMdpId($user,$mdp);
        $compose=new Compose();
        $compose->setPanier_id($client);
        $compose->setProduit_id($id);
        $compose->setQuantite($qte);
        $compose->insert();
        echo $client.$qte;
        
    }
}
