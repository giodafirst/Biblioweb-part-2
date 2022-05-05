<?php
require('config.php');

$message='';

if(!empty($_GET['ref'])){
    $ref = $_GET['ref'];
} else {
    header('Location : index.php',400);
    exit;
}

//Connexion au serveur
$mysqli = @mysqli_connect (HOSTNAME,USERNAME,PASSWORD);
//var_dump($mysqli);
//Connexion à la BD
if($mysqli){
    if(@mysqli_select_db($mysqli,DATABASE)){
            $query = "SELECT * FROM books INNER JOIN authors ON author_id=authors.id WHERE ref='$ref'";
            //var_dump($query);
        //Reqûete SQL
        $result = @mysqli_query ($mysqli,$query);
        //var_dump($result);
            if($result){
                //Extraction des données
                $book = mysqli_fetch_assoc($result);
                //var_dump($book);
                if(empty($book)){
                    header('Location : index.php',404);
                    exit;
                }
                //Libération de la mémoire du résultat
                mysqli_free_result($result); 
            } else {
                $message= "Erreur de reqûte !"; 
            }    
    } else {
        $message= "Base de données inconnue !";
    }
    //Fermeture de la connexion au serveur
    mysqli_close ($mysqli);
} else {
    $message = "Erreur de connexion !";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Modifier</title>
</head>
<body>
    <form action="<?= $_SERVER['PHP_SELF']?>" method="post" id="frm">
        <input type="hidden" name="ref" value="<?= $book['ref']?>">
        <div>
            <label for="title">Titre</label>
            <input type="text" name="title" id="title" value="<?= $book['title']?>">
        </div>
        <div>
            <label for="author">Auteur</label>
            <input type="text" name="author" id="author" value="<?= $book['firstname'], $book['lastname']?>">
        </div>
        <div>
            <label for="description">Description</label>
            <input type="text" name="description" id="description" value="<?= $book['description']?>">
        </div>
        <div>
            <label for="cover_url">Illustration</label>
            <input type="text" name="cover_url" id="cover_url" value="<?= $book['cover_url']?>">
        </div>
        <button>Modifier</button>
       
        
        
        
        



    </form>
</body>
</html>