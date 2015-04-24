<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Session
 *
 * @author Ersagun
 */
class Session {

    
    function __construct(){
        
    }
    
    public function __get($attr_name)
    {
        if (property_exists( __CLASS__, $attr_name))
        {
            return $this->$attr_name;
        }

        $emess = __CLASS__ . ": unknown member $attr_name (getAttr)";
        throw new Exception($emess, 45);
    }
    
    
   static function searchProducts($val){
       $i=1;
       $j=1;
       $tableProd=array();
       while(count($val)>=$i){
           if(isset($val[$i])){
                 $v=unserialize($val[$i]);
                  $tableProd[$j]=$v;
                  $j=$j+1;
           }
           $i=$i+1;
       }
       return $tableProd;
   }
}
