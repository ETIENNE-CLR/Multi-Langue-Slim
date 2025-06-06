<?php

use Controllers\LanguageController;
?>
<main class="col-lg-10 mx-auto m-5 p-3">
    <!-- Header -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary mb-2">
        <div class="container-fluid">
            <a class="navbar-brand" href="/"><?= _("Liste des personnes") ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end gap-3" id="navbarNavAltMarkup">
                <div class="navbar-nav d-flex align-items-end gap-2">
                    <!-- Ajouter une personne -->
                    <a href="/create" class="btn btn-success nav-item">
                        <?= _("Ajouter une personne") ?>
                        <i class="bi bi-person-fill-add"></i>
                    </a>

                    <!-- Ajouter une activité -->
                    <a href="/create-activity" class="btn btn-primary nav-item">
                        <?= _("Ajouter une activité") ?>
                        <i class="bi bi-bicycle"></i>
                    </a>

                    <!-- Choix de la langue -->
                    <div class="dropdown nav-item">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= _("Langue") ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <?php foreach (LanguageController::LANGUAGES_TEXT() as $key => $value): ?>
                                <?php if (!LanguageController::isThisKeyCurrentLanguage($key)): ?>
                                    <li>
                                        <a class="dropdown-item" href="?lang=<?= $key ?>"><?= $value ?></a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>


    <!-- Tableau -->
    <table class="table table-striped border border-1">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col"><?= _("Nom") ?></th>
                <th scope="col"><?= _("Prénom") ?></th>
                <th scope="col"><?= _("Date de naissance") ?></th>
                <th scope="col"><?= _("Location") ?></th>
                <th scope="col"><?= _("Depuis") ?></th>
                <th scope="col"><?= _("Activités") ?></th>
                <th scope="col"><i class="bi bi-list"></i></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($allPersonne as $personne) {
                $html = '<tr>
                    <th scope="row">' . htmlspecialchars($personne['id']) . '</th>
                    <td><a href="/read/' . htmlspecialchars($personne['id']) . '">' . htmlspecialchars($personne['nom']) . '</a></td>
                    <td>' . htmlspecialchars($personne['prenom']) . '</td>
                    <td>' . htmlspecialchars((new DateTime($personne['dateNaissance']))->format('d.m.Y')) . '</td>
                    <td>' . htmlspecialchars($personne['Localite']) . '</td>
                    <td>' . htmlspecialchars((new DateTime($personne['depuis']))->format('d.m.Y')) . '</td>
                    <td>' . htmlspecialchars($personne['activites']) . '</td>
                    <td>
                        <a href="/update/' . htmlspecialchars($personne['id']) . '" class="btn btn-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="/delete/' . htmlspecialchars($personne['id']) . '" class="btn btn-danger">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>';
                echo $html;
            }
            ?>
        </tbody>
    </table>
</main>