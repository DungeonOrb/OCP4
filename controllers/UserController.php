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
}
