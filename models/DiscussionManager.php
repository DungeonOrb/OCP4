<?php

/**
 * Classe qui gère la messagerie.
 */
class DiscussionManager extends AbstractEntityManager
{
    /**
     * récupère ou crée une discussion entre deux utilisateurs.
     */
    public function getOrCreateDiscussion(int $userId, int $otherId): int
    {
        $sql = "SELECT id FROM discussion
                WHERE (user1_id = :u1 AND user2_id = :u2)
                   OR (user1_id = :u2 AND user2_id = :u1)
                LIMIT 1";
        $res = $this->db->query($sql, ['u1' => $userId, 'u2' => $otherId]);
        $row = $res->fetch();

        if ($row) {
            return (int)$row['id'];
        }

        $sql = "INSERT INTO discussion (user1_id, user2_id) VALUES (:u1, :u2)";
        $this->db->query($sql, ['u1' => $userId, 'u2' => $otherId]);

        return (int)$this->db->getLastInsertId();
    }


    public function getDiscussionsForUser(int $userId): array
{
    $sql = "
        SELECT d.id,
               IF(d.user1_id = :uid, u2.nom, u1.nom) AS other_name,
               m.content AS last_message,
               m.created_at AS last_date
        FROM discussion d
        JOIN user u1 ON u1.id = d.user1_id
        JOIN user u2 ON u2.id = d.user2_id
        LEFT JOIN message m ON m.id = (
            SELECT id FROM message 
            WHERE discussion_id = d.id
            ORDER BY created_at DESC
            LIMIT 1
        )
        WHERE d.user1_id = :uid OR d.user2_id = :uid
        ORDER BY 
            -- on met celles avec message en premier
            (last_date IS NULL) ASC,
            last_date DESC,
            d.created_at DESC
    ";

    $res = $this->db->query($sql, ['uid' => $userId]);
    return $res->fetchAll();
}
public function getDiscussionById(int $id): ?array
{
    $sql = "SELECT * FROM discussion WHERE id = :id LIMIT 1";
    $res = $this->db->query($sql, ['id' => $id]);
    $row = $res->fetch();
    return $row ?: null;
}
}