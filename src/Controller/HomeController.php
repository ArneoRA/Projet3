<?php

  namespace Projet3\Controller;

  use Silex\Application;
  use Symfony\Component\HttpFoundation\Request;
  use Projet3\Domain\Comment;
  use Projet3\Domain\Episode;
  use Projet3\Domain\User;
  use Projet3\Form\Type\CommentType;


  class Homecontroller {
    /**
      * Controleur Home page
      *
      * @param Application $app Application Silex
    */
    public function indexAction(Application $app){
      $episodes = $app['dao.episode']->findAll();
      return $app['twig']->render('index.html.twig', array('episodes' => $episodes));
    }

    /**
     * Controleur Detail de l'episode avec les commentaires
     *
     * @param int $id correspondant à l'identifiant de l episode
     * @param Request $request Requete transmise
     * @param Application $app Application Silex
     */
    public function episodeAction($id, Request $request, Application $app){
      $episode = $app['dao.episode']->find($id);
      $commentFormView = null;
      $comment = new Comment();
      $comment->setEpisode($episode);

      $commentForm = $app['form.factory']->create(CommentType::class, $comment);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $app['dao.comment']->save($comment);
            $app['session']->getFlashBag()->add('success', 'Votre commentaire a été ajouté avec succes.');


        }
        // Réinitialisation du formulaire commentaire
        $comment = new Comment();
        $commentForm = $app['form.factory']->create(CommentType::class, $comment);
        $commentFormView = $commentForm->createView();
        $comments = $app['dao.comment']->findAllByEpisode($id);
        return $app['twig']->render('episode.html.twig', array(
          'episode' => $episode,
          'comments' => $comments,
          'commentForm' => $commentFormView));
    }

    /**
     * Controleur User Login
     *
     * @param Request $request Requete transmise
     * @param Application $app Application Silex
     */
    public function loginAction (Request $request, Application $app){
      return $app['twig']->render('login.html.twig', array(
          'error'         => $app['security.last_error']($request),
          'last_username' => $app['session']->get('_security.last_username'),
      ));
    }

    /**
     * Controleur pour repondre à un commentaire
     *
     * @param int $id Identifiant de l'episode
     * @param Request $request Requete transmise
     * @param Application $app Application Silex
     */
    public function repCommAction($id, Request $request, Application $app){
      $comment = $app['dao.comment']->find($id);
      $comment = $app['dao.comment']->save($comment);
      $episode = $app['dao.episode']->findComm($id);
      $comments = $app['dao.comment']->findAllByEpisode($id);
      // Réinitialisation du formulaire commentaire
      $comment = new Comment();
      $commentForm = $app['form.factory']->create(CommentType::class, $comment);

      return $app['twig']->render('episode.html.twig', array(
          'episode' => $episode,
          'comments' => $comments,
          'commentForm' => $commentForm->createView()));
    }


  }

?>
