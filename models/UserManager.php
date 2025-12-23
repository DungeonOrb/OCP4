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
}
