<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=livreor', 'root', 'admin');

if(isset($_GET['id']) && $_GET['id'] > 0){
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare("SELECT * FROM utilisateurs WHERE id = ?");
    $requser->execute(array($getid));
    $userinfos = $requser->fetch();

?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="profil.css">
        <title>Profil de <?php echo $userinfos['login']?></title>
    </head>
    <body>
        <header>
            <div class="user">
                <h2>Profil de <?php echo $userinfos['login']?></h2>
                <?php
                if(isset($_SESSION['id']) && $userinfos['id'] == $_SESSION['id']){
                ?>
                <div class="button">
                    <div>
                        <a class="edit" href="edit_profil.php">Editer mon profil</a>
                    </div>
                    <div>
                        <a class="deco" href="deconnexion.php">Déconnexion</a>
                    </div>
                    <div>
                        <a class="com" href="commentaire.php">Ajouter un commentaire</a>
                    </div>
                    <div>
                        <a class="com" href="livre-orbis.php">Livre d'or</a>
                    </div>
                </div>
                <?php
                }
                ?>
                <!-- <div>
                    <a href="connexion.php">connexion</a>
                </div> -->
            </div>
        </header>
        <main></main>
        <footer></footer>
    </body>
    </html>
<?php
}
?>