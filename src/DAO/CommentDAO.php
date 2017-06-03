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
     * Returns a list of all comments, sorted by date (most recent first).
     *
     * @return array A list of all comments.
     */
    public function findAll() {
        $sql = "select * from commentaires order by idcom desc";
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
     * Save a comment from the database.
     *
     * @param @param Comment
     */
    public function save(Comment $comment){
        $commentData = array(
            'message' =>$comment->getContenu(),
            'epID' => $comment->getEpisode()->getId(),
            'user_id' =>$comment->getAuthor()->getId()

            );
        if ($comment->getIdcom()){
            // The comment has already been saved : update it
            $this->getDb()->update('commentaires', $commentData, array('idcom' => $comment->getIdcom()));
        } else{
            // The comment has never been saved : insert it
            $this->getDb()->insert('commentaires', $commentData);
            // Get the id of the newly created comment and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $comment->setIdcom($id);
        }
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
        // Delete the comment
        $this->getDb()->delete('commentaires', array('idcom' => $id));
    }

    /**
     * Removes all comments for a user
     *
     * @param integer $userId The id of the user
     */
    public function deleteAllByUser($userId) {
        $this->getDb()->delete('commentaires', array('user_id' => $userId));
    }

    /**
     * Creates a Comment object based on a DB row.
     *
     * @param array $row The DB row containing Comment data.
     * @return \Projet3\Domain\Comment
     */
    protected function buildDomainObject(array $row) {
        $comment = new Comment();
        $comment->setIdcom($row['idcom']);
        // $comment->setPseudo($row['pseudo']);
        $comment->setContenu($row['message']);
        $comment->setDateCreat($row['dateCreat']);
        $comment->setParentid($row['parent_id']);

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

        try{
          if (array_key_exists('user_id', $row)) {
            // Find and set the associated author
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
