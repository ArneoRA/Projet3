<?php

namespace Projet3\Domain;


class Comment
{
  /**
   * Comment idcom.
   *
   * @var integer
   */
  private $idcom;

  /**
   * Comment pseudo.
   *
   * @var string
   */
  // private $pseudo;

  /**
   * Comment message.
   *
   * @var string
   */
  private $contenu;

  /**
   * Comment dateCrea.
   *
   * @var date
   */
  private $dateCreat;

  /**
   * Comment parentid.
   *
   * @var integer
   */
  private $parentid;

  /**
   * Associated Episode.
   *
   * @var \Projet3\Domain\Episode
   */
  private $episode;
  /**
   * Associated author.
   *
   * @var \Projet3\Domain\User
   */
  private $author;


/** ============================ GETTERS ========================================= */
  public function getIdcom(){
    return $this->idcom;
  }

  // public function getPseudo(){
  //   return $this->pseudo;
  // }

  public function getContenu(){
    return $this->contenu;
  }

  public function getDateCreat(){
    return $this->dateCreat;
  }

  public function getParentid(){
    return $this->parentid;
  }

  public function getEpisode(){
    return $this->episode;
  }

  public function getAuthor(){
    return $this->author;
  }

/** ============================ SETTERS ========================================= */
  public function setIdcom($idcom){
    $this->idcom = $idcom;
    return $this;
  }

  // public function setPseudo($pseudo){
  //   $this->pseudo = $pseudo;
  //   return $this;
  // }

  public function setContenu($contenu){
    $this->contenu = $contenu;
    return $this;
  }

  public function setDateCreat($dateCreat){
    $this->dateCreat = $dateCreat;
    return $this;
  }

  public function setParentid($parentid){
    $this->parentid = $parentid;
    return $this;
  }

  public function setEpisode(Episode $episode){
    $this->episode = $episode;
    return $this;
  }

  public function setAuthor(User $author) {
        $this->author = $author;
        return $this;
    }


}






 ?>
