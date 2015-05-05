/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function passerCommande(total){
    $.get("controller/Controller.php", {a: "etape1cmd"}).done(function (data) {
        if(total>0){
            var nowDate = new Date();
            var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
            location.hash="#passeCommande1";
            $("#center").html(data);
            $("#center").append("<input type=\"hidden\" id=\"totp\" data-value=\""+total+"\" />");
            $('#datetimepicker3').datetimepicker({
                startDate: today,
                dateFormat: "dd-mm-yy", 
                timeFormat: "HH:mm:ss"}); 
            $("#datetimepicker").datetimepicker("option", "minDate", 0);
            }else{
            $("#prodInserted").html(' <div class="alert alert-info">\
            <a href="#" class="close" data-dismiss="alert">&times;</a>\
            <strong>Rappel!</strong> Votre panier est vide, veuillez le remplir pour préparer une commande.\
            </div>');
        }  
    });
    }
    
    function etape2cmd(){
        res=$("#totp").data('value');
        val=$("#datetimepicker3").find("input").val();
        
             $.ajax({
        url: 'controller/Controller.php',
        type: 'Get',
        data: {a: 'etape2cmd', heure:val,total:res},
  
        error: function () {
            location.hash="#passeCommande2";
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
            debut += "		<a class=\"navbar-brand\" href=\"#product/all\">Retour<\/a>";
            debut += "      ";
            debut += "	  <\/div>";
            debut += "	  <div class=\"collapse navbar-collapse derma\">";
            debut += "		<ul class=\"nav navbar-nav\">";
            debut += "		  <li class=\"dropdown menu-large open\">";
            debut += "			<a href=\"#\" class=\"dropdown-toggle\" id=\"dLabel\" data-toggle=\"dropdown\" aria-expanded=\"true\"><span class=\"glyphicon glyphicon-shopping-cart\"><\/span> Panier <b class=\"caret\"><\/b><\/a>";
            debut += "			<ul class=\"dropdown-menu megamenu\">";
            debut += "			      <div class=\"col-sm-12 clearfix\">";
        
            var milieu="";
            if(r.length<=0){
                milieu+="<div class=\"simpleCart_items\">Vous n'avez pas commande !<\/div><br>";   
            }
            
            for (i = 0; i < r.length; i++) {
                etat="";
                if(r[i].recuperee ==true){
                    etat= "est récupéréé.";
                }else{
                    etat= "n\'est pas récupéréé";
                }
               milieu+="<div class=\"simpleCart_items\"><a href=\"#oldPanier\" onclick=\"showPanierId("+r[i].panier_id+");return false;\" class=\"simpleCart_empty btn btn-lg btn-danger\" style=\"font-size:12px;\">Cliquez ici<\/a>&nbsp;&nbsp;&nbsp;[ Le "+r[i].date.date+", vous avez passé une commande pour venir le chercher le "+r[i].heurerecuperation.deb.date+" . Vous avez jusqu`a "+r[i].heurerecuperation.fin.date+" pour venir le chercher. ETAT DE LA COMMANDE : "+etat+", PRIX TOTAL :"+r[i].tot+" ]<\/div><br>";   
            }
            var fin = "";  
            fin += "                      <ul id=\"cart\" class='clearfix'><\/ul><li class=\"divider\"><\/li>";
            fin += "                        	<div class=\"btn-group pull-right\">";
            fin += "				<a href=\"#panier\" class=\"simpleCart_checkout btn btn-lg btn-success\">Retourne<\/a>";
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
