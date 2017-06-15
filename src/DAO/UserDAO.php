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
     * Returns a user matching the supplied id.
     *
     * @param integer $id The user id.
     *
     * @return \Projet3\Domain\User|throws an exception if no matching user is found
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
     * Returns a list of all users, sorted by role and name.
     *
     * @return array A list of all users.
     */
    public function findAll() {
        $sql = "select * from utilisateurs order by user_role, user_name";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $entities = array();
        foreach ($result as $row) {
            $id = $row['user_id'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }

    /**
     * Saves a user into the database.
     *
     * @param \Projet3\Domain\User $user The user to save
     */
    public function save(User $user) {
        $userData = array(
            'user_name' => $user->getUsername(),
            'user_salt' => $user->getSalt(),
            'user_password' => $user->getPassword(),
            'user_role' => $user->getRole()
            );

        if ($user->getId()) {
            // The user has already been saved : update it
            $this->getDb()->update('utilisateurs', $userData, array('user_id' => $user->getId()));
        } else {
            // The user has never been saved : insert it
            $this->getDb()->insert('utilisateurs', $userData);
            // Get the id of the newly created user and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $user->setId($id);
        }
    }

    /**
     * Removes a user from the database.
     *
     * @param @param integer $id The user id.
     */
    public function delete($id) {
        // Delete the user
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
     * Creates a User object based on a DB row.
     *
     * @param array $row The DB row containing User data.
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
