<?php

require_once 'config/_config.php';
require_once 'config/autoload.php';

// On récupère l'action demandée par l'utilisateur.
// Si aucune action n'est demandée, on affiche la page d'accueil.
$action = Utils::request('action', 'home');

// Try catch global pour gérer les erreurs
try {
    // Pour chaque action, on appelle le bon contrôleur et la bonne méthode.
    switch ($action) {
        // Pages accessibles à tous.
        case 'home':
            $livreController = new LivreController();
            $livreController->showHome();
            break;

        case 'apropos':
            $livreController = new LivreController();
            $livreController->showApropos();
            break;

        case 'livres':
            $livreController = new LivreController();
            $livreController->showlivre();
            break;

        case 'addlivre':
            $livreController = new LivreController();
            $livreController->addlivre();
            break;

        case 'addComment':
            $commentController = new CommentController();
            $commentController->addComment();
            break;


        // Section admin & connexion. 
        case 'admin':
            $adminController = new AdminController();
            $adminController->showAdmin();
            break;

        case 'connectionForm':
            $adminController = new AdminController();
            $adminController->displayConnectionForm();
            break;

        case 'connectUser':
            $adminController = new AdminController();
            $adminController->connectUser();
            break;

        case 'disconnectUser':
            $adminController = new AdminController();
            $adminController->disconnectUser();
            break;

        case 'showUpdatelivreForm':
            $adminController = new AdminController();
            $adminController->showUpdatelivreForm();
            break;

        case 'updatelivre':
            $adminController = new AdminController();
            $adminController->updatelivre();
            break;

        case 'deletelivre':
            $adminController = new AdminController();
            $adminController->deletelivre();
            break;

        case 'monitoring':
            $adminController = new AdminController();
            $adminController->displayMonitoring();
            break;
        case 'livre':
            $controller = new LivreController();
            $controller->showDetail();
            break;
        default:
            throw new Exception("La page demandée n'existe pas.");
    }
} catch (Exception $e) {
    // En cas d'erreur, on affiche la page d'erreur.
    $errorView = new View('Erreur');
    $errorView->render('errorPage', ['errorMessage' => $e->getMessage()]);
}
