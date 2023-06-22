<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=livreor', 'root', 'admin');

if(isset($_SESSION['id'])){
    $requser = $bdd->prepare("SELECT * FROM utilisateurs WHERE id = ?");
    $requser->execute(array($_SESSION['id']));
    $user = $requser->fetch();
    if(isset($_POST['new_login']) && !empty($_POST['new_login']) && $_POST['new_login'] != $user['login']){
        $new_login = htmlspecialchars($_POST['new_login']);
        $checkLogin = $bdd->prepare("SELECT id FROM utilisateurs WHERE login = ?");
        $checkLogin->execute(array($new_login));
        $loginExists = $checkLogin->fetch();
        if($loginExists){
            $message = "Le login est déjà utilisé !";
        }else{
            $insertlogin = $bdd->prepare("UPDATE utilisateurs SET login = ? WHERE id = ?");
            $insertlogin->execute(array($new_login, $_SESSION['id']));
            header('Location: profil.php?id='.$_SESSION['id']);
        }
    }
    if(isset($_POST['new_password']) && !empty($_POST['new_password']) && isset($_POST['new_password_conf']) && !empty($_POST['new_password_conf'])){
        $password1 = sha1($_POST['new_password']);
        $password2 = sha1($_POST['new_password_conf']);
        if($password1 == $password2){
            $insertpassword = $bdd->prepare("UPDATE utilisateurs SET password = ? WHERE id = ?");
            $insertpassword->execute(array($password1, $_SESSION['id']));
            header('Location: profil.php?id='.$_SESSION['id']);
        }else{
            $message = "Les mots de passes ne correspondent pas !";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edit_profil.css">
    <title>Editer profil</title>
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
        <section class="image">
                <img src="img/profile_image2.png" alt="">
        </section>
        <section class="form">
            <div class="formulaire">
                <div>
                    <h2>Edition du profil</h2>
                </div>
                <div>
                    <form action="" method="post">
                    <div class="table">
                        <div class="label">
                            <label for="new_login">Nouveau Login : </label>
                            <input type="text" name="new_login" id="new_login" placeholder="Nouveau login" value="<?php echo $user['login'];?>">
                        </div>
                        <div class="label">
                            <label for="new_password">Nouveau Mot de passe : </label>
                            <input type="password" name="new_password" id="new_password" placeholder="Nouveau Mot de passe">
                        </div>
                        <div class="label">
                            <label for="new_password_conf">Confirmer mot de passe : </label>
                            <input type="password" name="new_password_conf" id="new_password_conf" placeholder="Confirme mot de passe">
                        </div>
                        <div class="valider">
                            <input type="submit" name="form_inscription" value="Valider">
                        </div>
                    </div>
                </form>
            </div>
            <?php
            if(isset($message)){
                echo $message;
            }
            ?>
            </div>
        </section>
    </main>
</body>
</html>
<?php
}else{
    header("Location: connexion.php");
}
?>
