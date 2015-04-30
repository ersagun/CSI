/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function passeCommande(){
    $.get("controller/Controller.php", {a: "etap1cmd", }).done(function (data) {
        $("#center").html(data);
    });
}
