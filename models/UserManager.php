<?php

/** 
 * Classe UserManager pour gérer les requêtes liées aux users et à l'authentification.
 */

class UserManager extends AbstractEntityManager
{
    public function emailExists(string $email): bool
    {
        $sql = "SELECT id FROM user WHERE email = :email LIMIT 1";
        $res = $this->db->query($sql, ['email' => $email]);
        return (bool)$res->fetch();
    }

    // inscription d'un nouvel utilisateur
    public function createUser(string $nom, string $email, string $hashedPassword, ?string $photo = null): void
    {
        $sql = "INSERT INTO user (nom, email, password, photo)
                VALUES (:nom, :email, :password, :photo)";
        $this->db->query($sql, [
            'nom' => $nom,
            'email' => $email,
            'password' => $hashedPassword,
            'photo' => $photo
        ]);
        // récupération de l'utilisateur en utilisant son email
    }
    public function getUserByEmail(string $email): ?User
    {
        $sql = "SELECT * FROM user WHERE email = :email LIMIT 1";
        $res = $this->db->query($sql, ['email' => $email]);
        $row = $res->fetch();

        return $row ? new User($row) : null;
    }
    // récupération de l'utilisateur en utilisant son id
    public function getUserById(int $id): ?User
    {
        $sql = "SELECT * FROM user WHERE id = :id LIMIT 1";
        $res = $this->db->query($sql, ['id' => $id]);
        $row = $res->fetch();
        return $row ? new User($row) : null;
    }
    // annule une modification si l'utilisateur change son email pour un email déja existant
    public function emailExistsForOtherUser(string $email, int $currentUserId): bool
    {
        $sql = "SELECT id FROM user WHERE email = :email AND id <> :id LIMIT 1";
        $res = $this->db->query($sql, ['email' => $email, 'id' => $currentUserId]);
        return (bool)$res->fetch();
    }
    // met à jour les informations de l'utilisateur
    public function updateUser(int $id, string $nom, string $email): void
    {
        $sql = "UPDATE user SET nom = :nom, email = :email WHERE id = :id";
        $this->db->query($sql, ['nom' => $nom, 'email' => $email, 'id' => $id]);
    }
    // met à jour le mot de passe
    public function updatePassword(int $id, string $hashedPassword): void
    {
        $sql = "UPDATE user SET password = :password WHERE id = :id";
        $this->db->query($sql, ['password' => $hashedPassword, 'id' => $id]);
    }
    /*
       public function updatePhoto(int $userId, string $photoName): bool
    {
        $sql = "UPDATE users SET photo = :photo, updated_at = NOW() WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':photo' => $photoName,
            ':id'    => $userId,
        ]);
    }
    */
}
