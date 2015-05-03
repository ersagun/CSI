/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function showStatistiques(){
    $.get("controller/Controller.php", {a: "stats", }).done(function (data) {
        $("#center").html(data);
    });
}

function genererPDF(){
    $.get("controller/Controller.php", {a: "pdf"}).done(function (data) {
        
    });
}
