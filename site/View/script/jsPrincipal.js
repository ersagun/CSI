/*
 To change this license header, choose License Headers in Project Properties.
 To change this template file, choose Tools | Templates
 and open the template in the editor.
 */
/* 
 Created on : 07-Dec-2014, 16:21:17
 Author     : ersagun
 */

/*Start*/
$(document).ready(function () {
//coller les deux js
    /**
     $.getScript("../js/hash.js", function(){
     
     // Use anything defined in the loaded script...
     });**/

    // Lorsque je soumets le formulaire
    $('#inscription').on('submit', function (e) {
        e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire

        var $this = $(this); // L'objet jQuery du formulaire

        var username = $('#username').val();
        var email = $('#email').val();
        var password = $('#password').val();


        // Je vérifie une première fois pour ne pas lancer la requête HTTP
        // si je sais que mon PHP renverra une erreur
        if (username === '' || password === '' || email === '') {
            alert('Les champs doivent êtres remplis');
        } else {
            // Envoi de la requête HTTP en mode asynchrone
            $.ajax({
                url: $this.attr('action'), // Le nom du fichier indiqué dans le formulaire
                type: $this.attr('method'), // La méthode indiquée dans le formulaire (get ou post)
                data: "a=search"+$this.serialize(),
                async: false,// Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
                success: function (html) { // Je récupère la réponse du fichier PHP
                    alert(html); // J'affiche cette réponse
                    /**
                     * 
                     * if(html=="error"){
                     $("#center").empty();
                     $("#center").append('<p>Ce nom d\'utilisateur ou cet adresse email a déjà été utilisé </p>');  
                     }else{
                     $("#center").empty();
                     $("#center").append('<p>Cher(e) '+html+', vous êtes bien inscrit ! </p>'); 
                     }
                     */
                }
            });
        }
    });


    // Form signUp
    $('#FormSU').click(function (e) {
        //e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
        //e.stopPropagation();
        var $this = $(this); // L'objet jQuery du formulaire

        // Je récupère les valeurs
        var a = $('#a').val();
        var username = $('#username').val();
        var email = $('#email').val();
        var password = $('#password').val();

        // Je vérifie une première fois pour ne pas lancer la requête HTTP
        // si je sais que mon PHP renverra une erreur
        if (username === '' || password === '' || email === '') {
            alert('Les champs doivent êtres remplis');
        } else {
            // Envoi de la requête HTTP en mode asynchrone
            $.ajax({
                url: $this.attr('action'), // Le nom du fichier indiqué dans le formulaire
                type: $this.attr('method'), // La méthode indiquée dans le formulaire (get ou post)
                data: $this.serialize(), // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
                dataType: 'text',
                error: function () {
                    $("#center").empty();
                    $("#center").append('<p>Une erreur est survenue ! Veuillez réessayer.</p>');
                },
                success: function (html) { // Je récupère la réponse du fichier PHP

                }
            });
        }
        return false;
    });


    // Form signIn
    $('#loginform').on('submit', function (e) {

        var $this = $(this);
        var a = $('#a').val();
        var username = $('#username').val();
        var password = $('#password').val();
        if (username === '' || password === '') {
            alert('Les champs doivent êtres remplis');
        } else {
            $.ajax({
                url: $this.attr('action'),
                type: $this.attr('method'),
                data: $this.serialize(),
                dataType: 'text',
                error: function () {
                    $("#center").empty();
                    $("#center").append('<p>Une erreur est survenue ! Veuillez réessayer.</p>');
                },
                success: function (html) {
                    if (html == "error_username") {
                        $("#center").empty();
                        $("#center").append('<p>Ce nom d\'utilisateur n\'existe pas !</p>');
                    } else {
                        if (html == "error_password") {
                            $("#center").empty();
                            $("#center").append('<p>Le mot de passe est incorrect !</p>');
                        }
                        else {
                            $("#center").empty();
                            $("#center").append('<p>Bienvenue ' + html + ', vous êtes maintenant connecté !</p>');
                        }
                    }
                }
            });
        }
    });

});

   