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
     * Returns an episode matching the idcom Comment.
     *
     * @param integer $id
     *
     * @return \Projet3\Domain\Episode|throws an exception if no matching episode is found
     */
    public function findComm($id) {
        $sql = "select * FROM episodes inner join commentaires on episodes.id = commentaires.epID where commentaires.idcom = ?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No episode matching with Comment id " . $id);
    }




    /**
     * Saves an episode into the database.
     *
     * @param \Projet3\Domain\Episode $episode The episode to save
     */
    public function save(Episode $episode) {
        $episodeData = array(
            'titre' => $episode->getTitre(),
            'contenu' => $episode->getContenu(),
            );

        if ($episode->getId()) {
            // The episode has already been saved : update it
            $this->getDb()->update('episodes', $episodeData, array('id' => $episode->getId()));
        } else {
            // The episode has never been saved : insert it
            $this->getDb()->insert('episodes', $episodeData);
            // Get the id of the newly created episode and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $episode->setId($id);
        }
    }

    /**
     * Removes an episode from the database.
     *
     * @param integer $id The episode id.
     */
    public function delete($id) {
        // Delete the episode
        $this->getDb()->delete('episodes', array('idcom' => $id));
    }


    /**
     * Creates an Episode object based on a DB row.
     *
     * @param array $row The DB row containing Episode data.
     * @return \Projet3\Domain\Episode
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
