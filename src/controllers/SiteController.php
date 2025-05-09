<?php

namespace Controllers;

use DateTime;
use Models\Activites;
use Models\Personne;
use Models\Localite;
use Models\Pratiquer;
use Slim\Views\PhpRenderer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SiteController
{
    public static function getAddonPath(): string
    {
        $addonPath = '';
        $slashCount = substr_count($_SERVER['REQUEST_URI'], '/');
        for ($i = $slashCount; $i > 1; $i--) {
            $addonPath .= '../';
        }
        return $addonPath;
    }

    public function read(Request $request, Response $response): Response
    {
        // Construire la structure de la page
        $dataLayout = ['title' => _('Voir les personnes')];
        $phpView = new PhpRenderer(__DIR__ . '/../views', $dataLayout);
        $phpView->setLayout("_template.php");
        return $phpView->render($response, 'read.php', [
            'allPersonne' => Personne::read()
        ]);
    }

    public function detail(Request $request, Response $response, array $args): Response
    {
        // Construire la structure de la page
        $idPe = (int)$args['id'];
        $dataLayout = ['title' => _("Détails d'une personne")];
        $phpView = new PhpRenderer(__DIR__ . '/../views', $dataLayout);
        $phpView->setLayout("_template.php");
        return $phpView->render($response, 'details.php', [
            'aPersonne' => Personne::readById($idPe)
        ]);
    }

    public function createView(Request $request, Response $response): Response
    {
        // Construire la structure de la page
        $dataLayout = ['title' => _('Créer une personne')];
        $phpView = new PhpRenderer(__DIR__ . '/../views', $dataLayout);
        $phpView->setLayout("_template.php");
        return $phpView->render($response, 'create.php', [
            'allLocations' => Localite::read(),
            'allActivities' => Activites::read(),
        ]);
    }

    public function create(Request $request, Response $response): Response
    {
        // Récupérer les informations du formulaire
        $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $dateNaissance = filter_input(INPUT_POST, 'dateNaissance', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_NUMBER_INT) ?? null;
        $depuis = new DateTime(filter_input(INPUT_POST, 'depuis', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $selectedActivities = filter_input(INPUT_POST, 'activites', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY) ?? [];

        // Voir les informations
        var_dump(
            $nom,
            $prenom,
            $dateNaissance,
            $location,
            $depuis,
            $selectedActivities
        );

        // Créer la personne
        $newPersonne = new Personne($nom, $prenom, new DateTime($dateNaissance), $location, $depuis);
        $newPersonne->create();

        // Lié les activitées aux personnes
        foreach ($selectedActivities as $activity) {
            Pratiquer::makeRelation($newPersonne->id, (int)$activity);
        }

        // Rediriger l'utilisateur
        return $response->withHeader('Location', '/')->withStatus(302);
        die();
    }

    public function updateView(Request $request, Response $response, array $args): Response
    {
        // Construire la structure de la page
        $idPe = (int)$args['id'];
        $dataLayout = ['title' => 'Modifier une personne'];
        $phpView = new PhpRenderer(__DIR__ . '/../views', $dataLayout);
        $phpView->setLayout("_template.php");
        return $phpView->render($response, 'create.php', [
            'allLocations' => Localite::read(),
            'allActivities' => Activites::read(),
            'aPersonne' => Personne::readByIdWithIDs($idPe)
        ]);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        // Récupérer les informations du formulaire
        $idPe = (int)$args['id'];
        $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $dateNaissance = filter_input(INPUT_POST, 'dateNaissance', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $location = (int)filter_input(INPUT_POST, 'location', FILTER_SANITIZE_NUMBER_INT) ?? null;
        $depuis = filter_input(INPUT_POST, 'depuis', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $selectedActivities = filter_input(INPUT_POST, 'activites', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY) ?? [];

        // Voir les informations
        var_dump(
            $idPe,
            $nom,
            $prenom,
            $dateNaissance,
            $location,
            $depuis,
            $selectedActivities
        );

        // Créer la personne
        $newPersonne = new Personne($nom, $prenom, new DateTime($dateNaissance), $location, new DateTime($depuis));
        $newPersonne->id = $idPe;
        $newPersonne->update();

        // Lié les activitées aux personnes
        foreach ($selectedActivities as $activity) {
            Pratiquer::makeRelation($newPersonne->id, (int)$activity);
        }

        // Rediriger l'utilisateur
        return $response->withHeader('Location', '/')->withStatus(302);
        die();
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        // Récupérer l'id de la personne
        $id = (int)$args['id'];
        var_dump($id);

        // Supprimer les données
        Pratiquer::delete($id);
        Personne::delete($id);

        // Rediriger l'utilisateur
        return $response->withHeader('Location', '/')->withStatus(302);
        die();
    }
}
