
<?php

use R301\Controleur\RencontreControleur;
use R301\Vue\Component\SelectResultat;

$controleur = RencontreControleur::getInstance();
if ($_SERVER['REQUEST_METHOD'] === 'POST'
        && isset($_POST['action'])
        && isset($_POST['rencontreId'])
) {
    switch($_POST['action']) {
        case "ouvrirFeuilleDeMatch":
            header('Location: /feuilleDeMatch/feuilleDeMatch?id='.$_POST['rencontreId']);
            die();
        case "ouvrirEvaluations":
            header('Location: /feuilleDeMatch/evaluation?id='.$_POST['rencontreId']);
            die();
        case "modifier":
            header('Location: /rencontre/modifier?id='.$_POST['rencontreId']);
            die();
        case "enregistrerResultat":
            if (isset($_POST['resultat'])) {
                if (!$controleur->enregistrerResultat($_POST['rencontreId'], $_POST['resultat'])) {
                    error_log("Erreur lors de la mise à jour du resultat");
                }
                header('Location: /rencontre');
                die();
            }
        case "supprimer":
            if (!$controleur->supprimerRencontre($_POST['rencontreId'])) {
                error_log("Erreur lors de la suppression de la rencontre");
            }
            header('Location: /rencontre');
            die();
    }
} else {

$rencontres = $controleur->listerToutesLesRencontres();


?>
<h1>Rencontres</h1>
<div class="overflow container">
    <table>
        <tr>
            <th style="width:10%">Date</th>
            <th style="width:10%">Equipe Adverse</th>
            <th style="width:20%">Adresse</th>
            <th style="width:8%">Lieu</th>
            <th style="width:8%">Résultat</th>
            <th style="width:20%; min-width: 200px;">Actions</th>
        </tr>
        <?php foreach ($rencontres as $rencontre):

            $selectResultat = new SelectResultat(
                    null,
                    $rencontre->getResultat()?->name
            );
        ?>
        <form action="rencontre" method="post">
            <tr>
                <input type="hidden" name="rencontreId" value="<?php echo $rencontre->getRencontreId(); ?>" />
                <td><?php echo $rencontre->getDateEtHeure()->format('d/m/Y H:i') ?></td>
                <td><?php echo $rencontre->getEquipeAdverse() ?></td>
                <td><?php echo $rencontre->getAdresse() ?></td>
                <td><?php echo $rencontre->getLieu()->name ?></td>
                <?php if ($rencontre->estPassee() && $rencontre->getResultat() ===null): ?>
                    <td><?php $selectResultat->toHTML(); ?></td>
                <?php else: ?>
                    <td><?php echo $rencontre->getResultat()?->name ?></td>
                <?php endif; ?>
                <td class="actions">
                    <?php if (!$rencontre->estPassee()): ?>
                    <button name="action" value="ouvrirFeuilleDeMatch" class="info">Feuilles de match</button>
                    <button name="action" value="modifier" class="update">Modifier</button>
                    <button name="action" value="supprimer" class="delete">Supprimer</button>
                    <?php else: ?>
                    <button name="action" value="ouvrirEvaluations" class="info">Évaluations</button>
                    <?php if ($rencontre->estPassee() && $rencontre->getResultat() ===null): ?>
                    <button class="create" name="action" value="enregistrerResultat">Enregistrer résultat</button>
                    <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
        </form>
        <?php endforeach; ?>
    </table>
</div>
<?php } ?>