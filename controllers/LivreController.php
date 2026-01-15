<?php

class LivreController
{
    /**
     * Affiche la page d'accueil.
     * @return void
     */
    public function showHome(): void
    {
        $livreManager = new LivreManager();
        $livres = $livreManager->getLastLivres(4);

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
     * Affiche la page "livrDetail" et s'occupe de la fonction de recherche
     */
    public function showDetail(): void
    {
        $livreManager = new LivreManager();
        $userManager  = new UserManager();

        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            header('Location: index.php?action=livres');
            exit;
        }

        $id    = (int)$_GET['id'];
        $livre = $livreManager->getlivreById($id);

        if (!$livre) {
            $view = new View("Livre introuvable");
            $view->render("errorPage", ['errorMessage' => "Ce livre n'existe pas."]);
            return;
        }

        $owner = $userManager->getUserById($livre->getIdUser());

        $view = new View($livre->getTitre());
        $view->render("livreDetail", [
            'livre' => $livre,
            'owner' => $owner
        ]);
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
        $view->render("editLivre", [
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

        $userId = (int)($_SESSION['user_id'] ?? 0);
        if ($userId <= 0) {
            header('Location: index.php?action=login');
            exit;
        }

        $error = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre   = trim($_POST['titre'] ?? '');
            $auteur  = trim($_POST['auteur'] ?? '');
            $content = trim($_POST['content'] ?? '');
            $dispo   = isset($_POST['dispo']) ? (int)$_POST['dispo'] : 1;

            if ($titre === '' || $auteur === '' || $content === '') {
                $error = "Merci de remplir tous les champs.";
            } else {
                // upload photo (facultatif)
                $imgPath = Utils::handleImageUpload(
                    $_FILES['photo'] ?? [],
                    'uploads/books',
                    'book_user' . $userId
                );

                // si aucune image envoyée => default
                if ($imgPath === null) {
                    $imgPath = 'img/default-book.jpg';
                }

                $livre = new Livre();
                $livre->setIdUser($userId);
                $livre->setTitre($titre);
                $livre->setAuteur($auteur);
                $livre->setContent($content);
                $livre->setDispo($dispo);
                $livre->setImage($imgPath);

                $livreManager = new LivreManager();
                $livreManager->addlivre($livre);

                $_SESSION['flash_success'] = "Livre ajouté ✅";
                header('Location: index.php?action=compte');
                exit;
            }
        }

        $view = new View("Ajouter un livre");
        $view->render("addLivre", ['error' => $error]);
    }
    public function uploadBookPhoto(array $file, int $livreId): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = (int)($_SESSION['user_id'] ?? 0);
        if ($userId <= 0) {
            header('Location: index.php?action=login');
            exit;
        }

        if ($livreId <= 0) {
            header('Location: index.php?action=compte');
            exit;
        }

        $livreManager = new LivreManager();
        $livre = $livreManager->getlivreById($livreId);

        if (!$livre) {
            header('Location: index.php?action=compte');
            exit;
        }

        // sécurité: seul le propriétaire peut changer la photo
        if ($livre->getIdUser() !== $userId) {
            header('Location: index.php?action=compte');
            exit;
        }

        $oldImage = $livreManager->getImageById($livreId);

        $newImage = Utils::handleImageUpload(
            $file,
            'uploads/books',
            'book_' . $livreId
        );

        if ($newImage === null) {
            $_SESSION['flash_error'] = "Échec de l'upload de la photo du livre.";
            header('Location: index.php?action=editLivre&id=' . $livreId);
            exit;
        }

        $ok = $livreManager->updateImage($livreId, $newImage);

        if (!$ok) {
            Utils::deleteUploadedImage($newImage, 'uploads/books');
            $_SESSION['flash_error'] = "Impossible de sauvegarder la photo du livre.";
            header('Location: index.php?action=editLivre&id=' . $livreId);
            exit;
        }

        Utils::deleteUploadedImage($oldImage, 'uploads/books');

        $_SESSION['flash_success'] = "Photo du livre mise à jour ✅";
        header('Location: index.php?action=editLivre&id=' . $livreId);
        exit;
    }
}
