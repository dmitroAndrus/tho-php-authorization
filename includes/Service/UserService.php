<?php

/**
 * This file contains UserService class.
 * PHP version 7.4
 *
 * @category Service
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Service;

use ThoPHPAuthorization\User\UserInterface;
use ThoPHPAuthorization\Data\Name\StrictNameTrait;
use ThoPHPAuthorization\Service\HTTPService;
use ThoPHPAuthorization\Source\UserSourceInterface;
use ThoPHPAuthorization\Source\UserKeepInterface;

/**
 * UserService is a class, that contains functionality to work with users.
 */
class UserService
{
    use StrictNameTrait;

    /**
     * Keep session on signing out user.
     *
     * When set to false - session will be terminated and all session data will be lost.
     * Set to true if you need to store session data.
     *
     * @var UserSourceInterface
     */
    public static $keepSession = false;

    /**
     * Source to get users from.
     *
     * @var UserSourceInterface
     */
    protected $userSource;

    /**
     * Currently active user.
     *
     * @var UserInterface|null
     */
    protected $activeUser = null;

    /**
     * User keep duration.
     *
     * @var string
     */
    protected $keepDuration = '+1 month';

    /**
     * Constructor.
     *
     * @param UserSourceInterface $source - Source to get users.
     * @param string $name - Service name, used to store it data in session/cookies.
     * @param UserSourceInterface $source - Users source.
     *
     * @return void
     */
    public function __construct($name, UserSourceInterface $source)
    {
        // Initialize session.
        HTTPService::initSession();
        $this->name = $name;
        $this->userSource = $source;
        $this->restoreActiveUser();
    }

    /**
     * Try to get active user.
     *
     * @return boolean
     */
    public function getActiveUser()
    {
        return ($this->activeUser instanceof UserInterface)
            ? $this->activeUser
            : null;
    }

    /**
     * Try to restore active user.
     *
     * @return boolean
     */
    protected function restoreActiveUser()
    {
        return $this->restoreFromSession()
            || $this->restoreKeeped();
    }

    /**
     * Try to restore user from the session.
     *
     * @return boolean
     */
    protected function restoreFromSession()
    {
        if (isset($_SESSION["{$this->getName()}_uath"])) {
            $user = $this->userSource->getByID($_SESSION["{$this->getName()}_uath"]);
            if ($user instanceof UserInterface) {
                return $this->signIn($user);
            } else {
                unset($_SESSION["{$this->getName()}_uath"]);
            }
        }
        return false;
    }

    /**
     * Get user by identity.
     *
     * @return UserInterface|null
     */
    public function getByIdentity($identity)
    {
        return $this->userSource->getByIdentity($identity);
    }

    /**
     * Check if can authorize user.
     *
     * @param mixed|UserInterface $user - User.
     * @param mixed $identity - User identity.
     * @param mixed $security - User security data.
     *
     * @return boolean - Authorization result.
     */
    protected function canAuthorize($user, $identity, $security)
    {
        return ($user instanceof UserInterface)
            && $user->canAuthorize($identity, $security);
    }

    /**
     * Authorize user by identity and security.
     *
     * Keep signed in is possible only if $this->userSource is of UserKeepInterface.
     *
     * @param mixed $identity - User identity.
     * @param mixed $security - User security data.
     * @param mixed $keep_signed - Keep user signed in.
     *
     * @return boolean - Authorization result.
     */
    public function authorize($identity, $security, $keep_signed = false)
    {
        $user = $this->getByIdentity($identity);
        return $this->canAuthorize($user, $identity, $security)
            && $this->signIn($user, $keep_signed);
    }

    /**
     * Sign up user.
     *
     * @param mixed $data - User data.
     *
     * @return boolean - Sign up result.
     */
    public function signUp($data)
    {
        // Create user.
        $user = $this->userSource->create($data);
        if (!$user) {
            return false;
        }
        return $this->userSource->store($user);
    }

    /**
     * Sign in user.
     *
     * Keep in mind that provided user should be re-attainable from $this->userSource.
     * Keep signed in is possible only if $this->userSource is of UserKeepInterface.
     *
     * @param UserInterface $user - User.
     * @param mixed $keep_signed - Keep user signed in.
     *
     * @return boolean - Sign in result.
     */
    public function signIn(UserInterface $user, $keep_signed = false)
    {
        $active = $this->getActiveUser();
        if ($active) {
            // If active user is the same - skip.
            if ($user->checkIdentity($active->getIdentity())) {
                return true;
            }
            // Sign out active user.
            $this->signOut();
        }
        $_SESSION["{$this->getName()}_uath"] = $user->getID();

        if ($keep_signed) {
            $this->keep($user);
        }
        $this->activeUser = $user;
        return true;
    }

    /**
     * Sign out active user.
     *
     * @return boolean - Sign out result.
     */
    public function signOut()
    {
        $active = $this->getActiveUser();
        if (!$active) {
            return true;
        }
        if (static::$keepSession) {
            // Remove only user indentifier.
            HTTPService::removeSessionValue("{$this->getName()}_uath");
        } else {
            // Terminate session and all session data.
            HTTPService::endSession();
        }

        // Release previously keeped user, if any.
        $this->releaseKeeped();

        $this->activeUser = null;
        return true;
    }

    /**
     * Keep user.
     *
     * @param UserInterface $user - User.
     *
     * @return boolean - Sign out result.
     */
    public function keep($user)
    {
        if (!($this->userSource instanceof UserKeepInterface)) {
            return false;
        }

        // Release previously keeped user, if any.
        $this->releaseKeeped();

        $valid_until = strtotime($this->keepDuration, time());
        $security = $this->userSource->keep($user, $valid_until, $this->getName());
        if ($security === false) {
            return false;
        }
        setcookie("{$this->getName()}_uath", $security, $valid_until, '/');
        return true;
    }

    /**
     * Try to restore user from the data source.
     *
     * @return boolean
     */
    protected function restoreKeeped()
    {
        if (
            ($this->userSource instanceof UserKeepInterface)
            && isset($_COOKIE["{$this->getName()}_uath"])
        ) {
            $user = $this->userSource->restoreKeeped($_COOKIE["{$this->getName()}_uath"]);
            if ($user instanceof UserInterface) {
                return $this->signIn($user);
            } else {
                unset($_COOKIE["{$this->getName()}_uath"]);
            }
        }
        return false;
    }

    /**
     * Try to release keeped user from the data source.
     *
     * @return boolean
     */
    protected function releaseKeeped()
    {
        if (
            ($this->userSource instanceof UserKeepInterface)
            && isset($_COOKIE["{$this->getName()}_uath"])
        ) {
            return $this->userSource->releaseKeeped($_COOKIE["{$this->getName()}_uath"]);
        }
        return false;
    }
}
