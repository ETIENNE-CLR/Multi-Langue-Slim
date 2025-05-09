<div class="container col-md-7 mx-auto mt-3">
    <h2 class="mb-5">
        Afficher une personne
        <i class="bi bi-eye"></i>
    </h2>

    <div class="col-12 row">
        <!-- Nom -->
        <div class="mb-3 col-4 text-end">
            <label for="nom" class="form-label fw-semibold"><?= _("Nom") ?></label>
        </div>
        <div class="mb-3 col-8">
            <p><?= $aPersonne["nom"] ?></p>
        </div>

        <!-- Prénom -->
        <div class="mb-3 col-4 text-end">
            <label for="prenom" class="form-label fw-semibold"><?= _("Prénom") ?></label>
        </div>
        <div class="mb-3 col-8">
            <p><?= $aPersonne["prenom"] ?></p>
        </div>

        <!-- Date de naissance -->
        <div class="mb-3 col-4 text-end">
            <label for="dateNaissance" class="form-label fw-semibold"><?= _("Date de naissance") ?></label>
        </div>
        <div class="mb-3 col-8">
            <p><?= (new DateTime($aPersonne['dateNaissance']))->format('d.m.Y') ?></p>
        </div>

        <!-- Location -->
        <div class="mb-3 col-4 text-end">
            <label for="location" class="form-label"><?= _("Location") ?></label>
        </div>
        <div class="mb-3 col-8">
            <p><?= $aPersonne["Localite"] ?></p>
        </div>

        <!-- Depuis -->
        <div class="mb-3 col-4 text-end">
            <label for="depuis" class="form-label"><?= _("Depuis") ?></label>
        </div>
        <div class="mb-3 col-8">
            <p><?= (new DateTime($aPersonne['depuis']))->format('d.m.Y') ?></p>
        </div>

        <!-- Activités -->
        <div class="mb-3 col-4 text-end">
            <label for="activites" class="form-label"><?= _("Activités") ?></label>
        </div>
        <div class="mb-3 col-8">
            <p><?= $aPersonne["activites"] ?></p>
        </div>

        <!-- Bouton retour -->
        <div class="mb-3 col-4 text-end"></div>
        <div class="mb-3 col-8">
            <a href="/" class="btn btn-secondary"><?= _("Retour") ?></a>
        </div>
    </div>
</div>