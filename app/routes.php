<?php


  use Symfony\Component\HttpFoundation\Request;
  use Projet3\Domain\Comment;
  use Projet3\Form\Type\CommentType;

  // Home page
  $app->get('/', function () use ($app) {
      $episodes = $app['dao.episode']->findAll();
      return $app['twig']->render('index.html.twig', array('episodes' => $episodes));
  })->bind('home');

  // Episode details with comments
  $app->match('/episode/{id}', function ($id, Request $request) use ($app) {
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
        $commentFormView = $commentForm->createView();
        $comments = $app['dao.comment']->findAllByEpisode($id);
        return $app['twig']->render('episode.html.twig', array(
          'episode' => $episode,
          'comments' => $comments,
          'commentForm' => $commentFormView));
  })->bind('episode');

?>
