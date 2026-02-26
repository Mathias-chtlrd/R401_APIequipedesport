
<?php


use R301\Controleur\ParticipationControleur;
use R301\Modele\Participation\Poste;
use R301\Modele\Participation\TitulaireOuRemplacant;
use R301\Vue\Component\SelectPerformance;

$controleur = ParticipationControleur::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST'
        && isset($_POST['action'])
        && isset($_POST['participationId'])
        && isset($_POST['rencontreId'])
        && isset($_POST['performance'])
) :
    switch($_POST['action']) {
        case "update":
            if (!$controleur->mettreAJourLaPerformance($_POST['participationId'], $_POST['performance'])) {
                error_log("Erreur lors de la mise à jour de la performance");
            }
            break;
        case "delete":
            if (!$controleur->supprimerLaPerformance($_POST['participationId'])) {
                error_log("Erreur lors de la suppression de la performance");
            }
            break;
    }

    header('Location: /feuilleDeMatch/evaluation?id=' . $_POST['rencontreId']);
    die();
else :
    if (!isset($_GET['id'])) :
        header("Location: /rencontre"); die();
    else :
        $feuilleDeMatch = $controleur->getFeuilleDeMatch($_GET['id']);
?>
<div style="display: flex; flex-direction: row; justify-content: space-between; align-items: center; padding-right: 30px">
    <h1>Évaluations</h1>
    <?php if($feuilleDeMatch->estEvalue()) : ?>
        <div class="etat-feuille-de-match feuille-de-match-complete">
            TERMINÉES
        </div>
    <?php else: ?>
        <div class="etat-feuille-de-match feuille-de-match-incomplete">
            INCOMPLÈTES
        </div>
    <?php endif; ?>
</div>

<div class="container" style="display: flex; flex-direction: row; justify-content: space-between">
    <?php foreach (TitulaireOuRemplacant::cases() as $titulaireOuRemplacant) : ?>
        <table style="width: 49.5%">
            <caption>
                <?php echo $titulaireOuRemplacant->name.'S' ?>
            </caption>
            <tr>
                <th style="width:15%">Poste</th>
                <th style="width:25%">Joueur</th>
                <th style="width:15%">Performance</th>
                <th style="width:20%">Mettre à jour la performance</th>
                <th style="width:25%; min-width: 150px;"></th>
            </tr>

            <?php
            foreach (Poste::cases() as $poste):
                $participant = $feuilleDeMatch->getParticipantAuPoste($poste, $titulaireOuRemplacant);
                $selectedValue = null;

                if ($participant?->getPerformance() !== null) {
                    $selectedValue = $participant->getPerformance()->name;
                }

                $select = new SelectPerformance(
                        null,
                        $selectedValue
                );
                ?>
                <form action="/feuilleDeMatch/evaluation" method="post">
                    <tr>
                        <input type="hidden" name="rencontreId" value="<?php if($participant !== null) echo $participant->getRencontre()->getRencontreId(); ?>" />
                        <input type="hidden" name="participationId" value="<?php if($participant !== null) echo $participant->getParticipationId(); ?>" />
                        <td><?php echo $poste->name; ?></td>
                        <td><?php  if($participant !== null) echo $participant->getParticipant()->toString() ?></td>
                        <td><?php  if($participant?->getPerformance() !== null) echo $participant->getPerformance()->name ?></td>
                        <td><?php $select->toHTML(); ?></td>
                        <?php if($participant !== null) : ?>
                        <td class="actions">
                                <button class="update" type="submit" name="action" value="update">Mettre à jour</button>
                                <button class="delete" type="submit" name="action" value="delete" style="margin-left: 8px">Supprimer</button>
                        </td>
                        <?php else: ?>
                        <td></td>
                        <?php endif; ?>
                    </tr>
                </form>
            <?php endforeach; ?>
        </table>
    <?php endforeach; ?>
</div>
<?php endif; endif; ?>