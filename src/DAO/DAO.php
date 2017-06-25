<?php

namespace Projet3\DAO;

use Doctrine\DBAL\Connection;

abstract class DAO
{
    /**
     * Connexion à la base
     *
     * @var \Doctrine\DBAL\Connection
     */
    private $db;

    /**
     * Constructeur
     *
     * @param \Doctrine\DBAL\Connection The database connection object
     */
    public function __construct(Connection $db) {
        $this->db = $db;
    }

    /**
     * Accorde l'accès à l'objet de connexion à la base de données
     *
     * @return \Doctrine\DBAL\Connection The database connection object
     */
    protected function getDb() {
        return $this->db;
    }

    /**
     * Crée un objet de domaine à partir d'une ligne DB.
     * Doit être remplacé par les classes d'enfants.
     */
    protected abstract function buildDomainObject(array $row);
}
