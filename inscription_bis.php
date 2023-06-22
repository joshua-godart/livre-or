<?php
$bdd = new PDO('mysql:host=localhost;dbname=livreor', 'root', 'admin');

if(isset($_POST['form_inscription'])){
    if(!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['password_conf'])){
        $login = htmlspecialchars($_POST['login']);
        $password = sha1($_POST['password']);
        $password_conf = sha1($_POST['password_conf']);
        $loginlenght = strlen($login);
        if($loginlenght <= 255){
            $reqlogin = $bdd -> prepare("SELECT * FROM utilisateurs WHERE login = ?");
            $reqlogin -> execute(array($login));
            $loginexist = $reqlogin->rowCount();
            if($loginexist == 0){
                if($password == $password_conf){
                    $insertuser = $bdd->prepare("INSERT INTO utilisateurs(login, password) VALUES(?,?)" );
                    $insertuser->execute(array($login, $password));
                    header("Location:connexion.php");
                    $message = "Votre compte a bien été créé ! <a href=\"connexion.php\">Me connecter</a>";
                }else{
                    $message = "Les mots de passe ne correspondent pas !";
                }
            }else{
                $message = "Le login est déjà pris";
            }
        }else{
            $message = "Le login ne paut pas contenire plus de 255 caractères !";
        }
    }else{
        $message = "Tous les champs doivent être remplis !";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="inscription.css">
    <title>Inscription</title>
</head>
<body>
    <header>
        <div class="logo">
            <a href="index.php"><img src="img/logo.png" alt=""></a>
            <h1>Comics Store</h1>
        </div>
        <div class="buttons">
            <div class="button">
                <a href="index.php">Acceuil</a>
            </div>
            <div class="button">
                <a href="livre-or.php">Livre d'or</a>
            </div>
            <div class="button">
                <a href="inscription_bis.php">Inscription</a>
            </div>
            <div class="button">
                <a class="connect" href="connexion.php">Connexion</a>
            </div>
        </div>
    </header>
    <main>
        <section class="image">
            <img src="img/spider-man-2099.png" alt="" width="400px">
        </section>
        <section class="form">
            <div class="formulaire" id="content">
                <div>
                    <h2>Inscription</h2>
                </div>
                <div>
                    <form action="inscription.php" method="post">
                        <div class="table">
                            <div class="label">
                                <label for="login">Login : </label>
                                <input type="text" name="login" id="login" placeholder="Login">
                            </div>
                            <div class="label">
                                <label for="password">Mot de passe : </label>
                                <input type="password" name="password" id="password" placeholder="Mot de passe">
                            </div>
                            <div class="label">
                                <label for="password_conf">Confirmer mot de passe : </label>
                                <input type="password" name="password_conf" id="password_conf" placeholder="Confirmer mot de passe">
                            </div>
                            <div class="valider">
                                <input type="submit" name="form_inscription" value="Valider">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="deja">
                    <div>
                        <div>Déjà inscrit ?</div>
                    </div>
                    <div>
                        <a href="connexion.php">connexion</a>
                    </div>
                </div>
                <?php
                if(isset($message)){
                    echo$message;
                }
                ?>
                <!-- <div>
                    <a href="connexion.php">connexion</a>
                </div> -->
            </div>
        </section>
    </main>
</body>
</html>