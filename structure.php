<?php

    
function debutHTML(){
    echo <<< debuthtml
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <title>Accueil</title>
                <meta http-equiv="Content-Type" content="text/html; charset=ISO 8859-1" />
                <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
                <link rel="stylesheet" type="text/css" href="style.css">
                <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />

                <script href="javascript.js"></script>
                <script href="bootstrap/js/bootstrap.min.js"></script>
                <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
            
            </head>
            <body>
debuthtml;
}
function finHTML(){
    echo <<< finhtml
        </body>
</html>
finhtml;
}

function connexion(){

    $p = new PDO("mysql:host=localhost; dbname=magasin; ;charset=ISO 8859-1", "root");
    return $p;
}
?>