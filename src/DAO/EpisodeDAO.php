<?php

namespace Projet3\DAO;

use Projet3\Domain\Episode;

class EpisodeDAO extends DAO
{
    /**
     * Return a list of all articles, sorted by date (most recent first).
     *
     * @return array A list of all articles.
     */
    public function findAll() {
        $sql = "select * from episodes order by id desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $episodes = array();
        foreach ($result as $row) {
            $episodeId = $row['id'];
            $episodes[$episodeId] = $this->buildDomainObject($row);
        }
        return $episodes;
    }

    /**
     * Returns an episode matching the supplied id.
     *
     * @param integer $id
     *
     * @return \Projet3\Domain\Episode|throws an exception if no matching episode is found
     */
    public function find($id) {
        $sql = "select * from episodes where id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No episode matching id " . $id);
    }


    /**
     * Creates an Article object based on a DB row.
     *
     * @param array $row The DB row containing Article data.
     * @return \MicroCMS\Domain\Article
     */
    protected function buildDomainObject(array $row) {
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
