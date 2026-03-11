<?php

use R301\Controleur\CommentaireControleur;

if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['joueurId'])
    && isset($_POST['contenu'])
) {
    $controleur = CommentaireControleur::getInstance();
    if (!$controleur->ajouterCommentaire(
        $_POST['contenu'],
        $_POST['joueurId'])
    ) {
        error_log("Erreur lors de la création du commentaire");
    }
}

if (isset($_POST['joueurId'])) {
    header('Location: /joueur/commentaire?id='.$_POST['joueurId']);
} else {
    header('Location: /joueur');
}