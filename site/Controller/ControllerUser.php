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
define('DISPLAY_XPM4_ERRORS', true); // display XPM4 errors
require_once '../lib/mailing/MAIL.php'; // path to 'MAIL.php' file from XPM4 package
/**
 * Description of ControllerUser
 *
 * @author Ersagun
 */

class ControllerUser {

    /**
     * Called when user want to sign in
     */
    public static function connect($a, $b) {
        $bol = Client::VerifierMdp($a, $b);
        $existe = Client::findByNomRetName($a);
        if ($bol==1) {
            if ($existe==1) {
                $_SESSION['username'] = $a;
                $_SESSION['pass'] = $b;

                echo "ok";
            } else {
                echo "existe pas";
            }
        } else {
            echo "mot de passe";
        }
    }

    /**
     * This function check user and insert if not exist
     */
    public function insertUser() {

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
          }* */
        header("location: ../View/#userInserted");
        echo "inserted";
    }

    public static function displayForm() {
        $form = file_get_contents('../view/html/formulaire.html');
        echo $form;
    }

    public static function displaySignIn() {
        $form = file_get_contents('../view/html/modal_connect.html');
        echo $form;
    }

    public static function subscribe($a, $b, $c, $d, $e, $f, $g, $h, $i) {
        $bdd = Base::getConnection();
        $existe = Client::findByNomRetName($c);

        if (!$existe) {
            if(strlen($h)>=7){
                if(filter_var($i, FILTER_VALIDATE_EMAIL)){
                    $cli = new Client();
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
                $last_client = $bdd->LastInsertID('client');


                $compte = new Compte();
                $hh=md5($h);
                $compte->setMdp($hh);
                $compte->insert();
                $last_compte = $bdd->LastInsertID('compte');

                $panier = new Panier();
                $panier->setClient_id($last_client);
                $panier->insert();
                $last_panier = $bdd->LastInsertID('panier');
                Compte::updateClientId($last_client, $last_compte);
                Client::updatePanierId($last_client, $last_panier);
                Client::updateCompteId($last_client, $last_compte);
                $cont = file_get_contents('../view/html/email.html');
                $m = new MAIL; // initialize MAIL class
                $m->From('isimsizcerrah@gmail.com'); // set from address
                $m->AddTo(trim($i)); // add to address
                $m->Subject('Bonjour nouvelle utilisateur de Drive'); // set subject
                $m->Text('Bienvenue'); // set text message
                $m->Html = array(
                'content' => $cont, // required
                'charset' => 'utf-8', // optional
                'encoding' => 'base64' // optional
                );
                $c = SMTP::connect('smtp.gmail.com', 465, 'isimsizcerrah@gmail.com', '12345ersagun', 'ssl', 10);
                $m->Send($c) ? 'Mail sent !' : 'Error !';
                echo "insere";
                }else{
                echo "pb email";  
                }
            }else{
                echo "mot de passe pb";
            
            }
            }else {
                echo "client existe";
            }   
    }

    public static function logout() {
        session_unset();
        session_destroy();
        //remise à zero de la session (utilisateur pas défaut)
        session_start();
        $_SESSION['username'] = 'default';
        $_SESSION['pass'] = 'default';
        $navbar = file_get_contents('../view/html/navbar.html');
        echo "<input type=\"hidden\" id=\"hdnSession\" data-value=\"default\" />";
    }

}
