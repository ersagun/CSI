/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function showStats(){
    
}

function generateStats(){
    function showForm() {
    $.get("controller/Controller.php", {a: "stats", }).done(function (data) {
        $("#center").html(data);
    });
}
}