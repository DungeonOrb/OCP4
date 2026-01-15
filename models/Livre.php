<?php

/**
 * Entité livre, un livre est défini par les champs
 * id, id_user, title, content, date_creation, date_update,
 */
class Livre extends AbstractEntity
{
    private string $titre = "";
    private string $auteur = "";
    private string $content = "";
    private string $image = "";
    private int $idUser;
    private int $dispo = 1;

    private string $Nom = "";

    /**
     * Setter pour l'id de l'utilisateur. 
     * @param int $idUser
     */
    public function setIdUser(int $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * Getter pour l'id de l'utilisateur.
     * @return int
     */
    public function getIdUser(): int
    {
        return $this->idUser;
    }

    /**
     * Setter pour le titre.
     * @param string $titre
     */
    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }

    /**
     * Getter pour le titre.
     * @return string
     */
    public function getTitre(): string
    {
        return $this->titre;
    }

    /**
     * Setter pour le contenu.
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
    public function setAuteur(string $auteur): void
    {
        $this->auteur = $auteur;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }
    public function setDispo(int $dispo): void
    {
        $this->dispo = $dispo;
    }
        public function setVendeurNom(string $Nom): void
    {
        $this->Nom = $Nom;
    }



    /**
     * Getter pour le contenu.
     * Retourne les $length premiers caractères du contenu.
     * @param int $length : le nombre de caractères à retourner.
     * Si $length n'est pas défini (ou vaut -1), on retourne tout le contenu.
     * Si le contenu est plus grand que $length, on retourne les $length premiers caractères avec "..." à la fin.
     * @return string
     */
    public function getContent(int $length = -1): string
    {
        if ($length > 0) {
            // Ici, on utilise mb_substr et pas substr pour éviter de couper un caractère en deux (caractère multibyte comme les accents).
            $content = mb_substr($this->content, 0, $length);
            if (strlen($this->content) > $length) {
                $content .= "...";
            }
            return $content;
        }
        return $this->content;
    }
    public function getImage(): string
    {
        return $this->image;
    }
    public function getAuteur(): string
    {
        return $this->auteur;
    }
    public function getVendeur(): int
    {
        return $this->idUser;
    }
    public function getDispo(): int
    {
        return $this->dispo;
    }
    
    public function getVendeurNom(): string
    {
        return $this->Nom;
    }
}
