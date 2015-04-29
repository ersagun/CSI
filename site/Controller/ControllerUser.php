<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../model/Client.php';
include_once '../model/Compte.php';
include_once '../model/Panier.php';
include_once '../model/Base.php';
/**
 * Description of ControllerUser
 *
 * @author Ersagun
 */
class ControllerUser {
        
        /**
     * Called when user want to sign in
     */
    
    public static function connect($a,$b){
        $bol=Client::VerifierMdp($a, $b);
        if($bol){
             $_SESSION['username'] = $a;
             $_SESSION['pass'] = $b;
             $navbar=file_get_contents('../view/html/navbar_connected.html');
            echo $navbar;
           
        }else{
            echo "<p>Vous n'etes pas inscrit ".$a." ou alors t'es bourré</p>";
        }
   
                
    }
    
    /**
     * This function check user and insert if not exist
     */
    public function insertUser(){
        
        /**
         $user = new Client();
        $user->username = $_POST['username'];
        $user->password = md5($_POST['password']);
        $user->email = $_POST['email'];
        $verif = User::compareUser($user);
        if($verif->username == ""){
            $res = $user->insert();
            $_SESSION['username'] = $user->username;
            echo $user->username;
        }
        else{
            echo "error";
        }**/
        header("location: ../View/#userInserted");
        echo "inserted";
    }
    
    public static function displayForm(){
        $form = file_get_contents('../view/html/formulaire.html');
        echo $form;
    }
    
       public static function displaySignIn(){
        $form = file_get_contents('../view/html/modal_connect.html');
        echo $form;
    }
    
    
    public static function subscribe($a,$b,$c,$d,$e,$f,$g,$h,$i){
        $bdd=Base::getConnection();
        $last_id_client=$bdd->LastInsertID('client');
        $panier=new Panier();
        $panier->setClient_id($last_id_client+1);
        $panier->setDebutRed("");
        $panier->setFinRed("");
        $panier->setReduction_id("");
        
        $compte=new Compte();
        $compte->setId($last_id_client+1);
        $compte->setMdp($h);
        
        $cli=new Client();
               $cli->setPrenom($a);
               $cli->setNom($b);
               $cli->setCodename($c);
               $cli->setRue($d);
               $cli->setVille($e);
               $cli->setCp($f);
               $cli->setNumvoie($g);
               $cli->setAdmin(false);
               $cli->setEmail($i);
               $compte->insert();
               $last_id_compte=$bdd->LastInsertID('compte');
               $cli->setCompte_id($last_id_compte);
               
               $panier->insert();
               $last_id_panier=$bdd->LastInsertID('panier');
               $cli->setDernierPanier($last_id_panier);
               $cli->insert();
               
               echo "inseré";
               }
               
                public static function logout(){
        session_unset();
        session_destroy();
        //remise à zero de la session (utilisateur pas défaut)
        session_start();
        $_SESSION['username'] = 'default';
        $_SESSION['password'] = 'default';
        $navbar=file_get_contents('../view/html/navbar.html');
        echo $navbar;
    }
    

}
