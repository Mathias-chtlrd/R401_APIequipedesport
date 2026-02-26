<h1>Modifier un joueur</h1>
<?php

use R301\Controleur\JoueurControleur;
use R301\Modele\Joueur\JoueurStatut;
use R301\Vue\Component\Formulaire;

$controleur = JoueurControleur::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_GET['id'])
    && isset($_POST['nom'])
    && isset($_POST['prenom'])
    && isset($_POST['dateDeNaissance'])
    && isset($_POST['tailleEnCm'])
    && isset($_POST['poidsEnKg'])
    && isset($_POST['statut'])
) {

    if (
        $controleur->modifierJoueur(
            $_GET['id'],
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['numeroDeLicence'],
            new DateTime($_POST['dateDeNaissance']),
            $_POST['tailleEnCm'],
            $_POST['poidsEnKg'],
            $_POST['statut']
        )
    ) {
        header('Location: /joueur');
    }else{
        error_log("Erreur lors de la modification du joueur");
    }
} else {
    if (!isset($_GET['id'])) {
        header("Location: /joueur");
    } else {
        $joueur = $controleur->getJoueurById($_GET['id']);

        $formulaire = new Formulaire("/joueur/modifier?id=".$joueur->getJoueurId());
        $formulaire->setText("Nom", "nom", "", $joueur->getNom());
        $formulaire->setText("Prenom", "prenom", "", $joueur->getPrenom());
        $formulaire->setText("Numéro de license", "numeroDeLicence", "00042", $joueur->getNumeroDeLicence());
        $formulaire->setDate("Date de naissance", "dateDeNaissance", $joueur->getDateDeNaissance()->format('Y-m-d'));
        $formulaire->setText("Taille (en cm)", "tailleEnCm", "", $joueur->getTailleEnCm());
        $formulaire->setText("Poids (en Kg)", "poidsEnKg", "", $joueur->getPoidsEnKg());
        $formulaire->setSelect("Statut", array_map(function($statut) { return $statut->name; }, JoueurStatut::cases()), "statut");
        $formulaire->addButton("Submit", "update", "modifier","Modifier");
        echo $formulaire;
    }
}