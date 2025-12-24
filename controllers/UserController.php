<?php

class UserController
{
    public function inscription(): void
    {
        $error = "";
        $success = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($nom === '' || $email === '' || $password === '') {
                $error = "Veuillez remplir tous les champs.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Email invalide.";
            } else {
                $userManager = new UserManager();

                if ($userManager->emailExists($email)) {
                    $error = "Cet email est déjà utilisé.";
                } else {
                    $hashed = password_hash($password, PASSWORD_DEFAULT);

                    $userManager->createUser($nom, $email, $hashed, null);

                    $success = "Inscription réussie. Vous pouvez vous connecter.";
                    $_POST = [];
                }
            }
        }

        $view = new View("Inscription");
        $view->render("inscription");
        //connexion de l'utilisateur
    }
    public function login(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $error = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($email === '' || $password === '') {
                $error = "Veuillez remplir tous les champs.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Email invalide.";
            } else {
                $userManager = new UserManager();
                $user = $userManager->getUserByEmail($email);

                if (!$user) {
                    $error = "Email ou mot de passe incorrect.";
                } else {
                    if (!password_verify($password, $user->getPassword())) {
                        $error = "Email ou mot de passe incorrect.";
                    } else {
                        $_SESSION['user_id'] = $user->getId();
                        $_SESSION['user_nom'] = $user->getNom();
                        $_SESSION['user_email'] = $user->getEmail();

                        header('Location: index.php?action=livres');
                        exit;
                    }
                }
            }
        }

        $view = new View("Connexion");
        $view->render("connexion", ['error' => $error]);
    }
    public function compte(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $userManager = new UserManager();
        $livreManager = new LivreManager();

        $user = $userManager->getUserById((int)$_SESSION['user_id']);
        if (!$user) {
            session_destroy();
            header('Location: index.php?action=login');
            exit;
        }

        $livres = $livreManager->getLivresByUserId($user->getId());

        $view = new View("Mon compte");
        $view->render("compte", [
            'user' => $user,
            'livres' => $livres,
            'error' => $_SESSION['flash_error'] ?? '',
            'success' => $_SESSION['flash_success'] ?? ''
        ]);

        unset($_SESSION['flash_error'], $_SESSION['flash_success']);
    }
    public function updateCompte(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=account');
            exit;
        }

        $nom = trim($_POST['nom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $newPassword = $_POST['password'] ?? '';

        if ($nom === '' || $email === '') {
            $_SESSION['flash_error'] = "Nom et email sont obligatoires.";
            header('Location: index.php?action=account');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash_error'] = "Email invalide.";
            header('Location: index.php?action=account');
            exit;
        }

        $userManager = new UserManager();
        $userId = (int)$_SESSION['user_id'];

        if ($userManager->emailExistsForOtherUser($email, $userId)) {
            $_SESSION['flash_error'] = "Cet email est déjà utilisé.";
            header('Location: index.php?action=account');
            exit;
        }

        // update nom + email
        $userManager->updateUser($userId, $nom, $email);

        // update password si rempli
        if ($newPassword !== '') {
            if (strlen($newPassword) < 6) {
                $_SESSION['flash_error'] = "Le mot de passe doit faire au moins 6 caractères.";
                header('Location: index.php?action=account');
                exit;
            }
            $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
            $userManager->updatePassword($userId, $hashed);
        }

        // maj session
        $_SESSION['user_nom'] = $nom;
        $_SESSION['user_email'] = $email;

        $_SESSION['flash_success'] = "Informations mises à jour.";
        header('Location: index.php?action=account');
        exit;
    }

    public function comptePublic(): void
{
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($id <= 0) {
        header('Location: index.php?action=home');
        exit;
    }

    $userManager = new UserManager();
    $livreManager = new LivreManager();

    $user = $userManager->getUserById($id);
    if (!$user) {
        $view = new View("Profil introuvable");
        $view->render("errorPage", ['errorMessage' => "Utilisateur introuvable."]);
        return;
    }
    $livres = $livreManager->getLivresByUserId($id);
    $view = new View("Profil de " . $user->getNom());
    $view->render("comptepublic", [
        'user' => $user,
        'livres' => $livres
    ]);
}

public function uploadProfilePhoto(array $file, int $userId): void
    {
        // Sécurité basique
        if ($userId <= 0) {
            header('Location: index.php?action=profile&error=not_authenticated');
            exit;
        }

        if (empty($file) || !isset($file['error'])) {
            header('Location: index.php?action=profile&error=no_file');
            exit;
        }

        // 1) Upload physique via ton helper
        // -> doit retourner le nom/chemin relatif (ex: "user_12_abc.jpg") ou null
        $photoName = new UserController();
        $photoName = uploadProfilePhoto($file, $userId, 'uploads/');

        if ($photoName === null) {
            header('Location: index.php?action=profile&error=upload_failed');
            exit;
        }

        // 2) Mise à jour BDD
        $userModel = new UserManager();
        $ok = $userModel->updatePhoto($userId, $photoName);

        if (!$ok) {
            // Optionnel : supprimer le fichier si la BDD n'a pas été mise à jour
            $fullPath = rtrim('uploads/', '/') . '/' . ltrim($photoName, '/');
            if (is_file($fullPath)) {
                @unlink($fullPath);
            }

            header('Location: index.php?action=profile&error=db_update_failed');
            exit;
        }

        // 3) Optionnel : mettre à jour la session si tu affiches la photo depuis $_SESSION
        if (isset($_SESSION['user'])) {
            $_SESSION['user']['photo'] = $photoName;
        }

        // 4) Redirect succès
        header('Location: index.php?action=profile&success=photo_updated');
        exit;
    }
}
