<h1>Ajouter une rencontre</h1>

<?php

use R301\Controleur\RencontreControleur;
use R301\Modele\Rencontre\RencontreLieu;
use R301\Vue\Component\Formulaire;

if ($_SERVER['REQUEST_METHOD'] === 'POST'
        && isset($_POST['dateHeure'])
        && isset($_POST['equipeAdverse'])
        && isset($_POST['adresse'])
        && isset($_POST['lieu'])
) {
    $controleur = RencontreControleur::getInstance();

    if (
        $controleur->ajouterRencontre(
            new DateTime($_POST['dateHeure']),
            $_POST['equipeAdverse'],
            $_POST['adresse'],
            RencontreLieu::fromName($_POST['lieu'])
        )
    ) {
        header('Location: /rencontre');
    }else{
        error_log("Erreur lors de la création de la rencontre");
    }
} else {
    $formulaire = new Formulaire("/rencontre/ajouter");
    $formulaire->setDateTime("Date", "dateHeure", date("Y-m-d H:i"));
    $formulaire->setText("Equipe adverse", "equipeAdverse");
    $formulaire->setText("Adresse", "adresse");
    $formulaire->setSelect("Lieu", array_map(function(RencontreLieu $lieu) { return $lieu->name; }, RencontreLieu::cases()), "lieu");
    $formulaire->addButton("Submit", "create", "Valider", "Modifier");
    echo $formulaire;
}