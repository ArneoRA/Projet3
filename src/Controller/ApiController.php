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
      error_log('Je passe par la bonne route');
      $comment = $app['dao.comment']->find($id);
      $app['dao.comment']->spamC($comment);

      return $app->json($comment, 200);  // 200 = OK
    }


  }


?>
