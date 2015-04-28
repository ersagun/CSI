/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function verifySession(){
   $.ajax({ 
        type: "POST", 
        url: "../Controller/Controller.php", 
        data: "a=getProdSession",
        dataType:"json",
        error: function() { 
            console.log("erreur !"); 
        },
        success: function(retour){
            console.log(retour);
            if(retour==null){
                console.log("no product inserted");
            }else{
            for(i=1;i<retour.length;i++){
                console.log("fallait kil ajoute");
                     ajouterPanier(retour[i].id); 
            }}
        }
    });  
}

/**
 * 
 * @returns {undefined}
 * This function called when hash begin signin
 */
function signIn(){     
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


function showForm(){
    $.get( "controller/Controller.php", { a: "sign-up",}).done(function( data ) {
        $( "#center" ).html( data );
});


}