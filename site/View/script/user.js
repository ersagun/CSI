/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 function verifySession() {
 $.ajax({
 type: "POST",
 url: "../Controller/Controller.php",
 data: "a=getProdSession",
 dataType: "json",
 error: function () {
 console.log("erreur !");
 },
 success: function (retour) {
 console.log(retour);
 if (retour == null) {
 console.log("no product inserted");
 } else {
 for (i = 1; i < retour.length; i++) {
 console.log("fallait kil ajoute");
 ajouterPanier(retour[i].id);
 }
 }
 }
 });
 }**/

/**
 * 
 * @returns {undefined}
 * This function called when hash begin signin
 */
function signIn() {
$('#center').html('<div class="container">\
<div class="row">\
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">\
        <form role="form" id="loginform" action="../Controller/Controller.php" method="POST" >\
            <h2>Sign In</h2>\
            <hr class="colorgraph">\
            <div class="row">\
                <div class="col-xs-12 col-sm-6 col-md-6">\
                    <div class="form-group">\
                                         <input type="hidden" id="a" name="a" value="signIn">\
                                         <input type="text" name="username" id="username" class="form-control input-lg" placeholder="User Name" tabindex="1">\
                    </div>\
                </div>\
            </div>\
            <div class="row">\
                <div class="col-xs-12 col-sm-6 col-md-6">\
                    <div class="form-group">\
                        <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="5">\
                    </div>\
                </div>\
            </div>\
            <hr class="colorgraph">\
            <div class="row">\
                <div class="col-xs-12 col-md-6"><input type="submit" id="submitt" value="Submit" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>\
            </div>\
        </form>\
    </div>\
</div>\
</div>');
        }


function showForm() {
$.get("controller/Controller.php", {a: "sign-up", }).done(function (data) {
$("#center").html(data);
});
        }

function showSignIn() {
$.get("controller/Controller.php", {a: "sign-in", }).done(function (data) {
$("#center").html(data);
});
        }


function subscribe(event) {
event.preventDefault();
        //on récupère les valeurs dans les champs
        var codename = $('#codename').val();
        var prenom = $('#prenom').val();
        var nom = $('#nom').val();
        var email = $('#email').val();
        var pass = $('#pass').val();
        var voie = $('#voie').val();
        var rue = $('#rue').val();
        var cp = $('#cp').val();
        var ville = $('#ville').val();
        //si le formulaire est correctement rempli on procède à l'inscription
        jQuery.ajax({
        url: 'controller/Controller.php',
                type: 'Post',
                data: {a: 'subscribe', codename: codename, prenom: prenom, nom: nom, email: email, pass: pass, voie: voie, rue: rue, cp: cp, ville: ville},
                error: function () {
                console.log("erreur !");
                },
                success: function (res) {
                    
                    if(res=="insere"){
                            $("#prodInserted").html('<div class="alert alert-success">\
                            <a href="#" class="close" data-dismiss="alert">&times;</a>\
                            <strong>Success!</strong> Vous etes bien inscrit. Connectez vous maintenant !\
                            </div>'); 
                            window.setTimeout(function(){location.reload();location.hash="#product/all";},1000);
                            
                        }else{
                            if(res=="client existe"){
                                $("#prodInserted").html(' <div class="alert alert-info">\
                                <a href="#" class="close" data-dismiss="alert">&times;</a>\
                                <strong>Note!</strong> Ce nom d\'utilisateur existe.\
                                </div>');
                            }
                            if(res=="pb email"){
                                $("#prodInserted").html(' <div class="alert alert-info">\
                                <a href="#" class="close" data-dismiss="alert">&times;</a>\
                                <strong>Note!</strong> Votre adresse email n\'est pas correct.\
                                </div>');
                            }
                            if(res =="mot de passe pb"){
                                $("#prodInserted").html(' <div class="alert alert-info">\
                                <a href="#" class="close" data-dismiss="alert">&times;</a>\
                                <strong>Note!</strong> Mot de passe doit etre superieur a 8.\
                                </div>');
                 
                            }
                        } 
                }

        });
        return false;
        }


function connectin(event) {
event.preventDefault();
        //on récupère les valeurs dans les champs
        var user = $('#user').val();
        var pass = $('#pass').val();
        //si le formulaire est correctement rempli on procède à l'inscription
        $.ajax({
        url: 'controller/Controller.php',
                type: 'Post',
                data: {a: 'connect', user: user, pass: pass},
                error: function () {
                console.log("erreur !");
                },
                success: function (res) {
                    
                    if(res=="ok"){
                        $("#ses").html('<input type="hidden" id="hdnSession" data-value="' + res + '"/>');
                        $("#prodInserted").html('<div class="alert alert-success">\
                        <a href="#" class="close" data-dismiss="alert">&times;</a>\
                        <strong>Success!</strong> N\'oubliez pas de venir chercher vos commandes.\
                        </div>'); 
                    window.setTimeout(function(){location.reload();location.hash="#product/all";},500);  
                        }else{
                            if(res=="existe pas"){
                                $("#prodInserted").html(' <div class="alert alert-info">\
                                <a href="#" class="close" data-dismiss="alert">&times;</a>\
                                <strong>Note!</strong> Ce nom d\'utilisateur n\' existe pas.\
                                </div>');
                        window.setTimeout(function(){location.reload();location.hash="#signin";},1000);  
                            }
                            if(res=="mot de passe"){
                                 $("#prodInserted").html(' <div class="alert alert-info">\
                                <a href="#" class="close" data-dismiss="alert">&times;</a>\
                                <strong>Note!</strong> Mot de passe n\' est pas correct.\
                                </div>');
                        window.setTimeout(function(){location.reload();location.hash="#signin";},1000);  
                            }
                        }
                        
               
                     }});
                return false;
                }

        function logout() {
        location.hash = '#product/all';
                //envoit de la requète au serveur
                jQuery.ajax({
                url: 'controller/Controller.php',
                        type: 'post',
                        data: {a: 'logout'},
                        success: function (data) {
                         window.setTimeout(function(){location.reload();location.hash="#product/all";},500);  
                                $("#lisignup").html('<a href="#signup">Sign Up</a>');
                                $("#lisignin").html('<a href="#signin">Sign In</a>');
                                $("#linom").empty();
                                $("#monPanier").empty();
                                $("#lideco").empty();
                                $("#ses").html("<input type=\"hidden\" id=\"hdnSession\" data-value=\"default\" />");
                                 $("#prodInserted").html('<div class="alert alert-success">\
                    <a href="#" class="close" data-dismiss="alert">&times;</a>\
                    <strong>Success!</strong> Vous etes deconnecté\
                    </div>');
                        }
                });
                }

        function verifyConnexion(){
        val = false;
                res = $("#hdnSession").data('value');
                if (res != ""){
        if (res != "default") {
        val = true;
        }
        }
        return val;
                }