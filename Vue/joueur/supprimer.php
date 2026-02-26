<?php

use R301\Controleur\JoueurControleur;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $controleur = JoueurControleur::getInstance();

        if (!$controleur->supprimerJoueur($_POST['id'])) {
            error_log("Erreur lors de la suppression du joueur");
        }
    }
}

header('Location: /joueur');