<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../model/Historique.php';
 require_once '../lib/tfpdf/tfpdf.php' ;
/**
 * Description of ControllerStats
 *
 * @author Ersagun
 */
class ControllerStats {

    //put your code here

    public static function showStats() {
        $t = Historique::findAll();
        $val="";
        if (isset($t[0])) {
            //pour chaque chanson renvoyée on créé un affichage
            $val = "<style type=\"text/css\">
.tg  {border-collapse:collapse;border-spacing:0; margin: 0 auto;margin-top:10%;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-s6z2{text-align:center}
</style>
<table class=\"tg\">
  <tr>
    <th class=\"tg-s6z2\">Debut</th>
    <th class=\"tg-031e\">Fin</th>
    <th class=\"tg-031e\">Nb Vente</th>
    <th class=\"tg-031e\">Chiffre d'affaire</th>
  </tr>";

            foreach ($t as $r) {
                                
                $val.='<tr>
                <td>'.$r->deb.'</td>
                <td>'.$r->fin.'</td>		
                <td>'.$r->nbvente.'</td>
                <td>'.$r->ca.'</td>
                </tr>';
            }
        }
        $val.="</table>"
                . "<form action=\"controller/Controller.php\" method=\"GET\">"
                . " <input type=\"hidden\" name=\"a\" value=\"pdf\" />"
                . "<input type=\"submit\" class=\"simpleCart_checkout btn btn-lg btn-success\" style=\"margin-left: 46.5%;margin-top:2%;\" value=\"Generer PDF\">";
        echo $val;
    }
    
    
    
    public static function pdf(){

        $t = Historique::findAll();
        $val="";
        if (isset($t[0])) {
            //pour chaque chanson renvoyée on créé un affichage
            $val = "                                                      Historique Drive :
                


                        ";

            foreach ($t as $r) {
                        $deb=substr($r->deb,0,4);   
                        $fin=substr($r->fin,0,4); 
                $val.='
                Date Debut :   '.$deb.'   Date Fin :   '.$fin.'  NB Vente :    '.$r->nbvente.' CA :    '.$r->ca.'
                    
                ';
            }
        }
        
        
        
        $pdf = new tFPDF();
$pdf->AddPage();

// Ajoute une police Unicode (utilise UTF-8)
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->SetFont('DejaVu','',14);

// Sélectionne une police standard (utilise windows-1252)
//$pdf->SetFont('Arial','',14);
$pdf->Ln(10);
$pdf->Write(5,$val);

$pdf->Output();
$host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = '../index.php#product/all';
        header("Location: http://$host$uri/$extra");
      

    }
}
