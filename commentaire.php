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
    <link rel="stylesheet" href="commentaire.css">
    <title>Commentaire</title>
</head>
<body>
    <header>
        <div class="logo">
            <a href="index.php"><img src="img/logo.png" alt=""></a>
            <h1>Comics Store</h1>
        </div>
        <div class="user">
            <?php
                if(isset($_SESSION['id']) && $user['id'] == $_SESSION['id']){
            ?>
            <div class="buttons">
                <div class="button">
                    <a href="index.php">Acceuil</a>
                </div>
                <div class="button">
                    <a href="livre-or.php">Livre d'or</a>
                </div>
                <div class="button">
                    <a href="<?php ("Location:profil.php?id=".$_SESSION['id']);?>"><?php echo $user['login']?></a>
                </div>
                <div class="button">
                    <a class="deco" href="deconnexion.php">Déconnexion</a>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </header>
    <main>
        <div class="comment">
            <div class="bloc">
                <h1>Commentaires</h1>
                <form method="post">
                    <div class="form">
                        <textarea name="comment" id="comment" cols="30" rows="10" placeholder="Votre commentaire ..."></textarea>
                    </div>
                    <div class="form">
                        <input type="submit" name="form_comment" value="Valider">
                    </div>
                </form>
                <?php
                    if(isset($message)){
                        echo$message;
                    }
                    ?>
            </div>
        </div>
    </main>
    <footer></footer>
</body>
</html>
<?php
}
?>