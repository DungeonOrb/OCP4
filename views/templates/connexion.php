<section class="auth">
  <div class="auth-left">
    <h1>Connexion</h1>

    <?php if (!empty($error)): ?>
      <p class="alert alert-error"><?= $error ?></p>
    <?php endif; ?>

    <form class="auth-form" method="POST" action="index.php?action=login">
      <label>
        <span>Adresse email</span>
        <input
          type="email"
          name="email"
          required
          maxlength="35"
          value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>"
        >
      </label>

      <label>
        <span>Mot de passe</span>
        <input type="password" name="password" required maxlength="72">
      </label>

      <button type="submit" class="btn">Se connecter</button>
    </form>

    <p class="auth-footer">
      Pas de compte ? <a href="index.php?action=inscription">Inscrivez-vous</a>
    </p>
  </div>

  <div class="auth-right" aria-hidden="true"></div>
</section>