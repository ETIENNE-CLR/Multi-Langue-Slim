<div class="col-lg-6 col-md-8 mx-auto">
    <div class="card text-center" id="navigationContainer">
        <!-- Menu de navigation -->
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="menu-navbar">
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">Disabled</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">Disabled</a>
                </li>
            </ul>
        </div>

        <!-- Francais -->
        <div class="card-body" id="fr">
            <h5 class="card-title">Special title treatment</h5>
            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
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