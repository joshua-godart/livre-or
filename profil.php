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
            <div class="logo">
                <a href="index.php"><img src="img/logo.png" alt=""></a>
                <h1>Comics Store</h1>
            </div>
            <div class="user">
                <?php
                if(isset($_SESSION['id']) && $userinfos['id'] == $_SESSION['id']){
                ?>
                <div class="buttons">
                    <div class="button">
                        <a class="edit" href="edit_profil.php">Editer mon profil</a>
                    </div>
                    <div class="button">
                        <a class="com" href="commentaire.php">Ajouter un commentaire</a>
                    </div>
                    <div class="button">
                        <a class="gold" href="livre-or.php">Livre d'or</a>
                    </div>
                    <div class="button">
                        <a class="deco" href="deconnexion.php">Déconnexion</a>
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
        <main>
            <section class="image">
                <img src="img/profile_image2.png" alt="">
            </section>
            <section class="content">
                <div>
                    <h2>Profil de <?php echo $userinfos['login']?></h2>
                </div>
            </section>
        </main>
        <footer></footer>
    </body>
    </html>
<?php
}
?>