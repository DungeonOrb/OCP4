<?php

/**
 * Classe qui gère les livrees.
 */
class LivreManager extends AbstractEntityManager
{
    /**
     * Récupère tous les livres.
     * @return array : un tableau d'objets Livre.
     */
    public function getAllLivres(): array
    {
        $sql = "SELECT * FROM livre";
        $result = $this->db->query($sql);
        $livres = [];

        while ($livre = $result->fetch()) {
            $livres[] = new Livre($livre);
        }
        return $livres;

        $q = isset($_GET['q']) ? trim($_GET['q']) : '';

        if ($q === '') {
            $livres = $this->livreManager->getAllLivres();
        } else {
            $livres = $this->livreManager->searchLivresByTitle($q);
        }

        $this->view->render('livres', ['livres' => $livres]);
    }

    /**
     * Récupère un livre par son id.
     * @param int $id : l'id de l'livre.
     * @return Livre|null : un objet livre ou null si l'livre n'existe pas.
     */
    public function getlivreById(int $id): ?Livre
    {
        $sql = "SELECT * FROM livre WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        $livre = $result->fetch();
        if ($livre) {
            return new Livre($livre);
        }
        return null;
    }

    /**
     * Ajoute ou modifie un livre.
     * On sait si l'livre est un nouvel livre car son id sera -1.
     * @param livre $livre : l'livre à ajouter ou modifier.
     * @return void
     */
    public function addOrUpdatelivre(Livre $livre): void
    {
        if ($livre->getId() == -1) {
            $this->addlivre($livre);
        } else {
            $this->updatelivre($livre);
        }
    }

    /**
     * Ajoute un livre.
     * @param livre $livre : le livre à ajouter.
     * @return void
     */
    public function addlivre(Livre $livre): void
    {
        $sql = "INSERT INTO livre (id_user, title, content, date_creation) VALUES (:id_user, :title, :content, NOW())";
        $this->db->query($sql, [
            'id_user' => $livre->getIdUser(),
            'title' => $livre->getTitre(),
            'content' => $livre->getContent()
        ]);
    }

    /**
     * Modifie un livre.
     * @param livre $livre : l'livre à modifier.
     * @return void
     */
    public function updatelivre(Livre $livre): void
    {
        $sql = "UPDATE livre SET title = :title, content = :content, date_update = NOW() WHERE id = :id";
        $this->db->query($sql, [
            'title' => $livre->getTitre(),
            'content' => $livre->getContent(),
            'id' => $livre->getId()
        ]);
    }

    /**
     * Supprime un livre.
     * @param int $id : l'id de l'livre à supprimer.
     * @return void
     */
    public function deletelivre(int $id): void
    {
        $sql = "DELETE FROM livre WHERE id = :id";
        $this->db->query($sql, ['id' => $id]);
    }
    /**
     * Recherche un livre par son titre
     */
    public function searchLivresByTitle(string $query): array
    {
        $sql = "SELECT * FROM livre WHERE titre LIKE :q";
        $result = $this->db->query($sql, [
            'q' => '%' . $query . '%'
        ]);

        $livres = [];
        while ($livre = $result->fetch()) {
            $livres[] = new Livre($livre);
        }
        return $livres;
    }
    /**
     * récupère les livres d'un utilisateur
     */
    public function getLivresByUserId(int $userId): array
{
    $sql = "SELECT * FROM livre WHERE id_user = :id_user ORDER BY id DESC";
    $res = $this->db->query($sql, ['id_user' => $userId]);

    $livres = [];
    while ($row = $res->fetch()) {
        $livres[] = new Livre($row);
    }
    return $livres;
}
}
