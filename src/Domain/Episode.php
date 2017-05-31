<?php

namespace Projet3\Domain;


class Episode
{
  /**
   * Episode id.
   *
   * @var integer
   */
  private $id;

  /**
   * Episode titre.
   *
   * @var string
   */
  private $titre;

  /**
   * Episode contenu.
   *
   * @var string
   */
  private $contenu;

  /**
   * Episode dateCrea.
   *
   * @var date
   */
  private $dateCrea;

  /**
   * Episode dateModif.
   *
   * @var date
   */
  private $dateModif;

  /**
   * Episode valided.
   *
   * @var integer
   */
  private $valided;


/** ============================ GETTERS ========================================= */
  public function getId(){
    return $this->id;
  }

  public function getTitre(){
    return $this->titre;
  }

  public function getContenu(){
    return $this->contenu;
  }

  public function getDateCrea(){
    return $this->dateCrea;
  }

  public function getDateModif(){
    return $this->dateModif;
  }

  public function getValided(){
    return $this->valided;
  }

/** ============================ SETTERS ========================================= */
  public function setId($id){
    $this->id = $id;
    return $this;
  }

  public function setTitre($titre){
    $this->titre = $titre;
    return $this;
  }

  public function setContenu($contenu){
    $this->contenu = $contenu;
    return $this;
  }

  public function setDateCrea($dateCrea){
    $this->dateCrea = $dateCrea;
    return $this;
  }

  public function setDateModif($dateModif){
    $this->dateModif = $dateModif;
    return $this;
  }

  public function setValided($valided){
    $this->valided = $valided;
    return $this;
  }



}






 ?>
