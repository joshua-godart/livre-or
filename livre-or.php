<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <title>Commentaires</title>
</head>
<body>
    <header>
        <h2>Commentaires</h2>
        <div class="button">
            <a href="deconnexion.php">Déconnexion</a>
        </div>
    </header>
    <main>
        <div class="bloc_tab">
            <div class="tableau">
                <?php
                $serveur = 'localhost';
                $nomUtilisateur = 'root';
                $motDePasse = 'admin';
                $nomBaseDeDonnees = 'livreor';


                try {
                    // Connexion à la base de données avec PDO
                    $bdd = new PDO("mysql:host=$serveur;dbname=$nomBaseDeDonnees;charset=utf8", $nomUtilisateur, $motDePasse);

                    // Requête SQL pour récupérer les informations de la table étudiants
                    $requete = "SELECT commentaires.commentaire, utilisateurs.login, commentaires.date FROM utilisateurs JOIN commentaires ON commentaires.id_utilisateur = utilisateurs.id";
                    $resultat = $bdd->query($requete);
                // Affichage du résultat dans un tableau HTML
                    echo "<table>";
                    echo "<table border='1'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Commentaire</th>";
                    echo "<th>Login</th>";
                    echo "<th>Date</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . $ligne['commentaire'] . "</td>";
                        echo "<td>" . $ligne['login'] . "</td>";
                        echo "<td>" . $ligne['date'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";

                    // Fermeture de la connexion à la base de données
                    $resultat->closeCursor();
                    $bdd = null;
                } catch (PDOException $e) {
                    // En cas d'erreur, afficher le message d'erreur
                    echo "Erreur : " . $e->getMessage();
                }
                ?>
            </div>
        </div>
    </main>
</body>
</html>
