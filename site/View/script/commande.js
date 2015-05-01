/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function passerCommande(total){
    $.get("controller/Controller.php", {a: "etape1cmd"}).done(function (data) {
        $("#center").html(data);
        $("#center").append("<input type=\"hidden\" id=\"totp\" data-value=\""+total+"\" />");
        $('#datetimepicker3').datetimepicker({dateFormat: "dd-mm-yy", 
    timeFormat: "HH:mm:ss"}); 
    });
        //location.hash="#passerCommande";
    };
    
    function etape2cmd(){
        res=$("#totp").data('value');
        val=$("#datetimepicker3").find("input").val();
        //val=$("#dateCmd").val();
        $.ajax({
        url: 'controller/Controller.php',
        type: 'Get',
        data: {a: 'etape2cmd', heure:val,total:res},
  
        error: function () {
            console.log("erreur !");
        },
        success: function (res) {
           location.hash="#mesCommandes";
        }

    });
    }
    
    
function showCommandes(){
    $.ajax({
         url: "controller/Controller.php",
        type: "Post",
        data: {a: 'showcommandes'},
        dataType: "json",
        error: function () {
            console.log("erreur !");
        },
        success: function (r) {
            //console.log(tabProduit);
            $("#center").empty();
            var debut = "";
            debut += "<div class=\"container\">";
            debut += "    <nav class=\"navbar navbar-default \" role=\"navigation\">";
            debut += "	<div class=\"container\">";
            debut += "	  <div class=\"navbar-header\">";
            debut += "		<button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".derma\">";
            debut += "		  <span class=\"sr-only\">Toggle navigation<\/span>";
            debut += "		  <span class=\"icon-bar\"><\/span>";
            debut += "		  <span class=\"icon-bar\"><\/span>";
            debut += "		  <span class=\"icon-bar\"><\/span>";
            debut += "		<\/button>";
            debut += "		<a class=\"navbar-brand\" href=\"#\">Retour<\/a>";
            debut += "      ";
            debut += "	  <\/div>";
            debut += "	  <div class=\"collapse navbar-collapse derma\">";
            debut += "		<ul class=\"nav navbar-nav\">";
            debut += "		  <li class=\"dropdown menu-large\">";
            debut += "			<a href=\"#\" class=\"dropdown-toggle\" id=\"dLabel\" data-toggle=\"dropdown\"><span class=\"glyphicon glyphicon-shopping-cart\"><\/span> Panier <b class=\"caret\"><\/b><\/a>";
            debut += "			<ul class=\"dropdown-menu megamenu\">";
            debut += "			      <div class=\"col-sm-12 clearfix\">";
        
            var milieu="";
            for (i = 0; i < r.length; i++) {
                etat="";
                if(r[i].recuperee ==0){
                    etat= "n\'est pas récupéréé.";
                }else{
                    etat= "est récupéréé";
                }
               milieu+="<div class=\"simpleCart_items\"><a href=\"#oldPanier\" onclick=\"showPanierId("+r[i].panier_id+");return false;\" class=\"simpleCart_empty btn btn-lg btn-danger\" style=\"font-size:10px;height:10px\">Cliquez ici<\/a>&nbsp;&nbsp;&nbsp;Le "+r[i].Commande_date+", vous avez passé une commande pour venir le chercher le"+r[i].heurerecuperation.deb+". Vous avez jusqu`a "+r[i].heurerecuperation.fin+" pour venir le chercher. ETAT DE LA COMMANDE : "+etat+", PRIX TOTAL :"+r[i].tot+"]<\/div><br>";   
            }
            var fin = "";  
            fin += "                      <ul id=\"cart\" class='clearfix'><\/ul><li class=\"divider\"><\/li>";
            fin += "                        	<div class=\"btn-group pull-right\">";
            fin += "				<a href=\"#\" class=\"simpleCart_checkout btn btn-lg btn-success\">Retourne<\/a>";
            fin += "				<\/div>";
            fin += "                    <\/div>";
            fin += "			<\/ul>";
            fin += "		  <\/li>";
            fin += "		<\/ul>";
            fin += "		<\/div><!-- \/.navbar-collapse --> ";
            fin += "	<\/div>	";
            fin += "<\/nav>";
            fin += "<div class=\"row\">";
            fin += "<\/div>";
            fin += "      <ul id=\"shoppingbasket\"><\/ul> ";
            fin += "         <\/div>";

            final=debut+milieu+fin;
            $("#center").append(final);
        }
    });
}
