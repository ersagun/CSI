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
        success: function(retour){
            tabProduit=retour;
            //console.log(tabProduit);
            $("#center").empty();
            
            $("#center").append('<div class="row" style="text-align:center;"><div class="col-sm-6 col-md-4">');
  
            for(i=0;i<retour.length;i++){
      
                $("#center").append('<div id="music" class="thumbnail"><img class="imgBlock" data-src="holder.js/300x300" src="view/'+retour[i].img_url+'" alt="artist" style="height:150px;widht:150px;"><div class="caption">\
                        <p>'+retour[i].nom.substring(0,21)+'</p>\
                        <p style="width:300px;text-align:justify"></p>\
                        <p><span onclick="ajouterPanier(\''+i+'\')" class="btn btn-primary" role="button">(+) panier</span></p>\
                        </div>\
                        </div>');      
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
function ajouterPanier(val){ 
ajouterPanierVisuel(val);

$.ajax({ 
        type: "POST", 
        url: "../Controller/Controller.php", 
        data: "a=ajouterProduitSession&like="+tabProduit[val].id,
        dataType:"json",
        error: function() { 
            console.log("erreur adjonction produit au session"); 
        },
        success: function(retour){
    }}); 
}

function ajouterPanierVisuel(val){
    $("#panierElem").append('<a href="#" class="list-group-item active">'+tabProduit[val].nom+'</a>');
console.log(tabProduit[val]);
}



function searchBar(val){
    $.ajax({ 
        type: "GET", 
        url: "controller/Controller.php", 
        data: "a=search&like="+val+"",
        dataType:"json",
        error: function() { 
            console.log("erreur !"); 
        },
        success: function(retour){
            $("#center").empty();

            $("#center").append('<div class="row" style="text-align:justify;"><div class="col-sm-6 col-md-4">');
                
            for(i=0;i<retour.length;i++){
      
                $("#center").append('<div id="music" class="thumbnail"><img class="imgBlock" data-src="holder.js/300x300" src="view/'+retour[i].img_url+'" alt="artist" style="height:150px;widht:150px;"><div class="caption">\
                        <p>'+retour[i].nom.substring(0,21)+'</p>\
                        <p style="width:300px;text-align:justify"></p>\
                        <p><span onclick="ajouterPanier(\''+i+'\')" class="btn btn-primary" role="button">(+) panier</span></p>\
                        </div>\
                        </div>');      
            } 
            $("#center").append('</div>');
        }
    }); 
    }