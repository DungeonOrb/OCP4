<?php 

class LivreController 
{
    /**
     * Affiche la page d'accueil.
     * @return void
     */
    public function showHome() : void
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
    public function showlivre() : void
    {
        // Récupération de l'id de l'livre demandé.
        $id = Utils::request("id", -1);

        $livreManager = new LivreManager();
        $livre = $livreManager->getlivreById($id);
        
        if (!$livre) {
            throw new Exception("Le livre demandé n'existe pas.");
        }

        $view = new View($livre->getTitle());
    }

    /**
     * Affiche le formulaire d'ajout d'un livre.
     * @return void
     */
    public function addlivre() : void
    {
        $view = new View("Ajouter un livre");
        $view->render("addlivre");
    }

    /**
     * Affiche la page "à propos".
     * @return void
     */
    public function showApropos() {
        $view = new View("A propos");
        $view->render("apropos");
    }
}