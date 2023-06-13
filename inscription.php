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
    <section class="container">
        <!-- <video class="video-arriere-plan" autoplay muted loop>
            <source src="img/diablo.mp4" type="video/mp4">
        </video> -->
        <div class="formulaire" id="content">
            <div>
                <h2>Inscription</h2>
            </div>
            <div>
                <form action="inscription.php" method="post">
                    <table>
                        <tr>
                            <td>
                                <label for="login">Login : </label>
                            </td>
                            <td>
                                <input type="text" name="login" id="login" placeholder="Login">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="password">Mot de passe : </label>
                            </td>
                            <td>
                                <input type="password" name="password" id="password" placeholder="Mot de passe">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="password_conf">Confirmer mot de passe : </label>
                            </td>
                            <td>
                                <input type="password" name="password_conf" id="password_conf" placeholder="Confirmer mot de passe">
                            </td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                            <td>
                                <input type="submit" name="form_inscription" value="Valider">
                            </td>
                        </tr>
                    </table>
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
</body>
</html>