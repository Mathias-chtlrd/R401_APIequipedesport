<?php

use R301\Controleur\JoueurControleur;
use R301\Controleur\StatistiquesControleur;

$controleur = StatistiquesControleur::getInstance();
$statistiquesEquipe = $controleur->getStatistiquesEquipe();
$statistiquesJoueurs = $controleur->getStatistiquesJoueurs();

$controleur = JoueurControleur::getInstance();
$joueurs = $controleur->listerTousLesJoueurs();

?>

<div class="TripleGrid">
    <div>
        <h1><?php echo $statistiquesEquipe->nbVictoires(); ?></h1>
        <p> matchs gagnés</p>
    </div>
    <div>
        <h1><?php echo $statistiquesEquipe->nbNuls(); ?></h1>
        <p> matchs nuls</p>
    </div>
    <div>
        <h1><?php echo $statistiquesEquipe->nbDefaites(); ?></h1>
        <p> matchs perdus</p>
    </div>
    <div>
        <h1><?php echo $statistiquesEquipe->pourcentageDeVictoires(); ?>%</h1>
        <p> de matchs gagnés</p>
    </div>
    <div>
        <h1><?php echo $statistiquesEquipe->pourcentageDeNuls(); ?>%</h1>
        <p> de matchs nuls</p>
    </div>
    <div>
        <h1><?php echo $statistiquesEquipe->pourcentageDeDefaites(); ?>%</h1>
        <p> de matchs perdus</p>
    </div>
</div>
<div class="overflow">
    <table >
        <tr>
            <th style="width:15%;">Joueur</th>
            <th style="width:7%;">Statut</th>
            <th style="width:7%;">Poste le plus performant</th>
            <th style="width:7%;">Nombre de matchs consécutifs</th>
            <th style="width:7%;">Nombre titularisations</th>
            <th style="width:7%;">Nombre remplaçants</th>
            <th style="width:7%;">Moyenne évaluations</th>
            <th style="width:7%;">Pourcentage gagnés</th>
        </tr>
        <?php foreach ($joueurs as $joueur): ?>
        <tr>
            <td><?php echo $joueur->toString(); ?></td>
            <td><?php echo $joueur->getStatut()->name; ?></td>
            <td><?php echo $statistiquesJoueurs->posteLePlusPerformant($joueur)?->name; ?></td>
            <td><?php echo $statistiquesJoueurs->nbRencontresConsecutivesADate($joueur); ?></td>
            <td><?php echo $statistiquesJoueurs->nbTitularisations($joueur); ?></td>
            <td><?php echo $statistiquesJoueurs->nbRemplacant($joueur); ?></td>
            <td><?php echo $statistiquesJoueurs->moyenneDesEvaluations($joueur); ?></td>
            <td><?php echo $statistiquesJoueurs->pourcentageDeMatchsGagnes($joueur); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
