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
    <!-- <video class="video-arriere-plan" autoplay muted loop>
            <source src="img/diablo.mp4" type="video/mp4">
    </video> -->
    <div class="formulaire">
        <div>
            <h2>Connexion</h2>
        </div>
        <div>
            <form action="" method="post">
                <table>
                    <tr>
                        <td>
                            <label for="login">Login : </label>
                        </td>
                        <td>
                            <input type="text" name="login_connect" id="login" placeholder="Login">
                        </td>
                    </tr>
                    <tr>
                    <tr>
                        <td>
                            <label for="password">Mot de passe : </label>
                        </td>
                        <td>
                            <input type="password" name="password_connect" id="password" placeholder="Mot de passe">
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <input type="submit" name="form_connexion" value="Valider">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="deja">
                <div>
                    <div>Pas encore de compte ?</div>
                </div>
                <div>
                    <a href="inscription.php">inscription</a>
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
</body>
</html>