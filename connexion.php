<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=livreor', 'root', 'admin');

if(isset($_POST['form_connexion'])){
    $login_connect = htmlspecialchars($_POST['login_connect']);
    $password_connect = sha1($_POST['password_connect']);
    if(!empty($login_connect) && !empty($password_connect)){
        $requser = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ? AND password = ?");
        $requser->execute(array($login_connect, $password_connect));
        $userexist = $requser->rowCount();
        if($userexist == 1){
            if($login_connect === 'admin' && $password_connect === sha1('admin')){
                header("Location: admin.php");
                exit();
            }else{
            $userinfos = $requser->fetch();
            $_SESSION['id'] = $userinfos['id'];
            $_SESSION['login'] = $userinfos['login'];
            header("Location:profil.php?id=".$_SESSION['id']);
            }
        }else{
            $message = "Mauvais Login ou Mot de passe";
        }
    }else{
        $message = "tous les champs doivent être remplis !";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="connexion.css">
    <title>Connexion</title>
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
            <div class="formulaire">
                <div>
                    <h2>Connexion</h2>
                </div>
                <div>
                    <form action="" method="post">
                        <div class="table">
                            <div class="label">
                                <label for="login">Login : </label>
                                <input type="text" name="login_connect" id="login" placeholder="Login">
                            </div>
                            <div class="label">
                                <label for="password">Mot de passe : </label>
                                <input type="password" name="password_connect" id="password" placeholder="Mot de passe">
                            </div>
                            <div class="valider">
                                <input type="submit" name="form_connexion" value="Valider">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="deja">
                        <div>
                            <div>Pas encore de compte ?</div>
                        </div>
                        <div>
                            <a href="inscription_bis.php">inscription</a>
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
    <footer></footer>
</body>
</html>