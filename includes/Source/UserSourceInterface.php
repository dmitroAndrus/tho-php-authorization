<?php

/**
 * This file contains UserSourceInterface interface.
 * php version 7.4
 *
 * @category User
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

namespace ThoPHPAuthorization\Source;

use ThoPHPAuthorization\User\UserInterface;

/**
 * UserSourceInterface is an interface, it declares a possibility to get users from outerspace, probably Database.
 */
interface UserSourceInterface
{
    /**
     * Get user by ID.
     *
     * @param mixed $id User ID.
     *
     * @return UserInterface|null
     */
    public function getByID($id);

    /**
     * Get user by identity.
     *
     * @param mixed $identity User identity.
     *
     * @return UserInterface|null
     */
    public function getByIdentity($identity);

    /**
     * Validate user data.
     *
     * @param array $data User data.
     *
     * @return boolean User is valid or not.
     */
    public function validateData($data);

    /**
     * Create user.
     *
     * @param array $data User data.
     *
     * @return UserInterface|null
     */
    public function create($data);

    /**
     * Check if such user exists.
     *
     * @param UserInterface $user User object.
     *
     * @return boolean User exists or not.
     */
    public function userExists(UserInterface $user);

    /**
     * Check if user is unique.
     *
     * When `$data` is provides, checks if user with such `$data` is unique.
     * Can be used when editing user, to make sure new user data is unique and can be updated.
     *
     * @param UserInterface $user User object.
     * @param array|null $data User alternative data.
     *
     * @return boolean User exists or not.
     */
    public function userUnique(UserInterface $user, $data = null);

    /**
     * Store user.
     *
     * @param UserInterface $user User object.
     * @param boolean $renew Renew user object.
     *
     * @return boolean Storing successful or not.
     */
    public function store(UserInterface &$user, $renew = true);

    /**
     * Edit user.
     *
     * @param UserInterface $user User object.
     * @param array|null $data User data.
     * @param boolean $renew Renew user object.
     *
     * @return boolean Editing successful or not.
     */
    public function edit(UserInterface &$user, $data = null, $renew = true);

    /**
     * Remove user.
     *
     * @param UserInterface $user User object.
     *
     * @return boolean Remove successful or not.
     */
    public function remove($user);
}
