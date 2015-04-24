<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllerUser
 *
 * @author Ersagun
 */
class ControllerUser {
        
        /**
     * Called when user want to sign in
     */
    public function signIn(){    
         $user = new User();
        $user->username = $_POST['username'];
        $user->password = md5($_POST['password']);
        $verif = User::compareUser($user);
        if($verif->username == ""){
            echo "error_username";
        }
        else{
            if($user->password == $verif->password){
                echo $user->username;
                $_SESSION['username'] = $user->username;
            }
            else{
                echo "error_password";
            }
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
}
