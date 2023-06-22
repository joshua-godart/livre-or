<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="livre-or.css">
    <title>Livre d'or</title>
</head>

<body>
    <header>
        <?php
        $bdd = new PDO('mysql:host=localhost;dbname=livreor', 'root', 'admin');

        if (isset($_SESSION['id'])) {
            $requser = $bdd->prepare("SELECT * FROM utilisateurs WHERE id = ?");
            $requser->execute(array($_SESSION['id']));
            $user = $requser->fetch();
            // echo $user['id'];
            // echo "<a href=\"commentaire.php\">Ajouter un commentaire</a><br>";
            // echo "<a href=\"deconnexion.php\">Déconnexion</a>";
        ?>
            <div class="logo">
                <a href="index.php"><img src="img/logo.png" alt=""></a>
                <h1>Comics Store</h1>
            </div>
            <div class="user">
                <?php
                if (isset($_SESSION['id']) && $user['id'] == $_SESSION['id']) {
                ?>
                    <div class="buttons">
                        <div class="button">
                            <a class="edit" href="index.php">Accueil</a>
                        </div>
                        <div class="button">
                            <a class="com" href="commentaire.php">Ajouter un commentaire</a>
                        </div>
                        <div class="button">
                            <a class="gold" href="livre-or.php">Livre d'or</a>
                        </div>
                        <div class="button">
                            <a class="gold" href="livre-or.php"><?php echo $user['login'] ?></a>
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
        <?php
        } else {
        ?>
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
        <?php
        }
        ?>
    </header>
    <main>
        <section class="livre_or">
            <!-- <h2>Commentaires</h2> -->
            <div class="tableau">
                <h1>Commentaires</h1>
                <!-- <div><a class="com" href="commentaire.php">Ajouter un commentaire</a></div> -->
                <?php

                try {
                    // Connexion à la base de données avec PDO
                    $bdd = new PDO("mysql:host=localhost;dbname=livreor", 'root', 'admin');

                    // Requête SQL pour récupérer les informations de la table étudiants
                    $requete = "SELECT commentaires.commentaire, utilisateurs.login, commentaires.date FROM utilisateurs JOIN commentaires ON commentaires.id_utilisateur = utilisateurs.id";
                    $resultat = $bdd->query($requete);

                    while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
                        echo "<div class='bloc_login'>";
                        echo "<div class='login'>" . "Ecrit par " . $ligne['login'] . "<br>" . "</div>";
                        echo "<div class='date'>" . " le " . $ligne['date'] . "<br>" . "</div>";
                        echo "</div>";
                        echo "<div class='comment'>" . $ligne['commentaire'] . "<br>" . "</div>";
                    }

                    // Fermeture de la connexion à la base de données
                    $resultat->closeCursor();
                    $bdd = null;
                } catch (PDOException $e) {
                    // En cas d'erreur, afficher le message d'erreur
                    echo "Erreur : " . $e->getMessage();
                }
                ?>
            </div>
        </section>
    </main>
</body>

</html>