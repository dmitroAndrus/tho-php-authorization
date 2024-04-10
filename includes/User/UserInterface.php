<?php

/**
 * User interface.
 * PHP version 7.4
 *
 * @category User
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\User;

use ThoPHPAuthorization\Data\ID\HasIDInterface;

/**
 * User interface to define basic user related methods.
 */
interface UserInterface extends HasIDInterface
{
    /**
     * Get user identity.
     *
     * Can be used to identify user, i.e. on sign in, store/restore from session, etc.
     * Can be name, nickname, email, phone, etc.
     *
     * @return mixed User identity.
     */
    public function getIdentity();

    /**
     * Set user identity.
     *
     * Can be used to identify user, i.e. on sign in, store/restore from session, etc.
     * Can be encoded password, some service security key, etc.
     *
     * @param mixed $security - User security data.
     *
     * @return mixed User security data.
     */
    public function setSecurity($security);

    /**
     * Get user security key.
     *
     * Can be used to identify user, i.e. on sign in, store/restore from session, etc.
     * Can be encoded password, some service security key, etc.
     *
     * @return mixed User security data.
     */
    public function getSecurity();

    /**
     * Check user identity.
     *
     * Used to identify user, i.e. on sign in, restoring from session, etc.
     * Can be name, nickname, email, phone, etc., depending on Your needs.
     *
     * @param mixed $identity - User identity.
     *
     * @return boolean Identity check pass result.
     */
    public function checkIdentity($identity);

    /**
     * Check user security data.
     *
     * Used to identify user, i.e. on sign in, restoring from session, etc.
     * Can be encoded password, some service security key, etc.
     *
     * @param mixed $security - User security data.
     *
     * @return boolean Security check pass result.
     */
    public function checkSecurity($security);

    /**
     * Check if user can authorize.
     *
     * Used to identify user, i.e. on sign in, restoring from session, etc.
     *
     * @param mixed $identity - User identity.
     * @param mixed $security - User security data.
     *
     * @return mixed Can authorize or not.
     */
    public function canAuthorize($identity, $security);
}
