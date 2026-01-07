<?php

class MessageController
{
    public function inbox(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $userId = (int)$_SESSION['user_id'];

        $discussionManager = new DiscussionManager();
        $messageManager    = new MessageManager();
        $userManager       = new UserManager();


        if (isset($_GET['to']) && is_numeric($_GET['to'])) {
            $otherId = (int)$_GET['to'];
            if ($otherId !== $userId) {
                $discussionId = $discussionManager->getOrCreateDiscussion($userId, $otherId);
                header('Location: index.php?action=messages&discussion=' . $discussionId);
                exit;
            }
        }


        $discussionId = isset($_GET['discussion']) && is_numeric($_GET['discussion']) 
                        ? (int)$_GET['discussion'] 
                        : 0;


        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $discussionId > 0) {
            $content = trim($_POST['content'] ?? '');
            if ($content !== '') {
                $messageManager->addMessage($discussionId, $userId, $content);
                header('Location: index.php?action=messages&discussion=' . $discussionId);
                exit;
            }
        }


        $discussions = $discussionManager->getDiscussionsForUser($userId);

        $messages   = [];
        $otherUser  = null;

        if ($discussionId > 0) {
            $messages = $messageManager->getMessagesByDiscussion($discussionId);

$row = $discussionManager->getDiscussionById($discussionId);
if ($row) {
    $otherId = ((int)$row['user1_id'] === $userId) 
        ? (int)$row['user2_id'] 
        : (int)$row['user1_id'];

    $otherUser = $userManager->getUserById($otherId);
}
        }

        $view = new View("Messagerie");
        $view->render("messagerie", [
            'discussions'  => $discussions,
            'messages'     => $messages,
            'discussionId' => $discussionId,
            'otherUser'    => $otherUser,
            'currentUserId'=> $userId
        ]);
    }
}