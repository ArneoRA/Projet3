<?php
// Retourne tous les episodes
  function getEpisodes(){
      require_once '../app/config/prod.php';

      try // Il essaye de se connecter à la BDD php avec le USER php et le MDP 1234
        {
          $bdd = new PDO('mysql:host='.$host_name.';dbname='.$database,$user_name,$password);
          $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } // Si il y a des erreurs, il rentre dans le bloc catch
        catch (Exception $e)
        {
                die('Erreur : ' . $e->getMessage()); // on arrete l'execution de la page en affichant un message décrivant l'erreur
        }
        $episodes = $bdd->query('select * from episodes order by id desc');
        return $episodes;
  }



