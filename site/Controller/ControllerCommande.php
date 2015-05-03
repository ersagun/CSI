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
       $dernier_panier= Client::VerifierMdpId($a, $b);
       
        $cli_id=Client::VerifierMdpRetId($a, $b);
        $hrecp=new HeureRecuperation();
        $hrecp->setDeb($h);
        $hrecp->setFin($h);
        $id_hrep=$hrecp->insert();
        
        $commande=new Commande();
        $commande->setHeureRecuperation_id($id_hrep);
        $commande->setRecuperee(0);
        $commande->setTot($tot);
        $commande->setPanier_id($dernier_panier);
        $commande->setCliId($cli_id);
        $commande->insert();

        //$client=Client::findByID($cli_id);
        Panier::incrementePanier($cli_id);
        $bdd=Base::getConnection();
        $last_id_panier=$bdd->LastInsertID('panier');
        Client::updatePanierId($cli_id, $last_id_panier);
        //$client->setDernierPanier($last_id_panier);
        //$client->update();
}

public static function showCommandes($a,$b){
     $id= Client::VerifierMdpRetId($a, $b);
     $tab=Commande::findByCliID($id);
     echo json_encode($tab);
}

}
