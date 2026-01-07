<?php require_once 'controllers/MessageController.php'; ?>
<section class="messages-page">
  <div class="messages-layout">

    <aside class="conv-list">
      <h2>Messagerie</h2>

      <?php foreach ($discussions as $conv): ?>
        <a class="conv-item <?= ($discussionId == $conv['id']) ? 'active' : '' ?>"
           href="index.php?action=messages&discussion=<?= $conv['id'] ?>">
          <div class="avatar-small"></div>
          <div class="conv-text">
            <div class="conv-top">
              <span class="conv-name"><?= $conv['other_name'] ?></span>
              <?php if (!empty($conv['last_date'])): ?>
                <span class="conv-date">
                  <?= date('H:i', strtotime($conv['last_date'])) ?>
                </span>
              <?php endif; ?>
            </div>
            <div class="conv-last">
              <?= mb_substr((string)$conv['last_message'], 0, 30) ?>...
            </div>
          </div>
        </a>
      <?php endforeach; ?>

      <?php if (empty($discussions)): ?>
        <p class="no-conv">Aucune discussion pour le moment.</p>
      <?php endif; ?>
    </aside>


    <div class="conv-main">
      <?php if ($discussionId === 0): ?>
        <div class="conv-empty">
          <p>Sélectionnez une discussion à gauche ou écrivez depuis le profil d’un utilisateur.</p>
        </div>
      <?php else: ?>
        <header class="conv-header">
          <?php if ($otherUser): ?>
            <div class="avatar-small"></div>
            <span class="conv-title"><?= $otherUser->getNom() ?></span>
          <?php endif; ?>
        </header>

        <div class="conv-messages">
          <?php foreach ($messages as $msg): ?>
            <?php $isMe = ((int)$msg['sender_id'] === (int)$currentUserId); ?>
            <div class="msg-row <?= $isMe ? 'me' : 'them' ?>">
              <div class="msg-bubble">
                <?= nl2br($msg['content']) ?>
              </div>
              <div class="msg-date">
                <?= date('d.m H:i', strtotime($msg['created_at'])) ?>
              </div>
            </div>
          <?php endforeach; ?>

          <?php if (empty($messages)): ?>
            <p class="no-msg">Aucun message pour l’instant. Démarrez la conversation 😊</p>
          <?php endif; ?>
        </div>


        <form class="msg-form" method="POST"
              action="index.php?action=messages&discussion=<?= $discussionId ?>">
          <input type="text" name="content" placeholder="Tapez votre message ici" required>
          <button type="submit">Envoyer</button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</section>