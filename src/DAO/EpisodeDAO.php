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
     * @param Episode $episode Objet episode
     */
    public function save(Episode $episode) {
        error_log('je suis dans la méthode save');
        $episodeData = array(
            'titre' => $episode->getTitre(),
            'contenu' => $episode->getContenu(),
            );
        // var_dump($episodeData['contenu']);
        if (!isset($episodeData['contenu'])) {
            throw new \Exception('Le contenu est null, donc impossible d\'enregistrer le contenu');
            die();

        }

        if ($episode->getId()) {
            // L'épisode a déjà été enregistré --> Mise à jour
            $this->getDb()->update('episodes', $episodeData, array('id' => $episode->getId()));
        } else {
            // L'épisode n'a jamais été enregistré --> insertion
            $this->getDb()->insert('episodes', $episodeData);
            // On récupére le dernier identifiant enregistré
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
