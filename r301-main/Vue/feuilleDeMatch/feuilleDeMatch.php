<?php

use R301\Controleur\JoueurControleur;
use R301\Controleur\ParticipationControleur;
use R301\Modele\Participation\Poste;
use R301\Modele\Participation\TitulaireOuRemplacant;
use R301\Vue\Component\Select;

$controleur = ParticipationControleur::getInstance();
$joueurControleur = JoueurControleur::getInstance();

if (!isset($_GET['id'])) :
    header("Location: /rencontre");
else :
    $feuilleDeMatch = $controleur->getFeuilleDeMatch($_GET['id']);
    $joueursSelectionnables = $joueurControleur->listerLesJoueursSelectionnablesPourUnMatch($_GET['id']);
?>
<div style="display: flex; flex-direction: row; justify-content: space-between; align-items: center; padding-right: 30px">
    <h1>Feuille de Match</h1>
    <?php if($feuilleDeMatch->estComplete()) : ?>
    <div class="etat-feuille-de-match feuille-de-match-complete">
        COMPLÈTE
    </div>
    <?php else: ?>
    <div class="etat-feuille-de-match feuille-de-match-incomplete">
        INCOMPLÈTE
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
            <th style="width:30%">Joueur</th>
            <th style="width:35%">Sélectionner un joueur</th>
            <th style="width:20%; min-width: 150px;"></th>
        </tr>

        <?php
            foreach (Poste::cases() as $poste):
                $participant = $feuilleDeMatch->getParticipantAuPoste($poste, $titulaireOuRemplacant);
                $selectedValue = null;
                $selectableValues = [];

                foreach ($joueursSelectionnables as $joueursSelectionnable) {
                    $selectableValues[$joueursSelectionnable->getJoueurId()] = $joueursSelectionnable->toString();
                }

                if ($participant !== null) {
                    $selectableValues[$participant->getParticipant()->getJoueurId()] = $participant->getParticipant()->toString();
                    $selectedValue = $participant->getParticipant()->toString();
                }

                $select = new Select(
                        $selectableValues,
                        "joueurId",
                        null,
                        $selectedValue,
                );
        ?>
        <form action="/feuilleDeMatch/modifier" method="post">
            <tr>
                <input type="hidden" name="participationId" value="<?php if($participant !== null) echo $participant->getParticipationId(); ?>" />
                <input type="hidden" name="poste" value="<?php echo $poste->name ?>" />
                <input type="hidden" name="rencontreId" value="<?php echo $_GET['id'] ?>" />
                <input type="hidden" name="titulaireOuRemplacant" value="<?php echo $titulaireOuRemplacant->name ?>" />
                <td><?php echo $poste->name; ?></td>
                <td><?php  if($participant !== null) echo $participant->getParticipant()->toString() ?></td>
                <td><?php $select->toHTML(); ?></td>
                <td class="actions">
                    <?php if($participant !== null) : ?>
                    <button class="update" type="submit" name="action" value="update">Modifier</button>
                    <button class="delete" type="submit" name="action" value="delete" style="margin-left: 8px">Supprimer</button>
                    <?php else: ?>
                    <button class="create" type="submit" name="action" value="create">Assigner</button>
                    <?php endif; ?>
                </td>
            </tr>
        </form>
        <?php endforeach; ?>
    </table>
    <?php endforeach; ?>
</div>
<?php endif; ?>