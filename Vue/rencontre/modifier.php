<h1>Modifier une rencontre</h1>

<?php

use R301\Controleur\RencontreControleur;
use R301\Modele\Rencontre\RencontreLieu;
use R301\Vue\Component\Formulaire;


$controleur = RencontreControleur::getInstance();
if ($_SERVER['REQUEST_METHOD'] === 'POST'
        && isset($_GET['id'])
        && isset($_POST['dateHeure'])
        && isset($_POST['equipeAdverse'])
        && isset($_POST['adresse'])
        && isset($_POST['lieu'])
) {
    if (
        $controleur->modifierRencontre(
            $_GET['id'],
            new DateTime($_POST['dateHeure']),
            $_POST['equipeAdverse'],
            $_POST['adresse'],
            RencontreLieu::fromName($_POST['lieu'])
        )
    ) {
        header('Location: /rencontre');
    }else{
        error_log("Erreur lors de la modification de la rencontre");
    }
} else {
    if (!isset($_GET['id'])) {
        header("Location: /rencontre");
    } else {
        $rencontre = $controleur->getRenconterById($_GET['id']);

        $formulaire = new Formulaire("/rencontre/modifier?id=" . $rencontre->getRencontreId());
        $formulaire->setDateTime("Date", "dateHeure", date("Y-m-d H:i"), $rencontre->getDateEtHeure()->format("Y-m-d H:i"));
        $formulaire->setText("Equipe adverse", "equipeAdverse", "", $rencontre->getEquipeAdverse());
        $formulaire->setText("Adresse", "adresse", "", $rencontre->getAdresse());
        $formulaire->setSelect("Lieu", array_map(function (RencontreLieu $lieu) {
            return $lieu->name;
        }, RencontreLieu::cases()), "lieu", $rencontre->getLieu()->name);
        $formulaire->addButton("Submit", "update", "Valider", "Modifier");
        echo $formulaire;
    }
}