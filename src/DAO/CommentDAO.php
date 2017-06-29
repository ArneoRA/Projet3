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
     * Returns a list of all comments, sorted by date (most recent first).
     *
     * @return array A list of all comments.
     */
    public function findAll() {
        $sql = "select * from commentaires order by spam desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $entities = array();
        foreach ($result as $row) {
            $id = $row['idcom'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }

    /**
     * Return a list of all comments for an episode, sorted by date (most recent first).
     *
     * @param integer $episodeId The episode id.
     *
     * @return array A list of all comments for the episode.
     */
    public function findAllByEpisode($episodeId) {
        // The associated episode is retrieved only once
        $episode = $this->episodeDAO->find($episodeId);

        // ep_ID is not selected by the SQL query
        // The episode won't be retrieved during domain objet construction
        $sql = "select * from commentaires where epID=? order by idcom";
        $result = $this->getDb()->fetchAll($sql, array($episodeId));

        // Convert query result to an array of domain objects
        $comments = array();
        foreach ($result as $row) {
            $comId = $row['idcom'];
            $comment = $this->buildDomainObject($row);
            // The associated episode is defined for the constructed comment
            $comment->setEpisode($episode);
            $comments[$comId] = $comment;
        }
        $comment_by_id=[];
        // Avec cette boucle, nous avons un tableau des commentaires indexés par leur ID et non par un index défini par défaut
        foreach ($comments as $comment){ // Je parcours tous les commentaires $comments
            $comment_by_id[$comment->getIdcom()] = $comment;
        }
        // On parcours à nouveau tous les commentaires en gardant l'index $k
        foreach ($comments as $k => $comment) {
            // On vérifie d'abord si le commentaire est une réponse à un commentaire
            // Si la valeur de parent_id est différent de zero alors c'est une réponse
            if($comment->getParentid() !=0){
            // On l'ajoute donc dans l'enfant (children) du commentaire en cours.
              $comment_by_id[$comment->getParentid()]->addChildren($comment);
            // On masque les sous commentaires que nous venons de déplacer
              unset($comments[$k]);
            }
        }
        return $comments;
    }


    /**
     * Returns a comment matching the supplied id.
     *
     * @param integer $id The comment id
     *
     * @return \Projet3\Domain\Comment|throws an exception if no matching comment is found
     */
    public function find($id) {
        $sql = "select * from commentaires where idcom=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No comment matching id " . $id);
    }


    /**
     * Saves a comment into the database.
     *
     * @param \Projet3\Domain\Comment $comment The comment to save
     */
    public function save(Comment $comment) {
        $varNiv = 0;
        if ($comment->getParentid() != 0){
            $varNiv = $comment->getNiveau() + 1;
        }
        $commentData = array(
            'message' =>$comment->getContenu(),
            'parent_id' =>$comment->getParentid(),
            'niveau' => $varNiv,
            'epID' => $comment->getEpisode()->getId(),
            'pseudo' =>$comment->getPseudo()

            );
        if ($comment->getIdcom()) {
            // The comment has already been saved : update it
            $this->getDb()->update('commentaires', $commentData, array('idcom' => $comment->getIdcom()));
        } else {
            // The comment has never been saved : insert it
            $this->getDb()->insert('commentaires', $commentData);
            // Get the id of the newly created comment and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $comment->setIdcom($id);
        }
    }


    /**
     * Signal a spam comment from the database.
     *
     * @param @param Comment
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
     * Removes all comments for an episode
     *
     * @param $episodeId The id of the episode
     */
    public function deleteAllByEpisode($episodeId) {
        $this->getDb()->delete('commentaires', array('ep_ID' => $episodeId));
    }


    /**
     * Removes a comment from the database.
     *
     * @param @param integer $id The comment id
     */
    public function delete($id) {
        // Delete the comments children
        $this->getDb()->delete('commentaires', array('parent_id'=> $id));
        // Delete the comment
        $this->getDb()->delete('commentaires', array('idcom' => $id));
    }


    /**
     * Creates a Comment object based on a DB row.
     *
     * @param array $row The DB row containing Comment data.
     * @return \MicroCMS\Domain\Comment
     */
    protected function buildDomainObject(array $row) {
        $comment = new Comment();
        $comment->setIdcom($row['idcom']);
        $comment->setPseudo($row['pseudo']);
        $comment->setContenu($row['message']);
        $comment->setDateCreat($row['dateCreat']);
        $comment->setParentid($row['parent_id']);
        $comment->setNiveau($row['niveau']);
        $comment->setSpam($row['spam']);

        try{
          if (array_key_exists('epID', $row)) {
            // Find and set the associated episode
            $episodeId = $row['epID'];
            $episode = $this->episodeDAO->find($episodeId);
            $comment->setEpisode($episode);
            }
        } catch (exception $e){
            die('Souci au niveau du lien avec Episode : ' . $e->getMessage());

        }

        return $comment;
    }
}
