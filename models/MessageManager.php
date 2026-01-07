<?php

class MessageManager extends AbstractEntityManager
{
    /**
     * Récupère tous les messages d'une discussion, dans l'ordre chronologique.
     */
    public function getMessagesByDiscussion(int $discussionId): array
    {
        $sql = "SELECT m.*, u.nom AS sender_name
                FROM message m
                JOIN user u ON u.id = m.sender_id
                WHERE m.discussion_id = :did
                ORDER BY m.created_at ASC";

        $res = $this->db->query($sql, ['did' => $discussionId]);
        return $res->fetchAll();
    }

    /**
     * Ajoute un message dans une discussion.
     */
    public function addMessage(int $discussionId, int $senderId, string $content): void
    {
        $sql = "INSERT INTO message (discussion_id, sender_id, content)
                VALUES (:did, :sid, :content)";

        $this->db->query($sql, [
            'did'     => $discussionId,
            'sid'     => $senderId,
            'content' => $content
        ]);
    }
}