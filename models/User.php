<?php

/**
 * Entité User : un user est défini par son id, un email et un password.
 */ 
class User extends AbstractEntity 
{
    private string $nom;
    private string $email;
    private string $password;

    /**
     * Setter pour le login.
     * @param string $login
     */
    public function setEmail(string $email) : void 
    {
        $this->email = $email;
    }

    /**
     * Getter pour le login.
     * @return string
     */
    public function getEmail() : string 
    {
        return $this->email;
    }

    /**
     * Setter pour le password.
     * @param string $password
     */
    public function setPassword(string $password) : void 
    {
        $this->password = $password;
    }

    /**
     * Getter pour le password.
     * @return string
     */
    public function getPassword() : string 
    {
        return $this->password;
    }

    public function setNom(string $nom) : void 
    {
        $this->nom = $nom;
    }

    /**
     * Getter pour le nom.
     * @return string
     */
    public function getNom() : string 
    {
        return $this->nom;
    }
    
}