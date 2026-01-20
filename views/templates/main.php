<?php

/**
 * Ce fichier est le template principal qui "contient" ce qui aura été généré par les autres vues.  
 * 
 * Les variables qui doivent impérativement être définie sont : 
 *      $title string : le titre de la page.
 *      $content string : le contenu de la page. 
 */

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tom Troc</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <header class="main-header">
        <div class="header-left">
            <img src="././img/tomtroc.png" alt="Tom Troc Logo" class="logo">
            <span class="brand-name">Tom Troc</span>
        </div>

        <nav class="main-nav">
            <a href="index.php">Accueil</a>
            <a href="index.php?action=livres">Nos livres à l'échange</a>
        </nav>

        <div class="header-right">
            <a href="index.php?action=messages" class="icon-link">Messagerie <span class="notif">0</span></a>
            <a href="index.php?action=compte" class="icon-link">Mon compte</a>
            <?php if (isset ($_SESSION['user_id'])){ ?>
            <a href="index.php?action=disconnect" class="login-btn">Déconnexion</a> <?php } else {?> <a href="index.php?action=login" class="login-btn">Connexion</a> <?php }?>
        </div>
    </header>

    <main>
        <?= $content /* Ici est affiché le contenu réel de la page. */ ?>
    </main>

    <footer class="footer">
    <div class="footer-content">
        <a href="#">Politique de confidentialité</a>
        <a href="#">Mentions légales</a>
        <span>Tom Troc©</span>
        <span class="footer-logo">T<span>t</span></span>
    </div>
</footer>

</body>

</html>