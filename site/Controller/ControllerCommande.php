<?php
include_once "../model/Commande.php";
include_once "../model/Compose.php";
include_once "../model/HeureRecuperation.php";
include_once "../model/Client.php";

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllerCommande
 *s
 * @author Ersagun
 */
class ControllerCommande {
   
    
    public static function etape1cmd(){
        $navbar=file_get_contents('../view/html/etape1cmd.html');
        echo $navbar;
}

    public static function etape2cmd($h,$tot,$a,$b){
       $id= Client::VerifierMdpId($a, $b);
        $commande=new Commande();
        $cli_id=Client::VerifierMdpRetId($a, $b);
        $hrecp=new HeureRecuperation();
        $hrecp->setDeb($h);
        $hrecp->setFin($h);
        $id_hrep=$hrecp->insert();
        
        
        $commande->setHeureRecuperation_id($id_hrep);
        $commande->setRecuperee(0);
        $commande->setTot($tot);
        $commande->setPanier_id($id);
        $commande->setCliId($cli_id);
        $v=$commande->insert();
        $cli_id=Client::VerifierMdpRetId($codename, $mdp);
        $client=Client::findByID($cli_id);
        $panier=new Panier();
        $panier->setClient_id($last_id_client+1);
        $panier->setDebutRed("");
        $panier->setFinRed("");
        $panier->setReduction_id("");
        $panier->insert();
        $last_id_panier=$bdd->LastInsertID('panier');
        $client->setDernierPanier($last_id_panier);
}

public static function showCommandes($a,$b){
     $id= Client::VerifierMdpId($a, $b);
     $tab=Commande::findByCliID($id);
     echo json_encode($tab);
}

}
