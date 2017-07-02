<?php

  namespace Projet3\Controller;

  use Silex\Application;
  use Symfony\Component\HttpFoundation\Request;
  use Projet3\Domain\Episode;

  class ApiController {

    /**
     * Controleur API pour signaler un commentaire
     *
     * @param int $id Identifiant du Commentaire à signaler
     * @param Application $app Application Silex
     */
    public function signalCommentAction ($id, Application $app){
      $app['monolog']->addInfo("Je passe par la route signalCommentAction");
      $comment = $app['dao.comment']->find($id);
      $comment = $app['dao.comment']->spamC($comment, $app);
      return $app->json($comment, 200);  // 200 = OK
    }


  }


?>
