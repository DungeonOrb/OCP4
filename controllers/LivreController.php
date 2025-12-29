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

    public function editlivre(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['user_id'])) {
        header('Location: index.php?action=login');
        exit;
    }

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        header('Location: index.php?action=compte');
        exit;
    }

    $id = (int)$_GET['id'];

    $livreManager = new LivreManager();
    $livre = $livreManager->getlivreById($id);

    if (!$livre) {
        $view = new View("Livre introuvable");
        $view->render("errorPage", ['errorMessage' => "Ce livre n'existe pas."]);
        return;
    }

    if ($livre->getIdUser() !== (int)$_SESSION['user_id']) {
        header('Location: index.php?action=compte');
        exit;
    }

    $error = "";
    $success = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $titre   = trim($_POST['titre'] ?? '');
        $auteur  = trim($_POST['auteur'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $dispo   = isset($_POST['dispo']) ? (int)$_POST['dispo'] : 1;

        if ($titre === '' || $auteur === '' || $content === '') {
            $error = "Merci de remplir tous les champs.";
        } else {
            $livre->setTitre($titre);
            $livre->setAuteur($auteur);
            $livre->setContent($content);
            $livre->setDispo($dispo);
            // image à faire plus tard

            $livreManager->updatelivre($livre);
            $success = "Livre mis à jour avec succès.";
        }
    }

    $view = new View("Modifier le livre");
    $view->render("edit_livre", [
        'livre'   => $livre,
        'error'   => $error,
        'success' => $success
    ]);
}
// page d'ajout de livre
public function addLivre(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['user_id'])) {
        header('Location: index.php?action=login');
        exit;
    }

    $error = "";
    $success = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $titre   = trim($_POST['titre'] ?? '');
        $auteur  = trim($_POST['auteur'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $image   = trim($_POST['image'] ?? '');
        $dispo   = isset($_POST['dispo']) ? (int)$_POST['dispo'] : 1;

        if ($titre === '' || $auteur === '' || $content === '') {
            $error = "Merci de remplir au moins le titre, l'auteur et le commentaire.";
        } else {
            $livre = new Livre();
            $livre->setIdUser((int)$_SESSION['user_id']);
            $livre->setTitre($titre);
            $livre->setAuteur($auteur);
            $livre->setContent($content);
            $livre->setDispo($dispo);

            if ($image === '') {
                $image = 'img/default-book.jpg';
            }
            $livre->setImage($image);

            $livreManager = new LivreManager();
            $livreManager->addlivre($livre);

            // retour au compte après ajout
            header('Location: index.php?action=compte');
            exit;
        }
    }

    $view = new View("Ajouter un livre");
    $view->render("add_livre", [
        'error' => $error,
        'success' => $success
    ]);
}
}
