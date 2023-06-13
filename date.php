<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=livreor', 'root', 'admin');

if(isset($_SESSION['id'])){
    $requser = $bdd->prepare("SELECT * FROM utilisateurs WHERE id = ?");
    $requser->execute(array($_SESSION['id']));
    $user = $requser->fetch();
    echo $user['id'];
}
?>
<!-- <?php
    echo date("d/m/Y H:i:s", time()+3600);
?> -->