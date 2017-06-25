<?php

namespace Projet3\DAO;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Projet3\Domain\User;

class UserDAO extends DAO implements UserProviderInterface
// UserProviderInterface : Cette interface contient les méthodes nécessaires pour qu'une classe puisse être utilisée comme fournisseur de données utilisateur par le composant de gestion de la sécurité de Symfony au cours du processus d'authentification.
{
    /**
     * Renvoie l'utilisateur correspondant à l'identifiant passé en paramétre.
     *
     * @param integer Identifiant de l'utilisateur
     *
     * @return \Projet3\Domain\User| ou une exception si pas d'utilisateur trouvé
     */
    public function find($id) {
        $sql = "select * from utilisateurs where user_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No user matching id " . $id);
    }

    /**
     * Renvoie une liste de tous les utilisateurs trié par role et nom.
     *
     * @return Tableau contenant la liste des utilisateurs
     */
    public function findAll() {
        $sql = "select * from utilisateurs order by user_role, user_name";
        $result = $this->getDb()->fetchAll($sql);

        // Convertie le resultat de la requete en un tableau d'objets du domaine
        $entities = array();
        foreach ($result as $row) {
            $id = $row['user_id'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }

    /**
     * Sauvegarde d'un utilisateur dans la base.
     *
     * @param \Projet3\Domain\User
     */
    public function save(User $user) {
        $userData = array(
            'user_name' => $user->getUsername(),
            'user_salt' => $user->getSalt(),
            'user_password' => $user->getPassword(),
            'user_role' => $user->getRole()
            );

        if ($user->getId()) {
            // Si l'utilisateur existe déjà : Mise à jour
            $this->getDb()->update('utilisateurs', $userData, array('user_id' => $user->getId()));
        } else {
            // Sinon : Insertion (création)
            $this->getDb()->insert('utilisateurs', $userData);
            // On récupére le dernier identifiant enregistré
            $id = $this->getDb()->lastInsertId();
            $user->setId($id);
        }
    }

    /**
     * Suppression d'un utilisateur de la BD
     *
     * @param @param integer Identifiant de l'utilisateur
     */
    public function delete($id) {
        // On supprime l'utilisateur
        $this->getDb()->delete('utilisateurs', array('user_id' => $id));
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username)
    {
        $sql = "select * from utilisateurs where user_name=?";
        $row = $this->getDb()->fetchAssoc($sql, array($username));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $username));
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }
        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return 'Projet3\Domain\User' === $class;
    }

    /**
     * Creation d'un objet User basé sur les éléments de la BD
     *
     * @param Varaible $row (tableau) contenant les données d'un utilisateurt.
     * @return \Projet3\Domain\User
     */
    protected function buildDomainObject(array $row) {
        $user = new User();
        $user->setId($row['user_id']);
        $user->setUsername($row['user_name']);
        $user->setPassword($row['user_password']);
        $user->setSalt($row['user_salt']);
        $user->setRole($row['user_role']);
        return $user;
    }
}
