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
        $bol=Client::VerifierMdp($a,$b);
        $id=Client::VerifierMdpRetId($a,$b);
        if($bol){
            if($id>0){
             $_SESSION['username'] = $a;
             $_SESSION['pass'] = $b;
            return $a;
        }else{
            return "null";
        }  }
        else{
            return "null";
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
         $bdd = Base::getConnection();
        $cli=new Client();
        $cli->setPrenom($a);
        $cli->setNom($b);
        $cli->setCodename($c);
        $cli->setRue($d);
        $cli->setVille($e);
        $cli->setCp($f);
        $cli->setNumvoie($g);
        $cli->setAdmin(true);
        $cli->setEmail($i);
        $cli->insert();
        $last_client=$bdd->LastInsertID('client');
        
      
        $compte=new Compte();
        $compte->setMdp($h);
        $compte->insert();
        $last_compte=$bdd->LastInsertID('compte');
        
        $panier=new Panier();
        $panier->setClient_id($last_client);
        $panier->insert();
        $last_panier=$bdd->LastInsertID('panier');
        

        Compte::updateClientId($last_client,$last_compte);
        Client::updatePanierId($last_client, $last_panier);
        Client::updateCompteId($last_client,$last_compte);
        
    
        
        //cli : update client et compte 
         //compte : update clientid et compte        
         //panier : update clientid et compte        
               
               echo "inseré";
               }
               
               
               
                public static function logout(){
        session_unset();
        session_destroy();
        //remise à zero de la session (utilisateur pas défaut)
        session_start();
        $_SESSION['username'] = 'default';
        $_SESSION['pass'] = 'default';
        $navbar=file_get_contents('../view/html/navbar.html');
        echo "<input type=\"hidden\" id=\"hdnSession\" data-value=\"default\" />";
    }
    

}
