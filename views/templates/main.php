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
    <title>Emilie Forteroche</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <header class="main-header">
    <div class="header-left">
        <img src="././img/tomtroc.png" alt="Tom Troc Logo" class="logo">
        <span class="brand-name">Tom Troc</span>
    </div>

    <nav class="main-nav">
        <a href="#">Accueil</a>
        <a href="#">Nos livres à l'échange</a>
    </nav>

    <div class="header-right">
        <a href="#" class="icon-link">Messagerie <span class="notif">0</span></a>
        <a href="#" class="icon-link">Mon compte</a>
        <a href="#" class="login-btn">Connexion</a>
    </div>
</header>

    <main>    
        <?= $content /* Ici est affiché le contenu réel de la page. */ ?>
    </main>
    
    <footer class="main-footer">
    <a class="item" href="#">Politique de confidentialité</a>
    <a class="item" href="#">Mentions légales</a>
    <span class="item">Tom Troc©</span>
    <span class="item">TT</span>
</footer>

</body>
</html>