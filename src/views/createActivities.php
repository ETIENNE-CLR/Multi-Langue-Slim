<div class="col-lg-6 col-md-8 mx-auto">
    <h1 class="h2 my-3">Créer une activité</h1>
    <div class="card text-center" id="navigationContainer">
        <!-- Menu de navigation -->
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="menu-navbar">
                <?php
                foreach ($langages as $key => $value) {
                    echo ('<li class="nav-item"><a class="nav-link text-dark" href="#">' . $value . '</a></li>');
                }
                ?>
            </ul>
        </div>

        <!-- Les langues -->
        <?php
        foreach ($langages as $key => $value) {
            $strHtml = '<div class="card-body" id="nav-' . strtolower($value) . '">
                <div class="d-flex justify-content-between mb-3">
                    <div class="col-6 d-flex flex-column align-items-start">
                        <label for="activite-' . $key . '-nom" class="form-label">' . _("Nom de l'activité") . '</label>
                        <input type="text" class="form-control" id="activite-' . $key . '-nom" minlength="60" placeholder="' . _("Foot Ball") . '">
                    </div>
                    <div class="col-5 d-flex flex-column align-items-start">
                        <label for="activite-' . $key . '-sigle" class="form-label">' . _("Sigle de l'activité") . '</label>
                        <input type="text" class="form-control" id="activite-' . $key . '-sigle" minlength="25" placeholder="'. _("FIFA").'">
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="" id="activite-' . $key . '-description"></textarea>
                        <label for="activite-' . $key . '-description">' . _("Description de l'activité") . '</label>
                    </div>
                </div>
            </div>';
            echo $strHtml;
        }
        ?>
    </div>

    <div class="d-flex justify-content-end my-2">
        <a href="/" class="btn btn-secondary"><?= _("Retour") ?></a>
    </div>
</div>
<script>
    const menu = document.getElementById('menu-navbar');
    const links = menu.querySelectorAll('a');
    const bodys = document.querySelectorAll('#navigationContainer .card-body');
    links.forEach(l => {
        l.addEventListener('click', () => {
            // Supprimer / Ajouter le active
            links.forEach(t => {
                t.classList.remove('active');
            });
            l.classList.add('active');

            // Afficher la bonne vue
            bodys.forEach(u => {
                u.style.display = (u.id.split('-')[1] == l.innerText.toLowerCase()) ? 'block' : 'none';
            });
        });
    });
    links[0].click();
</script>