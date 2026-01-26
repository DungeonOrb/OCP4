<section class="auth">
  <div class="auth-left">
    <h1>Inscription</h1>

    <?php if (!empty($error)): ?>
      <p class="alert alert-error"><?= $error ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
      <p class="alert alert-success"><?= $success ?></p>
    <?php endif; ?>

    <form class="auth-form" method="POST" action="index.php?action=inscription">
      <label>
        <span>Pseudo</span>
        <input type="text" name="nom" required maxlength="35"
               value="<?= isset($_POST['nom']) ? $_POST['nom'] : '' ?>">
      </label>

      <label>
        <span>Adresse email</span>
        <input type="email" name="email" required maxlength="35"
               value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>">
      </label>

      <label>
        <span>Mot de passe</span>
        <input type="password" name="password" required minlength="6" maxlength="72">
      </label>

      <button type="submit" class="btn">S’inscrire</button>
    </form>

    <p class="auth-footer">
      Déjà inscrit ? <a href="index.php?action=login">Connectez-vous</a>
    </p>
  </div>

  <div class="auth-right"><img src="img/books.png" alt="Tas de Livres"></div>
</section>