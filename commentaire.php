<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=livreor', 'root', 'admin');

if(isset($_SESSION['id'])){
    $requser = $bdd->prepare("SELECT * FROM utilisateurs WHERE id = ?");
    $requser->execute(array($_SESSION['id']));
    $user = $requser->fetch();
    // echo $user['id'];

    if(isset($_POST['form_comment'])){
        if(isset($_POST['comment']) && !empty($_POST['comment'])){
            $comment=htmlspecialchars($_POST['comment']);
            $id_user= $user['id'];
            // $date= date("d/m/Y H:i:s", time());
            $insertcomment = $bdd->prepare("INSERT INTO commentaires(commentaire, id_utilisateur) VALUES (?, ?)");
            $insertcomment->execute(array($comment, $id_user));
            header("Location:livre-or.php");
            $message = "Votre commentaire a bien été enregistré !";
        }else{
            $message = "Aucun commentaire à enregistrer !";
        }
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commentaire</title>
</head>
<body>
    <header>
        <div>
            <a href="livre-or.php">Livre d'or</a>
        </div>
    </header>
    <div>
        <h1>Commentaires</h1>
        <form method="post">
            <textarea name="comment" id="comment" cols="30" rows="10" placeholder="Votre commentaire ..."></textarea>
            <input type="submit" name="form_comment" value="Valider">
        </form>
        <?php
            if(isset($message)){
                echo$message;
            }
            ?>
    </div>
</body>
</html>
<?php
}
?>