<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllerPanier
 *
 * @author Ersagun
 */
class ControllerPanier {
    //put your code here
    
    public static function showPanier(){
         $form = file_get_contents('../view/html/panier.html');
        echo $form;
    }
}
