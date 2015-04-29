/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


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
}

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
            $('#subsribe-success').show(200);
            console.log(res);
            location.hash = '';
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

            //$('#connect-success-text').html('Connexion effectuée, Bienvenue <strong>'+user+'</strong>');
            //$('#connect-success').show(200);
            location.hash = '#panier';
            var navbar = "";
            navbar += "<div id\"navvbar\">";
            navbar += "                <nav class=\"navbar navbar-inverse navbar-fixed-top\" role=\"navigation\">";
            navbar += "                        <div class=\"container\">                         ";
            navbar += "                        <div class=\"collapse navbar-collapse navbar-ex1-collapse\">";
            navbar += "                            <ul class=\"nav navbar-nav navbar-right\">";
            navbar += "                                <li><a href=\"#product\/all\">Nos produits<\/a><\/li>";
            navbar += "                                <li><a href=\"\"> "+user+"<\/a><\/li>";
            navbar += "                                <li><a href=\"#panier\">Mon panier<\/a><\/li>";
            navbar += "                                <li> <button id=\"connect\" name=\"connect\" class=\"btn btn-primary\" onclick=\"logout(event)\"> Se Deconnecter <\/button><\/li>";
            navbar += "                                <li>";
            navbar += "                                    <div id = \"searchbar\" style=\"margin-top:2px;\">";
            navbar += "                                        <form class=\"navbar-form navbar-right inline-form\">";
            navbar += "                                            <div class=\"form-group\" >";
            navbar += "                                                <input type=\"search\" class=\"input-sm form-control\" placeholder=\"Recherche\" onkeyup=\"searchBar(this.value)\">";
            navbar += "                                            <\/div>";
            navbar += "                                        <\/form>";
            navbar += "                                    <\/div>";
            navbar += "                                <\/li>";
            navbar += "                            <\/ul>";
            navbar += "                        <\/div><!--\/.navbar-collapse -->                           ";
            navbar += "                    <\/div><!--\/.container -->                       ";
            navbar += "                <\/nav>";
            navbar += "            <\/div>";

            
            $("#navvbar").html(navbar);
           
        }

    });
    return false;
}

function logout() {

    //envoit de la requète au serveur
    jQuery.ajax({
        url: 'controller/Controller.php',
        type: 'post',
        data: {a: 'logout'},
        success: function (data) {

            // $('#connect-success').hide(200);
            //changement sur le bouton
            // $('#connect-btn').html(data);
            // $('#connect-btn').removeClass('btn-danger');
            // $('#connect-btn').addClass('btn-success');
            // $('#connect-btn').attr('data-target', '#modalConnect');
            //récupération des playlists
            // getPlaylists('display', 0);
            //getPlaylists('selection', 0);
            var navbar="";
navbar += "         <div id=\"navvbar\">";
navbar += "                <nav class=\"navbar navbar-inverse navbar-fixed-top\" role=\"navigation\">";
navbar += "";
navbar += "                        <div class=\"container\">";
navbar += "                            ";
navbar += "                        <div class=\"collapse navbar-collapse navbar-ex1-collapse\">";
navbar += "                            <ul class=\"nav navbar-nav navbar-right\">";
navbar += "                                <li><a href=\"#product\/all\">Nos produits<\/a><\/li>";
navbar += "                                <li><a href=\"#signup\">Sign Up<\/a><\/li>";
navbar += "                                <li><a href=\"#signin\">Sign in<\/a><\/li>";
navbar += "                                <li>";
navbar += "                                    <div id = \"searchbar\" style=\"margin-top:2px;\">";
navbar += "                                        <form class=\"navbar-form navbar-right inline-form\">";
navbar += "                                            <div class=\"form-group\" >";
navbar += "                                                <input type=\"search\" class=\"input-sm form-control\" placeholder=\"Recherche\" onkeyup=\"searchBar(this.value)\">";
navbar += "                                            <\/div>";
navbar += "                                        <\/form>";
navbar += "                                    <\/div>";
navbar += "                                <\/li>";
navbar += "                            <\/ul>";
navbar += "                        <\/div><!--\/.navbar-collapse -->";
navbar += "                            ";
navbar += "                    <\/div><!--\/.container -->";
navbar += "                        ";
navbar += "                <\/nav>";
navbar += "            <\/div>";

            $("#navvbar").html(navbar);
        }
    });
     location.hash = '#product/all';
}
