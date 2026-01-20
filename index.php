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
        case 'livre':
            $controller = new LivreController();
            $controller->showDetail();
            break;

        case 'inscription':
            $controller = new UserController();
            $controller->inscription();
            break;

        case 'login':
            $controller = new UserController();
            $controller->login();
            break;

        case 'compte':
            $controller = new UserController();
            $controller->compte();
            break;

        case 'updatecompte':
            $controller = new UserController();
            $controller->updateCompte();
            break;

        case 'uploadphoto':
            $controller = new UserController();
            $controller->uploadProfilePhoto($_FILES['photo'] ?? [], (int)($_SESSION['user_id'] ?? 0));
            break;

        case 'uploadbookphoto':
            $controller = new LivreController();
            $controller->uploadBookPhoto($_FILES['photo'] ?? [], (int)($_GET['id'] ?? 0));
            break;

        case 'comptepublic':
            $controller = new UserController();
            $controller->comptePublic();
            break;

        case 'editLivre':
            $controller = new LivreController();
            $controller->editlivre();
            break;

        case 'addLivre':
            $controller = new LivreController();
            $controller->addlivre();
            break;

        case 'messages':
            $controller = new MessageController();
            $controller->inbox();
            break;

        case 'disconnect':
            $controller = new UserController();
            $controller->disconnect();
            break;

        default:
            throw new Exception("La page demandée n'existe pas.");
    }
} catch (Exception $e) {
    // En cas d'erreur, on affiche la page d'erreur.
    $errorView = new View('Erreur');
    $errorView->render('errorPage', ['errorMessage' => $e->getMessage()]);
}
