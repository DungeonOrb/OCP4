<?php 
/**
 * Contrôleur de la partie admin.
 */
 
class AdminController {

    /**
     * Affiche la page d'administration.
     * @return void
     */
    public function showAdmin() : void
    {
        // On vérifie que l'utilisateur est connecté.
        $this->checkIfUserIsConnected();

        // On récupère les livres.
        $livreManager = new LivreManager();
        $livres = $livreManager->getAlllivres();

        // On affiche la page d'administration.
        $view = new View("Administration");
        $view->render("admin", [
            'livres' => $livres
        ]);
    }

    /**
     * Vérifie que l'utilisateur est connecté.
     * @return void
     */
    private function checkIfUserIsConnected() : void
    {
        // On vérifie que l'utilisateur est connecté.
        if (!isset($_SESSION['user'])) {
            Utils::redirect("connectionForm");
        }
    }

    /**
     * Affichage du formulaire de connexion.
     * @return void
     */
    public function displayConnectionForm() : void 
    {
        $view = new View("Connexion");
        $view->render("connectionForm");
    }

    /**
     * Connexion de l'utilisateur.
     * @return void
     */

    /**
     * Déconnexion de l'utilisateur.
     * @return void
     */
    public function disconnectUser() : void 
    {
        // On déconnecte l'utilisateur.
        unset($_SESSION['user']);

        // On redirige vers la page d'accueil.
        Utils::redirect("home");
    }

    /**
     * Affichage du formulaire d'ajout d'un livre.
     * @return void
     */
    public function showUpdatelivreForm() : void 
    {
        $this->checkIfUserIsConnected();

        // On récupère l'id de l'livre s'il existe.
        $id = Utils::request("id", -1);

        // On récupère l'livre associé.
        $livreManager = new LivreManager();
        $livre = $livreManager->getLivreById($id);

        // Si l'livre n'existe pas, on en crée un vide. 
        if (!$livre) {
            $livre = new Livre();
        }

        // On affiche la page de modification de l'livre.
        $view = new View("Edition d'un livre");
        $view->render("updatelivreForm", [
            'livre' => $livre
        ]);
    }

    /**
     * Ajout et modification d'un livre. 
     * On sait si un livre est ajouté car l'id vaut -1.
     * @return void
     */
    public function updatelivre() : void 
    {
        $this->checkIfUserIsConnected();

        // On récupère les données du formulaire.
        $id = Utils::request("id", -1);
        $title = Utils::request("title");
        $content = Utils::request("content");

        // On vérifie que les données sont valides.
        if (empty($title) || empty($content)) {
            throw new Exception("Tous les champs sont obligatoires. 2");
        }

        // On crée l'objet livre.
        $livre = new Livre([
            'id' => $id, // Si l'id vaut -1, l'livre sera ajouté. Sinon, il sera modifié.
            'title' => $title,
            'content' => $content,
            'id_user' => $_SESSION['idUser']
        ]);

        // On ajoute l'livre.
        $livreManager = new livreManager();
        $livreManager->addOrUpdatelivre($livre);

        // On redirige vers la page d'administration.
        Utils::redirect("admin");
    }


    /**
     * Suppression d'un livre.
     * @return void
     */
    public function deletelivre() : void
    {
        $this->checkIfUserIsConnected();

        $id = Utils::request("id", -1);

        // On supprime l'livre.
        $livreManager = new livreManager();
        $livreManager->deletelivre($id);
       
        // On redirige vers la page d'administration.
        Utils::redirect("admin");
    }
    public function displayMonitoring() : void 
    {
        $this->checkIfUserIsConnected();
        $view = new View("Monitoring");
        $view->render("monitoring");
    }

}