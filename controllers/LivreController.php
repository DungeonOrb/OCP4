<?php

class LivreController
{
    /**
     * Affiche la page d'accueil.
     * @return void
     */
    public function showHome(): void
    {
        $livreManager = new livreManager();
        $livres = $livreManager->getAlllivres();

        $view = new View("Accueil");
        $view->render("home", ['livres' => $livres]);
    }

    /**
     * Affiche le détail d'un livre.
     * @return void
     */
    public function showlivre(): void
    {
        $livreManager = new LivreManager();

        $q = isset($_GET['q']) ? trim($_GET['q']) : '';

        if ($q !== '') {
            $livres = $livreManager->searchLivresByTitle($q);
        } else {
            $livres = $livreManager->getAllLivres();
        }

        $view = new View("Livres");
        $view->render("livres", ['livres' => $livres]);
    }

    /**
     * Affiche le formulaire d'ajout d'un livre.
     * @return void
     */
    public function addlivre(): void
    {
        $view = new View("Ajouter un livre");
        $view->render("addlivre");
    }

    /**
     * Affiche la page "à propos".
     * @return void
     */
    public function showApropos()
    {
        $view = new View("A propos");
        $view->render("apropos");
    }
    
    /**
     * Affiche la page "livre_detail" et s'occupe de la fonction de recherche
     */
    public function showDetail(): void
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            header('Location: index.php?action=livres');
            exit;
        }

        $livreManager = new LivreManager();
        $livre = $livreManager->getLivreById((int)$_GET['id']);

        if (!$livre) {
            header('Location: index.php?action=livres');
            exit;
        }

        $view = new View("Détail du livre");
        $view->render("livre_detail", ['livre' => $livre]);
    }
}
