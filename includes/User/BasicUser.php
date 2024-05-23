<?php

/**
 * This file contains BasicUser class.
 * PHP version 7.4
 *
 * @category User
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\User;

use ThoPHPAuthorization\User\AbstractUser;
use ThoPHPAuthorization\Data\ID\HasIDInterface;
use ThoPHPAuthorization\Data\ID\OnceIDTrait;
use ThoPHPAuthorization\Data\Name\HasNameInterface;
use ThoPHPAuthorization\Data\Name\NameTrait;
use ThoPHPAuthorization\Data\Password\HasPasswordInterface;
use ThoPHPAuthorization\Data\Password\BcryptPasswordTrait;

/**
 * BasicUser is a class that provides basic user authorization functionality with name and password.
 */
class BasicUser extends AbstractUser implements HasNameInterface, HasPasswordInterface, HasIDInterface
{
    use OnceIDTrait;
    use NameTrait;
    use BcryptPasswordTrait;

    /**
     * Constructor.
     *
     * @param array $data - User data.
     *
     * @return void.
     */
    public function __construct(array $data = [])
    {
        // Set User ID.
        if (isset($data['id']) && !empty($data['id'])) {
            $this->setID($data['id']);
        }
        // Set User Name.
        if (isset($data['name']) && !empty($data['name'])) {
            $this->setName($data['name']);
        }
        // Set User security key directly or password (convert to security key).
        if (isset($data['security']) && !empty($data['security'])) {
            $this->setSecurity($data['security']);
        } elseif (isset($data['password']) && !empty($data['password'])) {
            $this->setPassword($data['password']);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setIdentity($identity)
    {
        return $this->setName($identity);
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentity()
    {
        return $this->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function setSecurity($security)
    {
        return $this->setPassword($security, false);
    }

    /**
     * {@inheritdoc}
     */
    public function getSecurity()
    {
        return $this->getPassword();
    }

    /**
     * {@inheritdoc}
     */
    public function checkIdentity($identity)
    {
        return $this->getName() === $identity;
    }

    /**
     * {@inheritdoc}
     */
    public function checkSecurity($security)
    {
        return $this->checkPassword($security);
    }
}
