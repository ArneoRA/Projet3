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
     * Saves a comment into the database.
     *
     * @param \Projet3\Domain\Comment $comment The comment to save
     */
    public function save(Comment $comment) {
        $commentData = array(
            'epID' => $comment->getEpisode()->getId(),
            'pseudo' => $comment->getPseudo(),
            'message' => $comment->getContenu()
            );

        if ($comment->getIdcom()) {
            // The comment has already been saved : update it
            $this->getDb()->update('commentaires', $commentData, array('idcom' => $comment->getId()));
        } else {
            // The comment has never been saved : insert it
            $this->getDb()->insert('commentaires', $commentData);
            // Get the id of the newly created comment and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $comment->setIdcom($id);
        }
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

        if (array_key_exists('ep_ID', $row)) {
            // Find and set the associated episode
            $episodeId = $row['art_id'];
            $episode = $this->episodeDAO->find($episodeId);
            $comment->setEpisode($episode);
        }

        return $comment;
    }
}
