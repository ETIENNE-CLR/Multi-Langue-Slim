<main class="col-lg-10 mx-auto m-5 p-3">
    <h1 class="h2 mb-3"><?= _("Liste des personnes") ?></h1>

    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="/create" class="btn btn-success mb-3">
            <?= _("Ajouter une personne") ?>
            <i class="bi bi-person-fill-add"></i>
        </a>
    </div>

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