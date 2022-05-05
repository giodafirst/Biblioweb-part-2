<?php
require('config.php');

$message='';
$books=[];
$keyword='';

if(!empty($_GET['keyword'])){
    $keyword = $_GET['keyword'];
}

//Connexion au serveur
$mysqli = @mysqli_connect (HOSTNAME,USERNAME,PASSWORD);
//var_dump($mysqli);
//Connexion à la BD
if($mysqli){
    if(@mysqli_select_db($mysqli,DATABASE)){
        if(empty($keyword)){
            $query = "SELECT * FROM books INNER JOIN authors ON author_id=authors.id";
        } else { 
            $query = "SELECT * FROM books INNER JOIN authors ON author_id=authors.id WHERE title LIKE '%$keyword%'";
        }
        //Reqûete SQL
        $result = @mysqli_query ($mysqli,$query);
            if($result){
                //Extraction des données
                while (($book = mysqli_fetch_assoc($result)) != null){
                    $books[] = $book;
                //var_dump($book);
                }
                //Libération de la mémoire du résultat
                mysqli_free_result($result);
            } else {
                $message = "Erreur de requête !";
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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Biblioweb</title>
</head>
<body>
    <h1>Biblioweb</h1>
        <div><?= $message ?></div>
            <div>
                <form action="<?= $_SERVER['PHP_SELF']?>" method="get" id="frm">
                <label for="keyword" id="label">Rechercher un livre</label>
                <input type="text" name="keyword" id="keyword">
                <button>Rechercher</button>
                </form>
            </div>
                <div class="liste"><?php foreach($books as $book) {?>
                        <p class="title"><?= $book['title']?></p>
                        <p class="description"><?= $book['description']?></p>
                        <p class="authors"><?= $book['firstname']?> <?=$book['lastname']?></p>

                        <a href="edit.php?ref=<?= $book['ref']?>">Modifier</a>
                    <?php }?>
                </div>
</body>
</html>