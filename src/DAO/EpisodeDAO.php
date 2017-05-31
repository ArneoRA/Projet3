<?php

namespace Projet3\DAO;

use Doctrine\DBAL\Connection;
use Projet3\Domain\Episode;

class EpisodeDAO
{
    /**
     * Database connection
     *
     * @var \Doctrine\DBAL\Connection
     */
    private $db;

    /**
     * Constructor
     *
     * @param \Doctrine\DBAL\Connection The database connection object
     */
    public function __construct(Connection $db) {
        $this->db = $db;
    }

    /**
     * Return a list of all articles, sorted by date (most recent first).
     *
     * @return array A list of all articles.
     */
    public function findAll() {
        $sql = "select * from episodes order by id desc";
        $result = $this->db->fetchAll($sql);

        // Convert query result to an array of domain objects
        $episodes = array();
        foreach ($result as $row) {
            $episodeId = $row['id'];
            $episodes[$episodeId] = $this->buildEpisode($row);
        }
        return $episodes;
    }

    /**
     * Creates an Article object based on a DB row.
     *
     * @param array $row The DB row containing Article data.
     * @return \MicroCMS\Domain\Article
     */
    private function buildEpisode(array $row) {
        $episode = new Episode();
        $episode->setId($row['id']);
        $episode->setTitre($row['titre']);
        $episode->setContenu($row['contenu']);
        $episode->setDateCrea($row['dateCrea']);
        $episode->setDateModif($row['dateModif']);
        $episode->setValided($row['valided']);
        return $episode;
    }
}
