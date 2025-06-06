<?php

use Controllers\HTMLGenerator;

$modifyPage = (isset($aPersonne) && array_count_values($aPersonne) > 0);
?>
<form action="/<?= ($update ? 'update/'. $aPersonne['id'] : 'create') ?>" method="post">
    <div class="container col-md-7 mx-auto mt-3">
        <h2 class="mb-5">
            <?= _(($update ? 'Mettre à jour' : 'Créer') . " une personne") ?>
            <i class="bi bi-person-fill-add"></i>
        </h2>

        <div class="col-12 row">
            <!-- Nom -->
            <div class="mb-3 col-4 text-end">
                <label for="nom" class="form-label fw-semibold"><?= _("Nom") ?> *</label>
            </div>
            <div class="mb-3 col-8">
                <input type="text" maxlength="50" class="form-control" name="nom" id="nom" placeholder="Dupont" value="<?= ($modifyPage ? $aPersonne['nom'] : '') ?>" required>
            </div>

            <!-- Prénom -->
            <div class="mb-3 col-4 text-end">
                <label for="prenom" class="form-label fw-semibold"><?= _("Prénom") ?> *</label>
            </div>
            <div class="mb-3 col-8">
                <input type="text" maxlength="50" class="form-control" name="prenom" id="prenom" placeholder="Jean" value="<?= ($modifyPage ? $aPersonne['prenom'] : '') ?>" required>
            </div>

            <!-- Date de naissance -->
            <div class="mb-3 col-4 text-end">
                <label for="dateNaissance" class="form-label fw-semibold"><?= _("Date de naissance") ?> *</label>
            </div>
            <div class="mb-3 col-8">
                <input type="date" class="form-control" name="dateNaissance" id="dateNaissance"
                    value="<?= ($modifyPage ? (new DateTime($aPersonne['dateNaissance']))->format('Y-m-d') : '') ?>" required>
            </div>

            <!-- Location -->
            <div class="mb-3 col-4 text-end">
                <label for="location" class="form-label"><?= _("Location") ?></label>
            </div>
            <div class="mb-3 col-8">
                <?= HTMLGenerator::select('location', $allLocations, (($modifyPage) ? $aPersonne['Localite'] : -1), ["class" => "form-select"]) ?>
            </div>

            <!-- Depuis -->
            <div class="mb-3 col-4 text-end">
                <label for="depuis" class="form-label"><?= _("Depuis") ?></label>
            </div>
            <div class="mb-3 col-8">
                <input type="date" class="form-control" name="depuis" id="depuis" value="<?= ($modifyPage ? (new DateTime($aPersonne['depuis']))->format('Y-m-d') : '') ?>">
            </div>

            <!-- Activités -->
            <div class="mb-3 col-4 text-end">
                <label for="activites" class="form-label"><?= _("Activités") ?></label>
            </div>
            <div class="mb-3 col-8">
                <?= HTMLGenerator::checkboxes(
                    'activites[]',
                    $allActivities,
                    ($modifyPage) ? $activites = explode(',', $aPersonne['Activites']) : []
                ) ?>
            </div>

            <!-- Soumettre le formulaire -->
            <div class="mb-3 col-4 text-end">
                <a href="/" class="btn btn-secondary"><?= _("Retour") ?></a>
            </div>
            <div class="mb-3 col-8">
                <button type="submit" id="submitForm" class="btn btn-primary"><?= _(($update ? 'Mettre à jour' : 'Créer')) ?></button>
            </div>
        </div>
    </div>
</form>
<!-- <script src="form_checker.js"></script> -->