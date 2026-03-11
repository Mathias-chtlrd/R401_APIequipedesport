<?php

use R301\Controleur\CommentaireControleur;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['commentaireId'])) {
        $controleurCommentaire = CommentaireControleur::getInstance();
        if (!$controleurCommentaire->supprimerCommentaire($_POST['commentaireId'])) {
            error_log("Erreur lors de la suppression du commentaire");
        }
    }
}

if (isset($_POST['joueurId'])) {
    header('Location: /joueur/commentaire?id='.$_POST['joueurId']);
} else {
    header('Location: /joueur');
}