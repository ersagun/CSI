/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* global val */

/* global val */

/**
 * 
 * @type type
 * 
 * @author ersagun
 * 
 * This class check the URL and manage generate the page 
 * thank's to the url hash
 */

// i allow my application to show only these hash names (hash name : function name)
var hash={'#signn':'signin','#!':'showProducts','#signup':'signup','#Products':'showProducts','#CheckUser':'checkUser',"#userInserted":"userInserted"};
/**
 *
 * @param {type} param
 * I check the page that user ask if is exist in my hash name table so i call the function
 * wich will show it else, i show the first page (#!)
 */
$(document).ready(function(){
    window.onload=function(){
       hashHistory();
        
   }
    window.onhashchange = function() {
       hashHistory(); 
    };
    

});
    
    


var hashHistory = function () {
    //on va séparer le hash en sous chaines
    var hash = location.hash.split("/");

    switch (hash[0]) {
        //si la première sous chaine est #artists
        case '#product':
            //on regarde la deuxième sous chaine et on appelle les fonctions adéquates
            switch (hash[1]) {
                case 'all':
                    showProducts();
                    break;
                case 'search':
                    searchForm('artistName', hash[2]);
                    break;
                default:
                    searchAllArtists();
                    break;
            }
            break;
            //si la première sous chaine est #tracks
        case '#tracks':
            //on regarde la seconde sous chaine et on appelle les fonctions adéquates
            switch (hash[1]) {
                case 'all':
                    searchAllTracks();
                    break;
                case 'search':
                    searchForm('trackTitle', hash[2]);
                    break;
                default:
                    searchAllTracks();
                    break;
            }
            break;
        case '#signup' :
            showForm();
            break;
        case '#signin' :
            break;
            //sinon on affiche la page d'accueil
        default:
            location.hash = '';
            var c = '<div class="jumbotron">'
                    + '<p>Bienvenue dans notre pojet développé dans cadre du cours de Programmation Web.</p>'
                    + '<p>Si vous souhaitez sauvegarder et accéder à vos playlists depuis n\'importe où, veuillez créer un compte</p>'
                    + '<p><button class="btn btn-success no-radius" onclick="displaySubscribeForm();">S\'inscrire</button></p>'
                    + '</div>';
            $("#center").html(c);
            break;
    }
};


/**
 * 
 * @returns {undefined}
 * Function show allArtist when hash is allArtist
 */

/**

function allArtist(){
    $.ajax({ 
        type: "POST", 
        url: "../Controller/Controller.php", 
        data: "a=allArtist",
        dataType:"json",
        error: function() { 
            console.log("erreur !"); 
        },
        success: function(retour){
            
            $("#center").empty();
            
            $("#center").append('<div class="row" style="text-align:center;"><div class="col-sm-6 col-md-4">');
            
            for(i=0;i<retour.length;i++){
                
                $("#center").append('<div id="artist" class="thumbnail"><img  data-src="holder.js/300x300" src="'+retour[i].image_url+'" alt="artist" style="height:150px;width:150px;"><div class="caption">\
                        <h3>'+retour[i].name+'</h3>\
                        <p style="width:220px;text-align:justify">'+retour[i].info.substring(0,75)+'</p>\
                        <p><button class="btn btn-primary" role="button" onclick="searchBar(\''+retour[i].name+'\')">See</button></p>\
                        </div>\
                        </div>');
                
            } 
            $("#center").append('</div>');
        }
    });
}
**/

/**
 * 
 * @returns {undefined}
 * Function return sign up  when hash is sign up
 */

