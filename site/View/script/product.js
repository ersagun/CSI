/**
 * 
 * @returns {undefined}
 * Function show all products
 */

var tabProduit;
function showProducts(){
    $.ajax({ 
        type: "GET",
        url: "controller/Controller.php", 
        data: "a=products",
        dataType:"json",
        error: function() { 
            console.log("erreur !"); 
        },
        success: function(r){
            tabProduit=r;
            //console.log(tabProduit);
            $("#center").empty();
             $("#center").append('<legend style="color: graytext; font-size:20pt;\">Nos produits </legend>');

            $("#center").append(' <div class="row">');
                
            for(i=0;i<r.length;i++){
      
                var milieu = "";
                milieu += "<div class=\"col-md-3 simpleCart_shelfItem\" >   ";
                milieu += "<div class=\"panel panel-default\">";
                milieu += "     <div class=\"panel-heading item_name\">"+r[i].nom+"<\/div>";
                milieu += "  <div class=\"panel-body\">";
                milieu += " <img src=\"view/"+r[i].img_url+"\" class=\"img-thumbnail img-responsive item_thumb\" style=width:400px;height:300px; align:middle;><br> ";
                milieu += "     <p class='input-sm clearfix'>"+r[i].nom+"<\/p><span class='row'><\/span>";
                milieu += "  <\/div>";
                milieu += "  <div class=\"panel-footer\"> <p class=\"item_price\">"+r[i].prix+"<\/p><span class='btn btn-danger btn-md item_add' onclick=\"ajouterPanier("+i+")\">ADD<\/span> ";
                milieu += "      <label>Qty: <input id=\"qte-for"+i+"\" type=\"text\" value=\"1\"><\/label>";
                milieu += "     <\/div>";
                milieu += "<\/div>";
                milieu += "<\/div>";
                
                   $("#center").append(milieu);
            }
            
               $("#center").append('</div>');
        }
    }); 
}



/**
 * 
 * @param {type} val
 * @returns {undefined}
 * This function charge the sound in the audio balise and play it. Function is called
 * when user click on a listen button
 */


function searchBar(val){
    $.ajax({ 
        type: "GET", 
        url: "controller/Controller.php", 
        data: "a=search&like="+val+"",
        dataType:"json",
        error: function() { 
            console.log("erreur !"); 
        },
        success: function(r){
            $("#center").empty();

         $("#center").append(' <div class="row">');
                
            for(i=0;i<r.length;i++){
      
                var milieu = "";
                milieu += "<div class=\"col-md-3 simpleCart_shelfItem\" >   ";
                milieu += "<div class=\"panel panel-default\">";
                milieu += "     <div class=\"panel-heading item_name\">"+r[i].nom+"<\/div>";
                milieu += "  <div class=\"panel-body\">";
                milieu += " <img src=\"view/"+r[i].img_url+"\" class=\"img-thumbnail img-responsive item_thumb\" style=width:400px;height:300px; align:middle;><br> ";
                milieu += "     <p class='input-sm clearfix'>"+r[i].nom+"<\/p><span class='row'><\/span>";
                milieu += "  <\/div>";
                milieu += "  <div class=\"panel-footer\"> <p class=\"item_price\">"+r[i].prix+"<\/p><span class='btn btn-danger btn-md item_add' onclick=ajouterPanier("+i+")>ADD<\/span> ";
                milieu += "      <label>Qty: <input id=\"qte-for"+i+"\" type=\"text\" value=\"1\"><\/label>";
                milieu += "     <\/div>";
                milieu += "<\/div>";
                milieu += "<\/div>";
                
                   $("#center").append(milieu);
            }
            
               $("#center").append('</div>');
        }
    }); 
    }