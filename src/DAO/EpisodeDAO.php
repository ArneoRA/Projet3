<?php

namespace Projet3\DAO;

use Silex\Application;
use Projet3\Domain\Episode;

class EpisodeDAO extends DAO
{
    /**
     * Renvoie une liste de tous les episodes, triés par id (les plus récents en premier).
     *
     * @return un tableau d'une liste de tous les episodes
     */
    public function findAll() {
        $sql = "select * from episodes order by id desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convertie le resultat de larequete en un tableau d'objets
        $episodes = array();
        foreach ($result as $row) {
            $episodeId = $row['id'];
            $episodes[$episodeId] = $this->buildDomainObject($row);
        }
        return $episodes;
    }

    /**
     * Renvoie un épisode correspondant à l'identifiant fourni.
     *
     * @param integer $id
     *
     * @return \Projet3\Domain\Episode ou une exception si aucun episode n'est trouvé
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
     * Renvoie un episode correspondant à l'identifiant du commentaire
     *
     * @param integer $id
     *
     * @return \Projet3\Domain\Episode| ou une exception si aucun episode n'est trouvé
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
     * Sauvegarde un episode dans la base
     *
     * @param \Projet3\Domain\Episode
     */
    public function save(Episode $episode, Application $app) {

        $app['monolog']->addInfo("je suis dans la méthode save");
        // var_dump($episodeData['contenu']);

        if ($episode->getId()) {
            // L'épisode a déjà été enregistré --> Mise à jour
            $episodeData = array(
            'titre' => $episode->getTitre(),
            'contenu' => $episode->getContenu(),
            'dateCrea' => $episode->getDateCrea(),
            'dateModif' => date("Y-m-d H:i:s")
            );
            $this->getDb()->update('episodes', $episodeData, array('id' => $episode->getId()));
        } else {
            // L'épisode n'a jamais été enregistré --> insertion
            $episodeData = array(
            'titre' => $episode->getTitre(),
            'contenu' => $episode->getContenu(),
            'dateCrea' => date("Y-m-d H:i:s")
            );
            if (!isset($episodeData['contenu'])) {
                throw new \Exception('Le contenu est null, donc impossible d\'enregistrer le contenu');
                die();
            }
            $this->getDb()->insert('episodes', $episodeData);
            // On récupére le dernier identifiant enregistré
            $id = $this->getDb()->lastInsertId();
            $episode->setId($id);
        }
    }

    /**
     * Suppression d'un episode de la BD.
     *
     * @param integer $id The episode id.
     */
    public function delete($id) {
        // Supprime l'episode
        $this->getDb()->delete('episodes', array('id' => $id));
    }

    /**
     * Création d'un objet Episode basé sur les champs de la BD
     *
     * @param array $row contenant les données de l'episode
     *
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
