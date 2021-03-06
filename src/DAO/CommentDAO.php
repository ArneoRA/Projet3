<?php

namespace Projet3\DAO;

use Projet3\Domain\Comment;

class CommentDAO extends DAO
{
    /**
     * @var $episodeDAO
     */
    private $episodeDAO;

    public function setEpisodeDAO(EpisodeDAO $episodeDAO){
        $this->episodeDAO = $episodeDAO;
    }

    /**
     * @var \Projet3\DAO\UserDAO
     */
    private $userDAO;

    public function setUserDAO(UserDAO $userDAO) {
        $this->userDAO = $userDAO;
    }

    /**
     * Renvoie la liste des commentaires trié par idcom (le plus récent en premier.
     *
     * @return Tableau contenant l'ensemble des commentaires.
     */
    public function findAll() {
        $sql = "select * from commentaires order by idcom desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convertie le resultat de la requete en un tableau d'objet
        $entities = array();
        foreach ($result as $row) {
            $id = $row['idcom'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }



    /**
     * Renvoie la liste des commentaires pour un episode donné trié par idcom.
     *
     * @param integer Identifiant de l'episode
     *
     * @return Tableau contenant la liste des commentaires pour un episode.
     */
    public function findAllByEpisode($episodeId) {
        // L'épisode associé est récupéré une seule fois
        $episode = $this->episodeDAO->find($episodeId);

        $sql = "select * from commentaires where epID=? order by idcom";
        $result = $this->getDb()->fetchAll($sql, array($episodeId));

        // Convertie le resultat de requete en un tableau d'objet du domaine
        $comments = array();
        foreach ($result as $row) {
            $comId = $row['idcom'];
            $comment = $this->buildDomainObject($row);
            // L'épisode associé est défini pour le commentaire construit
            $comment->setEpisode($episode);
            $comments[] = $comment;
        }
        // Tableau qui va nous permettre d'imbriquer les commentaires
        $comment_by_id=[];
        // Avec cette boucle, nous avons un tableau des commentaires indexés par leur ID et non par un index défini par défaut
        foreach ($comments as $comment){
            $comment_by_id[$comment->getIdcom()] = $comment;
        }
        // On parcours à nouveau tous les commentaires en gardant l'index $k
        foreach ($comments as $k => $comment) {
            // On vérifie d'abord si le commentaire est une réponse à un commentaire
            // Si la valeur de parent_id est différent de zero alors c'est une réponse
            if($comment->getParentid() !=0){
            // On l'ajoute donc dans l'enfant (children) du commentaire en cours.
              $comment_by_id[$comment->getParentid()]->addChildren($comment);
            // On supprime les sous commentaires que nous venons de déplacer
              unset($comments[$k]);
            }
        }
        return $comments;
    }

    /**
     * Renvoie le commentaire correspondant à l'identifiant passé en paramétre.
     *
     * @param integer $id The comment id
     *
     * @return \Projet3\Domain\Comment| ou renvoie une exception si pas de commentaire trouvé
     */
    public function find($id) {
        $sql = "select * from commentaires where idcom=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));
        error_log('je suis dans la methode find()');
        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No comment matching id " . $id);
    }

    /**
     * SAuvegarde un commentaire dans la BD.
     *
     * @param @param Comment
     */
    public function save(Comment $comment){
        $varNiv = 0;
        if ($comment->getParentid() != 0){
            $varNiv = $comment->getNiveau() + 1;
        }
        $commentData = array(
            'message' =>$comment->getContenu(),
            'parent_id' =>$comment->getParentid(),
            'niveau' => $varNiv,
            'epID' => $comment->getEpisode()->getId(),
            'user_id' =>$comment->getAuthor()->getId()

            );
        if ($comment->getIdcom()){
            // Le commentaire existe déjà : Mise à jour
            $this->getDb()->update('commentaires', $commentData, array('idcom' => $comment->getIdcom()));
        } else{
            // Le commentaire n'existe pas : Insertion
            $this->getDb()->insert('commentaires', $commentData);
            // On récupére le dernier identifiant enregistré
            $id = $this->getDb()->lastInsertId();
            $comment->setIdcom($id);
        }
    }

    /**
     * Signaler un commentaire (spam)
     *
     * @param Comment
     */
    public function spamC(Comment $comment){
        $newValeur = $comment->getSpam() + 1;
        $commentData = array(
            'spam' =>$newValeur);
        error_log('je suis dans la méthode spamC()');
        error_log('Test $newValeur :' .$newValeur);
        // error_log('Test $comment->getIdcom' .var_dump('Test $comment->getIdcom : '.$comment->getIdcom()));
        $this->getDb()->update('commentaires', $commentData, array('idcom' => $comment->getIdcom()));

    }


    /**
     * Suppression de tous les commentaires d'un episode donné
     *
     * @param L'identifiant de l'episode
     */
    public function deleteAllByEpisode($episodeId) {

        $this->getDb()->delete('commentaires', array('epID' => $episodeId));
    }


    /**
     * Suppression d'un commentaire de la BD
     *
     * @param Identifiant du commentaire en question
     */
    public function delete($id) {
        // Supprime les commentaires enfants en premier lieu
        $this->getDb()->delete('commentaires', array('parent_id'=> $id));
        // Puis on supprime le commentaire en question
        $this->getDb()->delete('commentaires', array('idcom' => $id));
    }


    /**
     * Suppression de tous les commentaires d'un utilisateur
     *
     * @param integer Identifiant de l'utilisateur
     */
    public function deleteAllByUser($userId) {
        $this->getDb()->delete('commentaires', array('user_id' => $userId));
    }


    /**
     * Creation d'un objet Commentiare basé sur les champs de la BD
     *
     * @param Tableau contenant les champs et les valeurs pour la BD
     * @return \Projet3\Domain\Comment
     */
    protected function buildDomainObject(array $row) {
        $comment = new Comment();
        $comment->setIdcom($row['idcom']);
        $comment->setContenu($row['message']);
        $comment->setDateCreat($row['dateCreat']);
        $comment->setParentid($row['parent_id']);
        $comment->setNiveau($row['niveau']);
        $comment->setSpam($row['spam']);

        try{
          if (array_key_exists('epID', $row)) {
            // On trouve et on définit l'episode associé
            $episodeId = $row['epID'];
            $episode = $this->episodeDAO->find($episodeId);
            $comment->setEpisode($episode);
            }
        } catch (exception $e){
            die('Souci au niveau du lien avec Episode : ' . $e->getMessage());

        }

        try{
          if (array_key_exists('user_id', $row)) {
            // On trouve et on définit l'utilisateur associé
            $userId = $row['user_id'];
            $user = $this->userDAO->find($userId);
            $comment->setAuthor($user);
            }
        } catch (exception $e){
            die('Souci au niveau du lien avec User: ' . $e->getMessage());
        }

        return $comment;
    }
}
