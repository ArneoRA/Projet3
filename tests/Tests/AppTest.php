<?php

namespace Projet3\Tests;

require_once __DIR__.'/../../vendor/autoload.php';

use Silex\WebTestCase;

class AppTest extends WebTestCase
{
    /**
     * Test fonctionnel de base basé sur les meilleures pratiques de Symfony.
     * Vérification du bon chargement de toutes les URL de l'application.
     * Pendant l'exécution du test, cette méthode est appelée pour chaque URL.
     * @dataProvider provideUrls
     */
    public function testPageIsSuccessful($url)
    {
        $client = $this->createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * {@inheritDoc}
     */
    public function createApplication()
    {
        $app = new \Silex\Application();

        require __DIR__.'/../../app/config/dev.php';
        require __DIR__.'/../../app/app.php';
        require __DIR__.'/../../app/routes.php';

        // Génére des exceptions brutes au lieu de pages HTML si des erreurs se produisent
        unset($app['exception_handler']);
        // Simulation des sessions pour test
        $app['session.test'] = true;
        // Active l'accès anonyme à la zone d'administration
        $app['security.access_rules'] = array();

        return $app;
    }

    /**
     * cette méthode fournit la liste de toutes les URLs à tester
     *
     * @return un tableau contenant la liste des URLs à tester.
     */
    public function provideUrls()
    {
        return array(
            array('/'),
            array('/episode/1'),
            array('/login'),
            array('/episode/1/response/add'),
            array('/admin'),
            array('/admin/episode/add'),
            array('/admin/episode/1/edit'),
            array('/admin/comment/1/edit'),
            array('/admin/user/add'),
            array('/admin/user/1/edit'),
            array('/api/comment/1/spam')
            );
    }
}
