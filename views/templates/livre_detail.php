<section class="book-detail">
    <img src="<?= $livre->getImage() ?>" alt="">

    <div class="info">
        <h1><?= $livre->getTitre() ?></h1>
        <p class="author">Auteur : <?= $livre->getAuteur() ?></p>
        <p class="seller">Vendu par : <a href="index.php?action=comptepublic&id=<?= (int)$livre->getVendeur() ?>"> <?= (string)$livre->getVendeur() ?></a></p>

        <div class="content">
            <?= nl2br($livre->getContent()) ?>
        </div>
    </div>
</section>