<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Psr4AutoloaderClass.php';
use R301\Psr4AutoloaderClass;

$loader = new Psr4AutoloaderClass;
// register the autoloader
$loader->register();
// register the base directories for the namespace prefix
$loader->addNamespace('R301', '.');

if (preg_match('/\.(?:png|jpg|jpeg|gif|ico|css|js)\??.*$/', $_SERVER["REQUEST_URI"])) {
    return false; // serve the requested resource as-is.
} else {

session_start();
if ($_SERVER["REQUEST_URI"] !== "/login" && !isset($_SESSION ['username'])) {
    header('Location: /login');
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>R3.01</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="UTF-8"/>
        <link rel="stylesheet" href="/stylesheet.css"/>
        <link rel="icon" type="image/jpg" href="/favicon.jpg">
    </head>
    <body>
    <?php if ($_SERVER["REQUEST_URI"] !== '/login') : ?>
        <nav class="navbar">
            <a href="/tableauDeBord" class="dropbtn">Tableau de bord</a>
            <div class="dropdown">
                <button class="dropbtn">Joueurs</button>
                <div class="dropdown-content">
                    <a href="/joueur/ajouter">Ajouter un joueur</a>
                    <a href="/joueur">Liste de joueurs</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropbtn">Rencontres</button>
                <div class="dropdown-content">
                    <a href="/rencontre/ajouter">Ajouter une rencontre</a>
                    <a href="/rencontre">Liste des rencontres</a>
                </div>
            </div>
        </nav>
    <?php endif; ?>
    <?php
        require_once './Vue' . strtok($_SERVER["REQUEST_URI"],'?') . '.php';
    } ?>
    </body>
</html>