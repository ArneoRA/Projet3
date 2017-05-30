<?php
// Retourne tous les episodes
  function getEpisodes(){
      require_once '../app/config/prod.php';
      // TEST AVEC LE CODE DONNE PAR 1AND1
      // $host_name  = "db684093681.db.1and1.com";
      // $database   = "db684093681";
      // $user_name  = "dbo684093681";
      // $password   = "Projet3Blog";

      try // Il essaye de se connecter à la BDD php avec le USER php et le MDP 1234
        {
          $bdd = new PDO('mysql:host='.$host_name. ';dbname='.$database, $user_name, $password);
          $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } // Si il y a des erreurs, il rentre dans le bloc catch
        catch (Exception $e)
        {
                die('Erreur : ' . $e->getMessage()); // on arrete l'execution de la page en affichant un message décrivant l'erreur
        }
        $episodes = $bdd->query('select * from billets order by id desc');
        return $episodes;
  }



